<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 26.04.24
 * Time: 11:52
 */

namespace App\Library\Core\Auth;

use App\Models\UserDevice;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class DeviceGuard implements Guard
{
    private ?UserDevice $device = null;
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function check()
    {
        if (is_null($this->device)) {
            $this->user();
        }
        return !is_null($this->device);
    }

    public function guest()
    {
        return is_null($this->device);
    }

    public function user()
    {
        if (is_null($this->device) && $this->request->hasHeader('X-Device-Id')) {
            $this->device = UserDevice::where('uuid', $this->request->header('X-Device-Id'))->first();
        }

        return $this->device;
    }

    public function id()
    {
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
}
