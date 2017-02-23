<?php

namespace App\Http\Controllers\Composers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Client;
use App\AccrType;
use Auth;

class AccrComposer extends Controller
{
    public function compose(View $view)
    {
        $client = Client::where('email','=',Auth::user()->email)->first();
        $accr_types = AccrType::get();
        $view->with('client', $client)
             ->with('accr_types',$accr_types);
    }
}
