<?php

declare(strict_types=1);

namespace App\UseCases\User;

use App\Mail\SendInvitationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class StoreAction
{
    public function __invoke(User $user): User
    {
        assert(! $user->exists);

        $user->save();

        $url = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ],
        );

        Mail::send(new SendInvitationMail($user));

        return $user;
    }
}
