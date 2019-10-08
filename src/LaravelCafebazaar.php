<?php

namespace Nikandlv\LaravelCafebazaar;
use Illuminate\Support\Facades\Cache;

class LaravelCafebazaar
{
    
    function __construct() {
        $this->getCache();
        $this->updateToken();
    }

    function updateToken() {

    }

    function getCache() {
        $cache = Cache::get('laravel-cafebazaar');

    }

    function setCache($config) {
        Cache::put('laravel-cafebazaar', $config, 60);
    }

    public function verifyPurchase($package_id, $product_id, $purchase_token) {
        
    }

    private function expired() {

    }
}
