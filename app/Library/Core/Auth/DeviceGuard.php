<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.04.24
 * Time: 11:52
 */

namespace App\Library\Core\Auth;

use App\Models\User;
use App\Models\UserDevice;
use App\Models\UserDeviceToken;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class DeviceGuard implements Guard
{
    private ?UserDevice $device = null;
    private ?User $user = null;
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function check()
    {
        if (is_null($this->device) || is_null($this->user)) {
            $this->user();
        }

        if (!is_null($this->user)) {
            return true;
        }

        return !is_null($this->device);
    }

    public function guest()
    {
        return is_null($this->device);
    }

    public function user()
    {


        $device_token  = $this->authDeviceToken();

        if ($device_token) {
            $deviceToken = UserDeviceToken::findToken($device_token);

            if ($deviceToken) {
                $this->device = $deviceToken->userDevice;
                $this->device->withAccessToken($deviceToken);
                $deviceToken->forceFill(['last_used_at' => now()])->save();
            }
        }

        $user_token = $this->userDeviceToken();

        if ($user_token) {
            list($id, $token) = explode('|', $user_token);

            $personalAccessToken = PersonalAccessToken::findToken($token);

            if ($personalAccessToken) {
                $this->user = $personalAccessToken->tokenable;
                $this->user->withAccessToken($personalAccessToken);
                $personalAccessToken->forceFill(['last_used_at' => now()])->save();
            }
        }

        if (!is_null($this->user)) {
            return $this->user;
        }

        if (!is_null($this->device)) {
            return $this->device;
        }

        return null;
    }

    public function id()
    {
        if (!is_null($this->user)) {
            return $this->user->id;
        }

        if (!is_null($this->device)) {
            return $this->device->uuid;
        }
    }

    public function validate(array $credentials = [])
    {
        dd(__METHOD__);
    }

    public function hasUser()
    {
        dd(__METHOD__);
    }

    public function setUser(Authenticatable $user)
    {
        dd(__METHOD__);
    }

    protected function authDeviceToken(): ?string
    {
        return $this->headerToken('Device');
    }

    private function userDeviceToken(): ?string
    {
        return $this->headerToken('Bearer');
    }

    private function headerToken(string $token_type): ?string
    {
        $header = $this->request->header('Authorization', '');

        $position = strrpos($header, $token_type . ' ');

        if ($position !== false) {
            $header = substr($header, $position + 7);
            return str_contains($header, ',') ? strstr($header, ',', true) : $header;
        }

        return null;
    }
}
