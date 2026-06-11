<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    /**
     * Lawyer owns the client record.
     */
    public function manage(User $user, Client $client): bool
    {
        return $user->lawyer && $client->lawyer_id === $user->lawyer->id;
    }
}
