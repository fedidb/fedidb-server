<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\ConnectionException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use Exception;

class HttpService
{
    public static function baseHeaders()
    {
        return [
            'User-Agent' => config('fedidb.user_agent'),
        ];
    }

    public static function get($url)
    {
        try {
            $res = Http::withHeaders(self::baseHeaders())
                ->timeout(5)
                ->connectTimeout(3)
                ->retry(2, 500)
                ->get($url);
        } catch (RequestException $e) {
            return $e;
        } catch (ConnectionException $e) {
            return $e;
        } catch (Exception $e) {
            return $e;
        }

        if(!$res->ok()) {
            throw new \Exception('error');
        }

        return $res->json();
    }
}
