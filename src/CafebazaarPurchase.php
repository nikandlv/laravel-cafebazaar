<?php
namespace Nikandlv\LaravelCafebazaar;

class CafebazaarPurchase {

    public $data;
    
    public function __construct($data) {
        $this->data = $data;
    }

    function getConsumptionState() {
        return $this->data['consumptionState'];
    }

    function getPurchaseState() {
        return $this->data['purchaseState'];
    }

    function getKind() {
        return $this->data['kind'];
    }

    function getPayload() {
        return $this->data['developerPayload'];
    }

    function getTime() {
        return $this->data['purchaseTime'];
    }

    function isValid() {
        return $this->getPurchaseState() === 0;
    }

}