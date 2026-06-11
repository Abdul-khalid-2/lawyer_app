<?php

namespace App\Policies;

use App\Models\TeamMember;
use App\Models\User;

class TeamMemberPolicy
{
    /**
     * Lawyer owns the team member.
     */
    public function manage(User $user, TeamMember $teamMember): bool
    {
        return $user->lawyer && $teamMember->lawyer_id === $user->lawyer->id;
    }
}
