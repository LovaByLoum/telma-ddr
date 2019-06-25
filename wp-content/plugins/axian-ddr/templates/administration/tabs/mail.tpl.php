<?php
global $axian_ddr_settings;
global $axian_ddr_administration;
$result = AxianDDRAdministration::submit_settings();
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
?>
<?php if ( $result ) : ?>
    <div class="notice <?php echo $result['code'];?>">
        <p><?php echo $result['msg'];?></p>
    </div>
<?php endif;?>

<div class="wrap">

    <h1>Configuration des notifications mail</h1>
    <br>
    <form method="post" action="">

        <div class="ddr-settings">
            <?php foreach ( $axian_ddr_administration->fields[$active_tab] as $field ) : ?>
                <div class="form-field form-required term-name-wrap form-row col-md-6">
                    <?php axian_ddr_render_field($field , $axian_ddr_settings[$active_tab]);?>
                </div>
            <?php endforeach ?>
        </div>

        <?php submit_button(); ?>
    </form>

</div><!-- .wrap -->