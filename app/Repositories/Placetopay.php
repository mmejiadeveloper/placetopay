<?php

namespace App\Repositories;
use GuzzleHttp\Client;
use App\paymentListProcessModel;


class Placetopay {

    protected $authData = [];

    protected $paymentData = [];

    protected $client = null;

    public function __construct(Client $client) {

        $this->client = $client;

        $this->client = $client;


        $seed = date('c');

        if (function_exists('random_bytes')) {
            $nonce = bin2hex(random_bytes(16));
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $nonce = bin2hex(openssl_random_pseudo_bytes(16));
        } else {
            $nonce = mt_rand();
        }

        $nonceBase64 = base64_encode($nonce);

        $secretKey = '024h1IlD';

        $tranKey = base64_encode(sha1($nonce . $seed . $secretKey, true));


        $this->authData =  [
            'login' => '6dd490faf9cb87a9862245da41170ff2',
            'seed' => $seed,
            'nonce' => $nonceBase64,
            'tranKey' => $tranKey
        ];

    }

    public function solicitudPagoBasico($datos) {
        $this->paymentData = $datos;
        // dd($this->paymentData);
        $response = $this->client->request('POST', 'redirection/api/session', [
            'query' => [
                "auth" => $this->authData,
                "payment" => $this->paymentData,
                "expiration" => "2019-08-01T00:00:00-05:00",
                "returnUrl" => "http://desarrollo.p2p.com/?codref=".$this->paymentData['reference'],
                "ipAddress" => "127.0.0.1",
                "userAgent" => "PlacetoPay Sandbox"
            ]
        ]);
        $rawAPIRestResult = $response->getBody()->getContents();
        $jsonFormatRequestResult = json_decode($rawAPIRestResult);
        // dd($jsonFormatRequestResult);
        if(!paymentListProcessModel::create([
            "requestId" => $jsonFormatRequestResult->requestId,
            "referenceValue" => $this->paymentData['reference'],
            "processUrl" => $jsonFormatRequestResult->processUrl,
            "status" => $jsonFormatRequestResult->status->status == "OK" ? "PENDING" : "FAILED",
        ])){
            $rawAPIRestResult = json_encode(["status"=>["status"=>"Failed","message"=>"No se pudo guardar la peticion en la base de datos!"]]);
        }

        return $rawAPIRestResult;
    }

    public function verificarProcesoPagoExistente($datos) {
        $requestIdByReferenceCode = paymentListProcessModel::where( "referenceValue", $datos['referenceCode'])->first();
        if($requestIdByReferenceCode->count() > 0) {
            $id = $requestIdByReferenceCode['requestId'];
            $response = $this->client->request('POST', 'redirection/api/session/'.$id , [
                'form_params' => [
                    "auth" => $this->authData,
                ],
            ]);
            $result = ($response->getBody()->getContents());
            paymentListProcessModel::where( "requestId", $id )->update(['status' => json_decode($result)->status->status  ]);
        }else{
            $result = json_encode(["status"=>["status"=>"Failed","message"=>"No existe un codigo de referencia parar la peticion de pago"]]);
        }
        return ["result"=>json_decode($result), "row"=> $requestIdByReferenceCode];
    }

}
