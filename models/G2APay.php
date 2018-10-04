<?php

namespace app\models;

use Exception;
use yii\helpers\VarDumper;
use yii\httpclient\Client;


class G2APay
{
    public static function addOrder($g2a_game_id)
    {
        $envDomain = 'sandboxapi.g2a.com'; // for production, domain will be different
        $g2aEmail = 'sandboxapitest@g2a.com'; // customer email
        $apiHash = 'qdaiciDiyMaTjxMt'; // customer API hash
        $apiSecret = 'b0d293f6-e1d2-4629-8264-fd63b5af3207b0d293f6-e1d2-4629-8264-fd63b5af3207'; // customer API secret

        $apiKey = hash('sha256', $apiHash . $g2aEmail . $apiSecret);

        $orderApiUrl = 'https://' . $envDomain . '/v1/order';

        $authorization = $apiHash . ', ' . $apiKey;

        $client = new Client();

        $order = [
            'product_id' => $g2a_game_id,
            'currency' => 'EUR',
            'max_price' => 45.0,
            'min_rating' => 0.9
        ];

        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl($orderApiUrl)
            ->addHeaders(['Authorization' => $authorization, 'Content-Type' => 'application/json'])
            ->setContent(json_encode($order))
            ->send();

        if ($response->isOk) {
            return $response->data;
        }

        return false;

        //redirect to error page
    }

    public static function makePayment($g2a_order_id)
    {
        $envDomain = 'sandboxapi.g2a.com'; // for production, domain will be different
        $g2aEmail = 'sandboxapitest@g2a.com'; // customer email
        $apiHash = 'qdaiciDiyMaTjxMt'; // customer API hash
        $apiSecret = 'b0d293f6-e1d2-4629-8264-fd63b5af3207b0d293f6-e1d2-4629-8264-fd63b5af3207'; // customer API secret

        $apiKey = hash('sha256', $apiHash . $g2aEmail . $apiSecret);

        $paymentApiUrl = 'https://' . $envDomain . '/v1/order/pay/' . $g2a_order_id;

        $authorization = $apiHash . ', ' . $apiKey;

        $client = new Client();

        $response = $client->createRequest()
            ->setMethod('PUT')
            ->setUrl($paymentApiUrl)
            ->addHeaders(['Authorization' => $authorization, 'Content-Type' => 'application/json', 'Content-Length' => 0])
            ->send();

        if ($response->isOk) {
            return $response->data;
        }

        return false;
    }

    public static function getOrderKey($g2a_order_id)
    {
        $envDomain = 'sandboxapi.g2a.com'; // for production, domain will be different
        $g2aEmail = 'sandboxapitest@g2a.com'; // customer email
        $apiHash = 'qdaiciDiyMaTjxMt'; // customer API hash
        $apiSecret = 'b0d293f6-e1d2-4629-8264-fd63b5af3207b0d293f6-e1d2-4629-8264-fd63b5af3207'; // customer API secret

        $apiKey = hash('sha256', $apiHash . $g2aEmail . $apiSecret);

        $keyApiUrl = 'https://' . $envDomain . '/v1/order/key/' . $g2a_order_id;

        $authorization = $apiHash . ', ' . $apiKey;

        $client = new Client();

        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($keyApiUrl)
            ->addHeaders(['Authorization' => $authorization, 'Content-Type' => 'application/json'])
            ->send();


        if ($response->isOk) {
            return $response->data;
        }

        return false;
    }
}