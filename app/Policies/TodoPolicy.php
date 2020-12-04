<?php

namespace App\Policies;

use App\Models\Todo;
use App\Models\User;

class TodoPolicy
{
    public function update(User $user, Todo $topic)
    {
        return $user->isAuthorOf($topic);
    }

    public function destroy(User $user, Todo $topic)
    {
        return $user->isAuthorOf($topic);
    }
}
