<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index(){
        $apps = DB::table('gm_system')->where('active', 1)->get();
        return view('pages.dashboard', compact('apps'));
    }
    public function appHome($id){
        $menuItems = MenuService::getMenuBySystemId($id);
        // tambah title 
        $title = DB::table('gm_system')->where('id', $id)->value('sys_name');
        // dd($title);
        return view('pages.dashboard-app-home',[
            'menuItems' => $menuItems,
            'title' => $title,
            'idApp' => $id
        ]);
    }
}
