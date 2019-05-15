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
        $output ='';
        $defaults = array(
            'type' => 'text',
            'name' => '',
            'id' => '',
            'class' => '',
            'size' => '',
            'value' => '',
            'required' => 0,
            'label' => '',
            'rows' => '',
            'cols' => '',
            'otpions'=> [],
        );
        $args = array_merge($defaults , $args);
        $output .= '<label for="' .$args['name'] .'">' .$args['label'] .'</label>';
        switch($args['type']){
            case 'text':
                $output .= '<input type="text" name="'.$args['name'].'" id="'.$args['id'].'" class="'.$args['class'].'" size="'.$args['size'].'">';
                break;
            case 'textarea':
                $output .= '<textarea name="'.$args['name'].'" id="'.$args['id'].'" class="'.$args['class'].'" rows="'.$args['rows'].'" cols="'.$args['cols'].'"></textarea>';
                break;
            case 'select':
                $output .= '<select name="'.$args['name'].'" id="'.$args['id'].'" class="'.$args['class'].'">';
                foreach($args['options'] as $option){
                    $output .= '<option value="'.$option['value'].'">'.$option['text'].'</option>';
                }
                $output .= '</select>';
                break;
        }
        return $output;
    }

    public static function check_required(){

    }

    public static function check_validate(){

    }
}