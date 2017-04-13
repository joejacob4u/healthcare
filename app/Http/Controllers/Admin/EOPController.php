<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Regulatory\StandardLabel;

class EOPController extends Controller
{
    public function index($standard_label)
    {
        $standard_label = StandardLabel::get();
        return view('admin.eop.index',['standard_label' => $standard_label]);
    }
}
