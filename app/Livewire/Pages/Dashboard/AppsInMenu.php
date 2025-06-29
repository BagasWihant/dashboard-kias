<?php

namespace App\Livewire\Pages\Dashboard;

use App\Services\MenuService;
use DB;
use Livewire\Component;

class AppsInMenu extends Component
{
    public $id1;
    public $id2;

    public function render()
    {
        $menuItems = MenuService::getMenuBySystemId($this->id1);
        $title = DB::table('gm_system')->where('id', $this->id1)->value('sys_name');
        $dataMenu =  $this->findMenuById($this->id2, $menuItems);
        $url = $dataMenu['page'] ?? null; // ini url 
        // dump($url,$dataMenu,$menuItems  );
        return view('livewire.pages.dashboard.apps-in-menu',compact('url'))->layout('layouts.app',[
            'menuItems' => $menuItems,
            'title' => $title,
            'idApp' => $this->id1
        ]);
    }
    private function findMenuById($id,  $menus)
    {
        foreach ($menus as $menu) {
            if ($menu['id'] == $id) {
                return $menu;
            }
            if (isset($menu['children']) && is_array($menu['children'])) {
                $found = $this->findMenuById($id, $menu['children']);
                if ($found) {
                    return $found;
                }
            }
        }
        return null;
    }
}
