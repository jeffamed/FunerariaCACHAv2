<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class DashboardController extends Controller
{
    public function Tasa(Client $client){
        $client = new Client();
        $tasa= $client->request('GET', 'https://www.baccredomatic.com/es-ni');
        $tasa->filter('article');
        // $tasa->filter('section.l-fullwidth.row').each(function(){
            
        // });
      dd($tasa->text());
    }

}
