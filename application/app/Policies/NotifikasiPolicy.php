<?php

namespace App\Policies;

use App\Models\Notifikasi;
use App\Models\User;

class NotifikasiPolicy
{
    /**
     * User hanya boleh melihat notifikasinya sendiri.
     */
    public function view(User $user, Notifikasi $notif): bool
    {
        return $notif->user_id === $user->id;
    }

    public function update(User $user, Notifikasi $notif): bool
    {
        return $notif->user_id === $user->id;
    }

    public function delete(User $user, Notifikasi $notif): bool
    {
        return $notif->user_id === $user->id;
    }
}
