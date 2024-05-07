<?php
/**
 * Created by PhpStorm.
 * User: Andrei Siarheyeu <andreylong@gmail.com>
 * Date: 25.04.24
 * Time: 12:43
 */

namespace App\Library\Wallpaper\Infrastructure;

use App\Library\Core\Logger\LoggerChannel;
use App\Library\Wallpaper\Contracts\ImageGeneratorServiceContract;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Storage;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

class StableDiffusionService implements ImageGeneratorServiceContract
{
    private Client $client;
    private string $open_ai_api_key;
    private string $stable_api_key;
    private string $open_ai_base_uri;
    private string $stable_base_uri;

    private LoggerInterface $logger;
    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 120,
        ]);

        $this->open_ai_base_uri = config('openai.base_uri');
        $this->open_ai_api_key = config('openai.key');

        $this->stable_base_uri = config('stable.base_uri');
        $this->stable_api_key = config('stable.key');

        $this->logger = \LoggerService::getChannel(LoggerChannel::STABLE_DIFFUSION);
    }



    public function getImageByPrompt(string $prompt, string $style = null): array | null
    {
        $translated_prompt = $this->translatePrompt($prompt);

        $url = $this->stable_base_uri . 'stable-image/generate/core';

        $original_name = Uuid::uuid7();

        $path_parts = array_slice(str_split(md5($original_name), 2), 0, 2);
        $path = implode(DIRECTORY_SEPARATOR, $path_parts);

        Storage::disk('wallpaper')
               ->makeDirectory($path);

        $file_name = $original_name . '.png';
        $full_path = Storage::disk('wallpaper')->path($path . DIRECTORY_SEPARATOR . $file_name);

        $multipart = [
            [
                'name' => 'prompt',
                'contents' => $translated_prompt
            ],[
                'name' => 'output_format',
                'contents' => 'png'
            ],[
                'name' => 'aspect_ratio',
                'contents' => '9:16'
            ],[
                'name' => 'style_preset',
                'contents' => $style
            ]
        ];

        $this->logger->info('trying to generate image', [
            'extra' => [
                'data'  => $multipart,
                'file'  => __FILE__,
                'line'  => __LINE__,
            ]
        ]);

        $this->client->post($url,[
            'multipart' => $multipart,
            'headers' => [
                'authorization' => 'Bearer ' . $this->stable_api_key,
                'accept' => 'image/*',
            ],
            RequestOptions::SINK => $full_path
        ]);

        return [
            'prompt' => $translated_prompt,
            'file_path' => $path . DIRECTORY_SEPARATOR . $file_name,
        ];
    }

    private function translatePrompt(string $prompt): string
    {
        $url = $this->open_ai_base_uri . 'chat/completions';
        $model = 'gpt-4';
        $max_tokens = 256;

        $system_prompt = 'Please detect language and translate the prompt to English, you should return only the translated text nothing else. If prompt is already in English, just return it as is.';

        $messages = [
            [
                'role' => 'system',
                'content' => $system_prompt
            ],[
                'role' => 'user',
                'content' => $prompt
            ]
        ];

        $response = $this->client->post($url,[
            'json' => [
                "model" => $model,
                "messages" => $messages,
                "max_tokens" => $max_tokens
            ],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->open_ai_api_key,
            ]
        ]);

        $response = json_decode($response->getBody()->getContents(), true);

        return $response['choices'][0]['message']['content'];
    }

}
