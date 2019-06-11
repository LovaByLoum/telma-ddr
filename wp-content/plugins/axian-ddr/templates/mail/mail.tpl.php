<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo get_option('blogname'); ?></title>
</head>
<body marginheight="0" marginwidth="0" topmargin="0" leftmargin="0" style="background:white;">

<table width="700" border="0" cellspacing="10" cellpadding="2">
    <tr>
        <td width="194"><a href="<?php echo site_url();?>" target="_blank"><img src="<?php echo esc_url(get_theme_mod('telma_recrutement_logo')); ?>" alt="<?php echo esc_attr(get_option('blogname')); ?>" width="206" border="0" style="background-color: white;padding:5px;display:block;text-decoration:none;"></a></td>
        <td width="600" valign="top" style="padding:10px;font-size:13px;display:block;">
            <font face="Arial, Helvetica, sans-serif" >
                <?php echo $message;?>
            </font>
        </td>
    </tr>
</table>
</body>
</html>
