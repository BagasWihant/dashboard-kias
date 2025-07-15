<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Services\FungsiTrait;
use App\Services\MenuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    use FungsiTrait;
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

    public function appInMenu($id1,$id2) {
        $menuItems = MenuService::getMenuBySystemId($id1);
        $title = DB::table('gm_system')->where('id', $id1)->value('sys_name');
        $dataMenu =  $this->findMenuById($id2, $menuItems);
        $titleMenu =  $this->findMenuById($id2, $menuItems,true);
        $url = $dataMenu['page'] ?? null; // ini url 
        // dump($url,$dataMenu,$titleMenu  );
         return view('pages.app-in-menu',[
            'menuItems' => $menuItems,
            'title' => $title,
            'menuTitle' => $titleMenu['title'] ,
            'subMenuTitle' => $dataMenu['title'] ,
            'idApp' => $id1,
            'url'=>$url
        ]);
        // return view('livewire.pages.dashboard.apps-in-menu', compact('url'))->layout('layouts.app', [
        // ]);
    }
}