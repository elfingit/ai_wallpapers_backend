<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 12:02
 */

namespace App\Library\Billing\Services;

use App\Library\Core\Logger\LoggerChannel;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class GoogleService
{
    const TOKEN_URL = 'https://oauth2.googleapis.com/token';
    const PURCHASE_URL = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/products/%s/tokens/%s';

    private string $refresh_token;
    private string $client_id;

    private string $package_name = 'com.nuntechs.aiwallpaper';
    private string $client_secret;

    private ?string $access_token = null;

    private LoggerInterface $logger;
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();

        $this->refresh_token = config('google.refresh_token');
        $this->client_id = config('google.client_id');
        $this->client_secret = config('google.client_secret');
        $this->logger = \LoggerService::getChannel(LoggerChannel::GOOGLE_PURCHASE);

        $this->access_token = $this->getAccessToken();
    }

    public function getPurchase()
    {

    }

    private function getAccessToken(): ?string
    {
        $token = \Cache::get('google_access_token');

        if ($token) {
            return $token;
        }
        try {
            $response = $this->httpClient->request(
                'POST',
                self::TOKEN_URL,
                [
                    'form_params' => [
                        'client_id' => $this->client_id,
                        'client_secret' => $this->client_secret,
                        'refresh_token' => $this->refresh_token,
                        'grant_type' => 'refresh_token'
                    ]
                ]
            );

            $data = json_decode($response->getBody()->getContents(), true);
            $expired = Carbon::now()->addSeconds($data['expires_in']);
            \Cache::set('google_access_token', $data['access_token'], $expired);

            return $data['access_token'];
        } catch (\Throwable $th) {
            $this->logger->error(
                'Failed to get access token',
                ['extra' => [
                    'error' => $th->getMessage(),
                    'trace' => $th->getTraceAsString(),
                    'file' => __FILE__,
                    'line' => __LINE__
                ]]
            );
        }

        return null;
    }
}
