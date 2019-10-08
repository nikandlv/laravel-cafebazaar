<?php

namespace Nikandlv\LaravelCafebazaar;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class LaravelCafebazaar
{
    
    function __construct() {
        $this->data = $this->getCache();
        $this->updateToken();
    }

    function updateToken() {

    }

    function getCache() {
        return Cache::get('laravel-cafebazaar');
    }

    function setCache($cache) {
        Cache::put('laravel-cafebazaar', $cache, 60);
    }

    function getCode() {
        return Cache::get('laravel-cafebazaar-code');
    }

    function setCode($code) {
        Cache::put('laravel-cafebazaar-code', $code);
    }
    

    public function verifyPurchase($package_id, $product_id, $purchase_token) {
        
    }

    private function expired() {
        $this->data->expire = false;
    }

    public static function handleRedirect(Request $request) {
        $code = $request->input('code');
    }
}
