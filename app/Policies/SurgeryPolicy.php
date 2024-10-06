<?php

namespace App\Policies;

//declare(strict_types=1);

use App\Models\Surgery;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SurgeryPolicy
{
    
    
    public function update(User $user, Surgery $surgery): bool
    {
        //return  $surgery->user()->is($user);
        return $user->id === $surgery->user_id;
    }

    
}
