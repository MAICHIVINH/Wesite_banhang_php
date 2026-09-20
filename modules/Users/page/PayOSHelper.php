<?php

require_once   './vendor/autoload.php';

use PayOS\PayOS;

class PayOSHelper
{
    private PayOS $client;
    private array $conf;

    public function __construct()
    {
        $this->conf = require './config/payos.php';
        $this->client = new PayOS(
            $this->conf['client_id'],
            $this->conf['api_key'],
            $this->conf['checksum_key'],
            $this->conf['partner_code']
        );
    }
    public function createLink(
        int $orderCode,
        int $amount,
        string $description,
        array $items = []
    ): array {
        $payload = [
            'orderCode' => $orderCode,
            'amount' => $amount,
            'description' => $description,
            'returnUrl' => $this->conf['return_url'],
            'cancelUrl' => $this->conf['cancel_url'],
            'items' => $items,
        ];

        return $this->client->createPaymentLink($payload);
    }

    /** Xác thực callback */
    public function verifyWebhook(array $payload): array
    {
        return $this->client->verifyPaymentWebhookData($payload);
    }
}
