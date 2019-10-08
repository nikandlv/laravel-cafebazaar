<?php

namespace Nikandlv\LaravelCafebazaar;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class LaravelCafebazaar
{
    
    function __construct() {
        $this->guzzle = new \GuzzleHttp\Client(["base_uri" => "https://pardakht.cafebazaar.ir/devapi/v2"]);
        $this->data = $this->getCache();
        $this->updateToken();
    }

    function updateToken() {
        if()
        $response = $this->guzzle->post("/post");
        echo $response->getBody();
    }

    function getCache() {
        return Cache::get('laravel-cafebazaar');
    }

    function setCache($cache) {
        Cache::forever('laravel-cafebazaar', $cache, 60);
    }

    function getCode() {
        return Cache::get('laravel-cafebazaar-code');
    }

    function setCode($code) {
        Cache::forever('laravel-cafebazaar-code', $code);
    }
    

    public function verifyPurchase($package_id, $product_id, $purchase_token) {
        $this->updateToken();
    }

    private function expired() {
        $this->data->expire = false;
    }

    public static function handleRedirect(Request $request) {
        $code = $request->input('code');
    }
}
