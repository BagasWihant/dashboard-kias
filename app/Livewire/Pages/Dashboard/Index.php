<?php

namespace App\Livewire\Pages\Dashboard;

use DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    public function render()
    {
        $apps = DB::table('gm_system')->where('active', 1)->get();
        return view('livewire.pages.dashboard.index', compact('apps'));
    }
}
