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
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

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

    public function getImageByPrompt(string $prompt): array | null
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

        $response = json_decode($response->getBody()->getContents(), true);

        if (count($response['data'][0] ?? []) > 0) {
            $data = $response['data'][0];
            $revised_prompt = $data['revised_prompt'];
            $file_url = $data['url'];

            $original_name = Uuid::uuid7();

            $path_parts = array_slice(str_split(md5($original_name), 2), 0, 2);
            $path = implode(DIRECTORY_SEPARATOR, $path_parts);

            Storage::disk('wallpaper')
                   ->makeDirectory($path);

            $file_name = $original_name . '.png';
            $full_path = Storage::disk('wallpaper')->path($path . DIRECTORY_SEPARATOR . $file_name);

            (new Client())->get($file_url, [
                RequestOptions::SINK => $full_path
            ]);

            return [
                'prompt' => $revised_prompt,
                'file_path' => $path . DIRECTORY_SEPARATOR . $file_name
            ];
        }

        return null;
    }
}
