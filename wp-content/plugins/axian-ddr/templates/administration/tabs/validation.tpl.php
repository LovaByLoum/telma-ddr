<?php
global $axian_ddr_administration;
$result = $axian_ddr_administration::submit_option();
$post_data = $axian_ddr_administration->get_options();
?>
<?php if ( $result ) : ?>
    <div class="notice <?php echo $result['code'];?>">
        <p><?php echo $result['msg'];?></p>
    </div>
<?php endif;?>

<div class="wrap">

    <h1>Validateur par defaut</h1>

    <form method="post" action="">

        <table class="form-table">
            <?php foreach ( $axian_ddr_administration->fields as $field ) :?>
            <div class="form-field form-required term-name-wrap form-row col-md-6">
                <?php axian_ddr_render_field($field ,$post_data);?>
            </div>
            <?php endforeach ?>
        </table>

        <?php submit_button(); ?>
    </form>

</div><!-- .wrap -->