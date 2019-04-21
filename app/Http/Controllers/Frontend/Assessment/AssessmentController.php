<?php

namespace App\Http\Controllers\Frontend\Assessment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssessmentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('user');
    }

    public function index()
    {
        echo 'hi';
        exit;
    }
}
