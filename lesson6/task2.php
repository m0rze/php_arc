<?php

interface PaymentsInterface {
    public function pay(string $product, float $price);
}

class WebmoneyPayments implements PaymentsInterface {

    public function pay(string $product, float $price)
    {
        echo "Платим $price за $product через Webmoney" . PHP_EOL;
    }
}

class YandexPayments implements PaymentsInterface {

    public function pay(string $product, float $price)
    {
        echo "Платим $price за $product через Yandex" . PHP_EOL;
    }
}

class QiwiPayments implements PaymentsInterface {

    public function pay(string $product, float $price)
    {
        echo "Платим $price за $product через Qiwi" . PHP_EOL;
    }
}

class SocksShop {

    private string $product;
    private float $price;

    public function __construct(string $product, float $price)
    {
        $this->product = $product;
        $this->price = $price;
    }

    public function buyProduct(PaymentsInterface $paymentsMethod)
    {
        $paymentsMethod->pay($this->product, $this->price);
    }

}

$redSox = new SocksShop("Красные носки", 299.99);
$redSox->buyProduct(new WebmoneyPayments());
$redSox->buyProduct(new YandexPayments());
$redSox->buyProduct(new QiwiPayments());