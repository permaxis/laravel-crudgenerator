<?php
use Illuminate\Support\Facades\Route;

if (! function_exists('pxcg_sort_item')) {
    function pxcg_sort_item($sortBy, $sortDir, $key ) {

        if (isset($sortBy) && $sortBy == $key && isset($sortDir) && $sortDir== 'asc')
        {
            $icon = 'fa-sort-amount-down-alt';
        }
        elseif (isset($sortBy) && $sortBy == $key && isset($sortDir) && $sortDir== 'desc')
        {
            $icon = 'fa-sort-amount-up' ;
        }
        if (!empty($icon))
        {
            return " <i class=\"fas {$icon} \"></i>";
        }
        else
        {
            return '';
        }
    }
}
if (! function_exists('pxcg_inline_update_field')) {
    function pxcg_inline_update_field($path, $field_id, $field_name, $field_value, $field_formated_value = null, $field_updated_value = null ) {
        /*data-urlupdate ="{{ route('crudgenerator.entities.update',['id' => $item->id]) }}" data-fieldid = "{{ $item->id }}" data-field="name" data-fieldstate="read" data-fieldvalue="{{ $item->name }}" data-fieldformatedvalue="{{ $item->name }}" data-updatedfieldvalue="">{{ $item->name }}*/
        return " data-urlupdate =\"{$path}\" data-fieldid = \"{$field_id}\" data-field=\"{$field_name}\" data-fieldstate=\"read\" data-fieldvalue=\"{$field_value}\" data-fieldformatedvalue=\"".(($field_formated_value!==null)? $field_formated_value: $field_value) ."\" data-updatedfieldvalue=\"".( ($field_updated_value!==null)? $field_updated_value : $field_value )."\"";
    }
}

if (! function_exists('pxcg_trans')) {

    function pxcg_trans($key = null, $replace = [], $locale = null)
    {
        $result =  trans($key, $replace, $locale);

        if ($result == $key)
        {
            preg_match('/(.*)::(.*)\.(.*)/',$key,$matches);

            if (count($matches) == 4 && $matches[2] != 'messages')
            {
                $key = $matches[1].'::messages.'.$matches[3];

                return trans($key,$replace,$locale);
            }
            else
            {
                return $key;
            }
        }
        else
        {
            return $result;
        }
    }
}

if (! function_exists('pxcg_menu')) {
    function pxcg_menu_item($title, $route_name, $route_names_matched = [], $bs = 3)
    {
        $menu_item_active = false;
        if ( Route::currentRouteName() == $route_name
        || in_array(Route::currentRouteName(), $route_names_matched))
        {
            $menu_item_active = true;
        }
        if ($bs == 3)
        {
            $menu_item = '<li class="'.(($menu_item_active)? 'active' : '') .'"><a href="'.route($route_name).'">'.$title.'</a></li>';
        }
        elseif ($bs == 4)
        {
            $menu_item = '<a class="nav-link'.(($menu_item_active)? ' active' : '') .'" href="'.route($route_name).'">'.$title.'</a>';
        }
        return $menu_item;
    }
}
