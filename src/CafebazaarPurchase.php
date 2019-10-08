<?php
namespace Nikandlv\LaravelCafebazaar;

class CafebazaarPurchase {

    public $data;
    
    public function __construct($data) {
        $this->data = $data;
    }

    public function getConsumptionState() {
        return $this->data['consumptionState'];
    }

    public function getPurchaseState() {
        return $this->data['purchaseState'];
    }

    public function getKind() {
        return $this->data['kind'];
    }

    public function getPayload() {
        return $this->data['developerPayload'];
    }

    public function getTime() {
        return $this->data['purchaseTime'];
    }

    public function isValid() {
        return $this->getPurchaseState() === 0;
    }

}