<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;

class GoogleClientController extends Controller
{
    public function index() {
      $client = new Google_Client();
      dd($client);
    }
}
