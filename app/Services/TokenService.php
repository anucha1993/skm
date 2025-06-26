<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;

class TokenService
{
    public static function fetchAndStoreToken()
    {
        $response = Http::post('https://thailaborland.com/api/gettoken', [
            'user' => 'api.thaistaff',
            'secretkey' => 'nJq4oaOcoJ53pxkuoKqaVUEfnJI4qaOuoKW3IRjtoKOapUEOnH94C3OfoKW3qHjzoJqaoaEcnJ54paOuoKq3YHkfoJIaqaEunKW4qUNgoJI3oRkcoJWao3EgnH94C3O5oJI3n0k0oJIapaEwnJI4pjWewEb3QWewEb3Q'
        ]);

        if ($response->successful() && isset($response['token'])) {
            $token = $response['token'];

            // เขียนลง .env
            self::setEnvironmentValue('LABOUR_API_TOKEN', $token);

            return $token;
        }

        return null;
    }

    // ฟังก์ชันอัปเดต .env
    protected static function setEnvironmentValue($key, $value)
    {
        $path = base_path('.env');

        if (File::exists($path)) {
            $env = File::get($path);

            if (str_contains($env, "$key=")) {
                // แก้ค่าเก่า
                $env = preg_replace("/^$key=.*/m", "$key=\"$value\"", $env);
            } else {
                // เพิ่มค่าใหม่
                $env .= "\n$key=\"$value\"";
            }

            File::put($path, $env);
        }
    }
}
