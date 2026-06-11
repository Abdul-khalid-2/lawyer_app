<?php

namespace App\Policies;

use App\Models\LegalCase;
use App\Models\User;

class LegalCasePolicy
{
    /**
     * Lawyer owns the case.
     */
    public function manage(User $user, LegalCase $case): bool
    {
        return $user->lawyer && $case->lawyer_id === $user->lawyer->id;
    }

    /**
     * Client may view their own case when it is marked visible.
     */
    public function view(User $user, LegalCase $case): bool
    {
        if ($this->manage($user, $case)) {
            return true;
        }

        return $user->client
            && $case->client_id === $user->client->id
            && $case->is_visible_to_client;
    }
}
