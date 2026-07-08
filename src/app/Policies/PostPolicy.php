<?php

namespace App\Policies;

use App\Models\Cafe;
use App\Models\User;

class PostPolicy
{
    /**
     * カフェを編集できるか（投稿者本人のみ）
     */
    public function update(User $user, Cafe $cafe): bool
    {
        return $user->id === $cafe->user_id;
    }

    /**
     * カフェを削除できるか（投稿者本人 or 管理者）
     */
    public function delete(User $user, Cafe $cafe): bool
    {
        return $user->id === $cafe->user_id || $user->is_admin;
    }
}
