<?php
/*
* your script here
*/
global $wpdb;
$sql = "DELETE FORM " . $wpdb->prefix."post_meta WHERE meta_key = 'reference_offre'";
$result = $wpdb->query($sql);
echo  " Réference(s) Efaccer";
?>