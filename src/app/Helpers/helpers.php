<?php
if (! function_exists('pxcg_sort_item')) {
    function pxcg_sort_item($sortBy, $sortDir, $key ) {
        $icon = (isset($sortBy) && $sortBy == $key && isset($sortDir) && $sortDir== 'desc')? 'glyphicon-chevron-down' : 'glyphicon-chevron-up' ;
        return " <i class=\"glyphicon {$icon} \"></i>";
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