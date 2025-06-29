<?php

namespace App\Livewire\Pages\Dashboard;

use App\Services\MenuService;
use DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class AppsHome extends Component
{
    public $id;
    public function render()
    {
        $menuItems = MenuService::getMenuBySystemId($this->id);
        // tambah title 
        $title = DB::table('gm_system')->where('id', $this->id)->value('sys_name');
        return view('livewire.pages.dashboard.apps-home')->layout('layouts.app',[
            'menuItems' => $menuItems,
            'title' => $title,
            'idApp' => $this->id
        ]);
    }
}
