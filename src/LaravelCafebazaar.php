<?php

namespace Nikandlv\LaravelCafebazaar;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class LaravelCafebazaar {
    
    function __construct() {
        $this->guzzle = new \GuzzleHttp\Client(["base_uri" => "https://pardakht.cafebazaar.ir/devapi/v2/"]);
        $this->data = $this->getCache();
        $this->code = $this->getCode();
        $this->updateToken();
    }

    protected function updateToken() {

        if(empty($this->code)) {  
            throw new Exception("Code not found. run php artisan Cafebazaar code");
        }

        if(empty($this->data)) {
            $response = $this->guzzle->post("auth/token", [
                "grant_type" => 'authorization_code',
                'code' => $this->code,
                "client_id" => config('laravel-cafebazaar.client_id'),
                "client_secret" => config('laravel-cafebazaar.client_secret'),
                "redirect_uri" => config('laravel-cafebazaar.redirect_uri'),
            ]);
            $this->data = $response->getBody();
            setCache($this->data);
        }
    }

    protected function getCache() {
        return Cache::get('laravel-cafebazaar');
    }

    protected function setCache($cache) {
        Cache::put('laravel-cafebazaar', $cache, 60);
    }

    protected function getCode() {
        return Cache::get('laravel-cafebazaar-code');
    }
    
    public function verifyPurchase($package_id, $product_id, $purchase_token) {
        $this->updateToken();
        $data = $this->guzzle->get("api/validate/$package_id/inapp/$product_id/purchases/$purchase_token");
        return new CafebazaarPurchase($data);
    }

    public static function handleRedirect(Request $request) {
        $code = $request->input('code');
        if(!empty($code)) {
            Cache::forever('laravel-cafebazaar-code', $code);
        }
    }
}
