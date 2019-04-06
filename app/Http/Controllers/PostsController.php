<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\Placetopay;
use GuzzleHttp\Client;


class PostsController extends Controller
{

    protected $placeToPayRequest;

    public function __construct(Placetopay $placetopay) {

        $this->placeToPayRequest = $placetopay;
    }

    //
    public function index()
    {
        $posts = $this->placeToPayRequest->solicitudPagoBasico();
        dd('placeToPayRequest');
        return view('posts.index', compact('posts'));
    }

    public function show($id)
    {
        $post =  $this->posts->find( $id );
    
        return view('posts.show', compact('post'));

    }
}
