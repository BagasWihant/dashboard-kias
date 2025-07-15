<?php
namespace App\Services;

trait FungsiTrait
{
    
    private function findMenuById($id,  $menus, $parent = false)
    {
        foreach ($menus as $menu) {
            if ($menu['id'] == $id) {
                return $menu;
            }
            if (isset($menu['children']) && is_array($menu['children'])) {
                $found = $this->findMenuById($id, $menu['children']);
                if ($found) {
                    if ($parent) {
                        return $menu;
                    }
                    return $found;
                }
            }
        }
        return null;
    }
}
