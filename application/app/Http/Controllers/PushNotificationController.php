<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use App\Models\PushSubscription;

class PushNotificationController extends Controller
{
    /**
     * Simpan subscription push user
     */
    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|url',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
            'content_encoding' => 'nullable|string',
        ]);

        $user = $request->user();

        PushSubscription::updateOrCreate(
            ['endpoint' => $request->endpoint],
            [
                'public_key' => $request->keys['p256dh'],
                'auth_token' => $request->keys['auth'],
                'content_encoding' => $request->content_encoding,
                'subscribable_type' => get_class($user),
                'subscribable_id' => $user->id,
            ]
        );

        return response()->json(['message' => 'Push subscription berhasil disimpan!']);
    }

    public function unsubscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|url',
        ]);

        $user = $request->user();

        PushSubscription::where('endpoint', $request->endpoint)
            ->where('subscribable_type', get_class($user))
            ->where('subscribable_id', $user->id)
            ->delete();

        return response()->json([
            'message' => 'Push subscription berhasil dihapus'
        ]);
    }

    /**
     * Kirim push percobaan
     */
    public function testPush(Request $request)
    {
        $user = $request->user();

        $subscriptions = PushSubscription::where('subscribable_type', get_class($user))
            ->where('subscribable_id', $user->id)
            ->get();

        if ($subscriptions->isEmpty()) {
            return response()->json([
                'message' => '❌ Push notification belum aktif. Silakan aktifkan terlebih dahulu.'
            ], 400);
        }

        $payload = json_encode([
            'title' => 'Notifikasi Push berhasil!',
            'body' => 'Push Notification anda telah berhasil diaktifkan 💡',
            'icon' => '/favicon.ico',
        ]);

        $auth = [
            'VAPID' => [
                'subject' => env('VAPID_SUBJECT'),
                'publicKey' => env('VAPID_PUBLIC_KEY'),
                'privateKey' => env('VAPID_PRIVATE_KEY'),
            ],
        ];

        $webPush = new WebPush($auth);

        foreach ($subscriptions as $sub) {

            $subscription = Subscription::create([
                'endpoint' => $sub->endpoint,
                'publicKey' => $sub->public_key,
                'authToken' => $sub->auth_token,
                'contentEncoding' => $sub->content_encoding,
            ]);

            $report = $webPush->sendOneNotification(
                $subscription,
                $payload
            );

            // 🔥 AUTO CLEANUP SUBSCRIPTION MATI
            if ($report->isSubscriptionExpired()) {
                PushSubscription::where('endpoint', $sub->endpoint)->delete();
            }
        }

        return response()->json([
            'message' => '✅ Notifikasi berhasil dikirimkan!'
        ]);
    }
}
