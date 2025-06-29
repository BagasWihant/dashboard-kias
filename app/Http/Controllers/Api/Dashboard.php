<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MenuService;
class Dashboard extends Controller
{
    public function listMenuSystem($id)
    {

        return response()->json(MenuService::getMenuBySystemId($id));
    }
}
