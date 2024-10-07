<?php

namespace App\Http\Controllers\frontend\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        return view('frontend.dashboard.setting');
    }
}
