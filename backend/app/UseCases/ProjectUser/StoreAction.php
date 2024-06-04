<?php

declare(strict_types=1);

namespace App\UseCases\ProjectUser;

use App\Exceptions\AlreadyRegisteredUserInvitedException;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class StoreAction
{
    /**
     * @param  array<string, mixed>  $validated
     */
    public function __invoke(Project $project, array $validated): Collection
    {
        $invitedUsers = $validated['users'];
        foreach ($invitedUsers as $user_id) {
            $isProjectUser = $project->users()->wherePivot('user_id', $user_id)->exists();
            if ($isProjectUser) {
                throw new AlreadyRegisteredUserInvitedException('招待済みのユーザは、再度招待できません');
            }
            $project->users()->attach($user_id, ['id' => Str::uuid()->toString()]);
        }

        $users = $project->users;

        return $users;
    }
}
