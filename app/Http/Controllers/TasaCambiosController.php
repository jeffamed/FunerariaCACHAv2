<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TasaCambio;

class TasaCambiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function mostrar()
    {
        $tasa = TasaCambio::orderBy('id','desc')->first();

        return ["tasa"=>$tasa];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

}
