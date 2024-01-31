<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 30.01.24
 * Time: 09:09
 */

namespace App\Library\Wallpaper\Infrastructure;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class DalleService
{
    protected Client $client;
    protected string $api_key;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('openai.base_uri'),
            'timeout' => 120,
        ]);

        $this->api_key = config('openai.key');
    }

    public function getImageByPrompt(string $prompt): array
    {
        $url = 'images/generations';

        $response = $this->client->post($url,[
            RequestOptions::JSON => [
                "model" => "dall-e-3",
                "prompt" => $prompt,
                "n" => 1,
                "size" => "1024x1792",
                "quality"  => "hd"
            ],
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $this->api_key,
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        dd($data);

        return [];
    }
}
