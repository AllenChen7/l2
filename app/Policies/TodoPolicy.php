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

    /**
     * 已完成的不可被修改
     * @param User $user
     * @param Todo $todo
     * @return bool
     */
    public function edit(User $user, Todo $todo)
    {
        if ($todo->status) {
            return false;
        }

        return $user->isAuthorOf($todo);
    }
}
