<?php
namespace App\Extensions;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class SuspendedEloquentUserProvider extends EloquentUserProvider
{
    /**
     * Ambil user berdasarkan ID (Wajib dimodifikasi agar mendukung Soft Delete).
     */
    public function retrieveById($identifier)
    {
        $model = $this->createModel();

        // Gunakan withTrashed agar Auth Guard tetap mengenali user yang ditangguhkan
        return $this->newModelQuery($model)
            ->withTrashed() 
            ->where($model->getAuthIdentifierName(), $identifier)
            ->first();
    }

    /**
     * Ambil user berdasarkan token "remember me" (Jika Anda menggunakan fitur ini).
     */
    public function retrieveByToken($identifier, $token)
    {
        $model = $this->createModel();

        $model = $this->newModelQuery($model)
            ->withTrashed()
            ->where($model->getAuthIdentifierName(), $identifier)
            ->first();

        if (! $model) {
            return null;
        }

        $rememberToken = $model->getRememberToken();

        return $rememberToken && hash_equals($rememberToken, $token) ? $model : null;
    }
}