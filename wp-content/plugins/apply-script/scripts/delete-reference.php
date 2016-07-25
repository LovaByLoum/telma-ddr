<?php
/*
* your script here
*/
global $wpdb;
$sql = "DELETE FROM  " . $wpdb->prefix."postmeta WHERE meta_key = 'reference_offre'";
$result = $wpdb->query($sql);
echo  " Réference(s) Efaccer";
?>