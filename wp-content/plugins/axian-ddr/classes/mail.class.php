<?php
if ( ! class_exists( 'AxianDDRAdministration' ) ) {
    require_once( AXIAN_DDR_PATH .'/classes/administration.class.php' );
}
class AxianDDRMail {

    public static $validation;
    public static $rappel;

    public function __construct(){
        $settings = AxianDDRAdministration::get_settings();
        self::$validation['sujet'] = $settings['general']['sujet_notification_validateur'];
        self::$validation['content'] = $settings['general']['content_notification_validateur'];
        self::$rappel['sujet'] = $settings['general']['sujet_notification_rappel'];
        self::$rappel['content'] = $settings['general']['content_notification_rappel'];
    }


    public static function sendMail( $emailto, $email_subject, $message){
        $message = $message;
        $headers[] = 'From : '. get_option('blogname') .' <noreply@' . $_SERVER['HTTP_HOST'] .'>';
        add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
        ob_start();
        include AXIAN_DDR_PATH. "/templates/mail/mail.tpl.php";
        $html = ob_get_contents();
        ob_clean();

        $emailto = explode(',', $emailto);
        $emailto = array_unique($emailto);
        $emailto = implode(',', $emailto);

        wp_mail( $emailto, $email_subject, $html, $headers );
    }


    public static function sendValidation($id, $type, $ddr_id){
        $user = get_userdata($id);
        $content = self::$validation['content'];
        $content = str_replace('[type de demande]',$type,$content);
        $content = str_replace('[reference]', '<a href="'.site_url().'/wp-admin/admin.php?page=axian-ddr&action=view&id='.$ddr_id.'">DDR-' .$ddr_id. '<a/>',$content);
        self::sendMail( $user->user_email, self::$validation['sujet'], nl2br($content) );
    }

    public static function sendRappel($id){
        $user = get_userdata($id);
        $args = array(
            'assignee_id' => $id,
        );
        $validations = AxianDDR::getby($args);
        if( $validations['count'] > 0 ){
            $content = self::$rappel['content'];
            $content = str_replace( '[nb]', $validations['count'], $content );
            $content = str_replace('[ici]', '<a href="'.site_url().'/wp-admin/admin.php?page=axian-ddr-list&prefilter=myvalidation"> ici <a/>',$content);
            self::sendMail( $user->user_email, self::$rappel['sujet'], nl2br($content) );
        }
    }
}
$axian_ddr_mail = new AxianDDRMail();