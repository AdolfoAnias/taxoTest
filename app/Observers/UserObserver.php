<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\File;

class UserObserver
{
    /**
     * Handle the User "updating" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updating(User $user)
    {
    }

    public function creating(User $user)
    {
        
    }
    
    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
    }
}
