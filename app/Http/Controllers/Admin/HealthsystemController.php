<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin\HealthSystem;

class HealthsystemController extends Controller
{
    public function index()
    {
      $healthsystems = HealthSystem::get();

      return view('admin.healthsystem.index',[
          'healthsystems' => $healthsystems,
          'page_description' => 'Manage your healthsystems here',
          'page_title' => 'HealthCare System'
      ]);
    }
}
