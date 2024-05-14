<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 16.04.24
 * Time: 16:01
 */

namespace App\Library\Billing\Services\Apple;

use Carbon\Carbon;
use Firebase\JWT\JWT;

class JwtTokenGenerator
{
    public string $alg = 'ES256';
    public string $type = 'JWT';

    public string $aud = 'appstoreconnect-v1';

    public function __construct(
        private readonly string $key_id,
        private readonly string $issure_id,
        private readonly string $bundle_id,
        private readonly string $file_path_private_key,
    ) {
    }

    public function generate(): string
    {
        return JWT::encode(
            $this->getPayload(),
            file_get_contents($this->file_path_private_key),
            $this->alg,
            null,
            $this->getHeader()
        );
    }

    private function getPayload(): array
    {
        return [
            'iss' => $this->issure_id,
            'iat' => Carbon::now()->timestamp,
            'exp' => Carbon::now()->addMinutes(15)->timestamp,
            'aud' => $this->aud,
            'bid' => $this->bundle_id
        ];
    }

    private function getHeader(): array
    {
        return [
            'alg' => $this->alg,
            'kid' => $this->key_id,
            'typ' => $this->type
        ];
    }
}
