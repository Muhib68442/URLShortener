<?php

namespace App\Policies;

use App\Models\Url;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UrlPolicy
{
    // VIEW / UPDATE / DELETE 
    public function manage(User $user, Url $url)
    {
        // users.id === urls.user_id
        return $user->id === $url->user_id;
    }
}
