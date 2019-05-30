<?php
if ( preg_match('/^(.+)wp-content.*/', dirname(__FILE__), $path) ){
    include($path[1] . 'wp-load.php');

    if ( isset($_REQUEST["file"]) ){
        $param_file = $_REQUEST["file"];
        $filename = base64_decode($param_file);
        $wpud = wp_upload_dir();
        $ddr_file_path = $wpud['basedir'] . DIRECTORY_SEPARATOR . 'ddr-files';
        $file_full_path = $ddr_file_path . DIRECTORY_SEPARATOR . $filename;
        header('Content-disposition: attachment; filename='.$filename);
        header('Content-Type: application/force-download');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.filesize($file_full_path));
        header('Pragma: no-cache, no-store, must-revalidate');
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0', false);
        header('Expires: 0');
        readfile($file_full_path);
    }
}
?>
