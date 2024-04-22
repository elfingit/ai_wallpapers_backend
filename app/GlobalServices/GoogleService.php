<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 6.04.24
 * Time: 12:02
 */

namespace App\GlobalServices;

use App\Library\Core\Logger\LoggerChannel;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class GoogleService
{
    const TOKEN_URL = 'https://oauth2.googleapis.com/token';
    const PURCHASE_URL = 'https://androidpublisher.googleapis.com/androidpublisher/v3/applications/%s/purchases/products/%s/tokens/%s';

    const FCM_URL = 'https://fcm.googleapis.com/v1/projects/ai-wallpapers-417722/messages:send';
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

    public function getPurchase(string $product_id, string $purchase_token): ?array
    {
        $url = sprintf(self::PURCHASE_URL, $this->package_name, $product_id, $purchase_token);
        try {
            $response = $this->httpClient->request(
                'GET',
                $url,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->access_token,
                    ]
                ]
            );

            return json_decode($response->getBody()->getContents(), true);

        } catch (\Throwable $th) {
            $this->logger->error(
                'Failed to get purchase',
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

    public function sendPush(): void
    {
        $this->logger->info('sending push', [
            'extra' => [
                'file' => __FILE__,
                'line' => __LINE__
            ]
        ]);

        try {
            $response = $this->httpClient->request(
                'POST',
                self::FCM_URL,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->access_token,
                        'Content-Type'  => 'application/json'
                    ],
                    'json'    => [
                        'validate_only' => false,
                        'message'       => [
                            'android'      => [
                                'data' => [
                                    'title' => 'notification_title',
                                    'body'  => 'notification_message',
                                ],
                            ],
                            'apns'         => [
                                'headers' => [
                                    'apns-priority' => '10',
                                ],
                                'payload' => [
                                    'aps'       => [
                                        'alert' => [
                                            'title-loc-key' => 'NOTIFICATION_TITLE',
                                            'loc-key'       => 'NOTIFICATION_MESSAGE',
                                        ],
                                        'sound' => 'default',
                                    ],
                                    'messageID' => 'new_free_images'
                                ],
                            ],
                            'topic'        => 'new_free_images',
                        ],
                    ]
                ]
            );

            $this->logger->info('push sent', [
                'extra' => [
                    'response' => $response->getBody()->getContents(),
                    'file' => __FILE__,
                    'line' => __LINE__
                ]
            ]);
        } catch (\Throwable $th) {
            $this->logger->error(
                'Failed to send push',
                ['extra' => [
                    'error' => $th->getMessage(),
                    'trace' => $th->getTraceAsString(),
                    'file' => __FILE__,
                    'line' => __LINE__
                ]]
            );
        }
    }

    private function getAccessToken(): ?string
    {
        $this->logger->info('trying to get access token', [
            'extra' => [
                'file' => __FILE__,
                'line' => __LINE__
            ]
        ]);
        $token = \Cache::get('google_access_token');

        if ($token) {
            $this->logger->info('found in cache', [
                'extra' => [
                    'file' => __FILE__,
                    'line' => __LINE__
                ]
            ]);
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

            $this->logger->info('got from google', [
                'extra' => [
                    'access_token' => $data['access_token'],
                    'file' => __FILE__,
                    'line' => __LINE__
                ]
            ]);

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
