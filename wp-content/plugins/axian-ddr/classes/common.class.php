<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eddi
 * Date: 14/05/19
 * Time: 16:00
 * To change this template use File | Settings | File Templates.
 */
Class Utils_ADDR {

    public static function render_field($args){
        $defaults = array(
            'type' => 'text',
            'name' => '',
            'id' => '',
            'class' => '',
            'size' => '',
            'value' => '',
            'required' => 0,
            'label' => '',
        );
        $args = array_merge($defaults , $args);
    }

    public static function check_required(){

    }

    public static function check_validate(){

    }
}