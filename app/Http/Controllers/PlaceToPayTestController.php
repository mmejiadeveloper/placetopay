<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Placetopay;

use GuzzleHttp\Client;

use App\paymentListProcessModel;


class PlaceToPayTestController extends Controller
{
    protected $placeToPayRequest;

    public function __construct(Placetopay $placetopay) {

        $this->placeToPayRequest = $placetopay;
    }
    //Esto lo programe en espanol porque los metodos de la api estan en espanol
    public function paymentRequest()
    {
        $datos = isset($_POST['data']) ? $this->procesar_axios_data(json_decode($_POST['data'])) : [];
        $estructuraEnviadaPorP2P = $this->placeToPayRequest->solicitudPagoBasico($datos);
        return $estructuraEnviadaPorP2P;
    }
    public function checkCurrentPaymentProcess()
    {
        $datos = isset($_POST['data']) ? $this->procesar_axios_data(json_decode($_POST['data'])) : [];
        // dd($datos);
        $estructuraEnviadaPorP2P = $this->placeToPayRequest->verificarProcesoPagoExistente($datos);
        return $estructuraEnviadaPorP2P;
    }
    public function getAllProcessedRequests()
    {
        $datos = paymentListProcessModel::all();
        return $datos;
    }

    public function index() {
        return view('placetopay.form');
    }
}
