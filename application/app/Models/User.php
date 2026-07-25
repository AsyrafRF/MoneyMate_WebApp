<?php

namespace App\Models;

use App\Mail\EmailOtpVerification;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasPushSubscriptions, SoftDeletes;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
        'google_id',
        'google_email',
        'profile_photo',
        'saldo',
        'is_active',
        'email_verified_at',
        'last_login',
        'email_otp',
        'email_otp_expires_at',
        'email_otp_attempts',
        'subscription_plan',
        'subscription_until',
        'is_premium',
        'is_subscribed',
    ];

    /**
     * Hidden attributes.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_otp',
    ];

    /**
     * Attributes appended to JSON.
     */
    protected $appends = [
        'saldo_rupiah',
        'total_saldo',
        'photo_url',
        'subscription_days_left',
        'is_premium',
    ];

    /**
     * Attribute casting.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at'     => 'datetime',
            'password'              => 'hashed',
            'last_login'            => 'datetime',
            'subscription_until'    => 'datetime',

            'is_active'             => 'boolean',
            'is_premium'            => 'boolean',

            'saldo'                 => 'decimal:0',

            'email_otp_attempts'    => 'integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function keuangans()
    {
        return $this->hasMany(Keuangan::class);
    }

    /**
     * Relasi ke model Anggaran (Satu user bisa punya banyak anggaran)
     */
    public function anggarans()
    {
        return $this->hasMany(Anggaran::class, 'user_id');
    }

    /**
     * Relasi ke model Tujuan (Satu user bisa punya banyak tujuan/tabungan)
     */
    public function tujuans()
    {
        return $this->hasMany(Tujuan::class, 'user_id');
    }

    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class);
    }

    public function premiumTransactions()
    {
        return $this->hasMany(PremiumTransaction::class);
    }

    public function agreements()
    {
        return $this->hasMany(UserAgreement::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function redeemedCodes()
    {
        return $this->belongsToMany(RedeemCode::class, 'redeem_code_user');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    protected function saldoRupiah(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp ' . number_format($this->saldo, 0, ',', '.'),
        );
    }

    protected function totalSaldo(): Attribute
    {
        return Attribute::make(
            get: fn () =>
                $this->keuangans()
                    ->where('jenis', 'Pemasukan')
                    ->sum('jumlah')
                -
                $this->keuangans()
                    ->where('jenis', 'Pengeluaran')
                    ->sum('jumlah')
        );
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {

                if ($this->profile_photo) {

                    // Google URL
                    if (str_starts_with($this->profile_photo, 'http')) {
                        return $this->profile_photo;
                    }

                    // Local storage
                    return asset('storage/' . $this->profile_photo);
                }

                // Default avatar
                return asset('images/moneymate-user.png');
            }
        );
    }

    protected function isPremium(): Attribute
    {
        return Attribute::make(
            get: fn ($value) =>
                $value &&
                (
                    !$this->subscription_until ||
                    now()->lte($this->subscription_until)
                )
        );
    }

    protected function subscriptionDaysLeft(): Attribute
    {
        return Attribute::make(
            get: fn () =>
                $this->subscription_until
                    ? max(
                        0,
                        (int) now()->diffInDays(
                            $this->subscription_until,
                            false
                        )
                    )
                    : 0
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActiveLastDays($query, int $days = 7)
    {
        return $query
            ->whereNotNull('last_login')
            ->where('last_login', '>=', now()->subDays($days));
    }

    /*
    |--------------------------------------------------------------------------
    | Password Reset
    |--------------------------------------------------------------------------
    */

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /*
    |--------------------------------------------------------------------------
    | OTP
    |--------------------------------------------------------------------------
    */

    public function generateEmailOtp(): void
    {
        $otp = random_int(100000, 999999);

        $this->update([
            'email_otp'                => Hash::make($otp),
            'email_otp_expires_at'     => now()->addMinutes(10),
            'email_otp_attempts'       => 0,
        ]);

        Mail::to($this->email)
            ->queue(new EmailOtpVerification($otp));
    }

    public function verifyEmailOtp(string $otp): string
    {
        if (
            !$this->email_otp_expires_at ||
            now()->greaterThan($this->email_otp_expires_at)
        ) {
            return 'expired';
        }

        if ($this->email_otp_attempts >= 5) {
            return 'locked';
        }

        if (!Hash::check($otp, $this->email_otp)) {

            $this->increment('email_otp_attempts');

            return 'invalid';
        }

        return 'valid';
    }

    public function clearEmailOtp(): void
    {
        $this->update([
            'email_otp'                => null,
            'email_otp_expires_at'     => null,
            'email_otp_attempts'       => 0,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Subscription & Limits
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah transaksi melebihi limit saldo.
     */
    public function isExceedingLimit(
        float|int $amount,
        string $jenis
    ): bool {

        // Premium bebas limit
        if ($this->is_premium) {
            return false;
        }

        $limit = 6_000_000;

        $saldoPrediksi = $jenis === 'Pemasukan'
            ? $this->saldo + $amount
            : $this->saldo - $amount;

        return (
            $saldoPrediksi > $limit ||
            $saldoPrediksi < -$limit
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Saldo
    |--------------------------------------------------------------------------
    */

    public function hitungUlangSaldo(): static
    {
        $saldoBaru =
            $this->keuangans()
                ->where('jenis', 'Pemasukan')
                ->sum('jumlah')
            -
            $this->keuangans()
                ->where('jenis', 'Pengeluaran')
                ->sum('jumlah');

        // Silent update
        $this->newQuery()
            ->where('id', $this->id)
            ->update([
                'saldo' => $saldoBaru,
            ]);

        $this->saldo = $saldoBaru;

        return $this;
    }

    /*
    |--------------------------------------------------------------------------
    | Agreements & Feedback
    |--------------------------------------------------------------------------
    */

    public function hasCompletedTerms(): bool
    {
        return UserAgreement::hasAcceptedAll($this->id);
    }

    public function hasAcceptedTerms(): bool
    {
        return UserAgreement::hasAcceptedAll($this->id);
    }

    public function hasSubmittedFeedback(): bool
    {
        return $this->feedbacks()->exists();
    }
}