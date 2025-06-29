<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MenuService
{
    public static function getMenuBySystemId($id)
    {
        $key    = 'menu-sys-' . $id;
        $time   = 60 * 60 * 24; // 24 jam 
        return Cache::remember($key, $time, function () use ($id) {
            $menuItems = DB::table('gm_menu')
                ->where('system_id', $id)
                ->where('active', 1)
                ->orderBy('order')
                ->get();

            $result = [];

            foreach ($menuItems as $item) {
                if ($item->level == 0) {
                    $result[$item->id] = [
                        'id' => $item->id,
                        'title' => $item->Menu,
                        'form' => $item->Form,
                        'menu_code' => $item->menu_code,
                        'order' => $item->order,
                        'children' => [],
                    ];
                }
            }

            foreach ($menuItems as $item) {
                if ($item->level == 1 && isset($result[$item->parent_id])) {
                    $result[$item->parent_id]['children'][] = [
                        'id' => $item->id,
                        'title' => $item->Menu,
                        'form' => $item->Form,
                        'menu_code' => $item->menu_code,
                        'order' => $item->order,
                    ];
                }
            }

            return array_values($result);
        });
    }
}
