<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 23.01.24
 * Time: 19:08
 */

namespace App\Library\Auth\Results;

use App\Models\User;
use Elfin\LaravelCommandBus\Contracts\CommandBus\CommandResultContract;

class AuthResult implements CommandResultContract
{
    public function __construct(
        private string $token,
        private User $user,
    )
    {
    }

    public function getResult(): array
    {
        return [
            'token' => $this->token,
            'role' => $this->user->role->title_slug,
        ];
    }
}
