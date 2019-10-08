<?php

namespace Nikandlv\LaravelCafebazaar;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class LaravelCafebazaar {
    
    function __construct() {
        
        if(empty($this->code)) {  
            throw new Exception("Code not found. run php artisan Cafebazaar code");
        }

        $this->guzzle = new \GuzzleHttp\Client(["base_uri" => "https://pardakht.cafebazaar.ir/devapi/v2/"]);
        $this->data = $this->getCache();
        $this->code = $this->getCode();

        if(empty($this->data)) {
            $this->updateToken();
        } else {
            $this->refreshToken();
        }
    }

    protected function updateToken() {
        if(empty($this->data)) {
            try {
                $response = $this->guzzle->post("auth/token/", [
                    'form_params' => [
                        "grant_type" => 'authorization_code',
                        'code' => $this->code,
                        "client_id" => config('laravel-cafebazaar.client_id'),
                        "client_secret" => config('laravel-cafebazaar.client_secret'),
                        "redirect_uri" => config('laravel-cafebazaar.redirect_uri'),    
                   ],
                ]);
                $this->data = json_decode($response->getBody()->getContents());
                $this->setCache($this->data);
            } catch (RequestException $exception) {
                throw $exception;
            }
        }
    }

    protected function refreshToken() {
        try {
            if(!isset($this->data->refresh_token)) {
                return;
            }
            $refresh_token = $this->data->refresh_token;
            $response = $this->guzzle->post("auth/token/", [
                'form_params' => [
                    "grant_type" => 'refresh_token',
                    "client_id" => config('laravel-cafebazaar.client_id'),
                    "client_secret" => config('laravel-cafebazaar.client_secret'),
                    "refresh_token" => $refresh_token
               ],
            ]);
            $this->data = json_decode($response->getBody()->getContents());
            $this->data->refresh_token = $refresh_token;
            $this->setCache($this->data);
        } catch (RequestException $exception) {
            throw $exception;
        }
    }    

    protected function getCache() {
        return Cache::get('laravel-cafebazaar');
    }

    protected function setCache($cache) {
        Cache::forever('laravel-cafebazaar', $cache);
    }

    protected function getCode() {
        return Cache::get('laravel-cafebazaar-code');
    }
    
    public function verifyPurchase($package_id, $product_id, $purchase_token) {
        $this->updateToken();
        $response = $this->guzzle->get("api/validate/$package_id/inapp/$product_id/purchases/$purchase_token?access_token=".$this->data->access_token);
        $data = json_decode($response->getBody()->getContents());
        return new CafebazaarPurchase($data);
    }

    public static function handleRedirect(Request $request) {
        $code = $request->input('code');
        if(!empty($code)) {
            Cache::forever('laravel-cafebazaar-code', $code);
        }
    }
}
