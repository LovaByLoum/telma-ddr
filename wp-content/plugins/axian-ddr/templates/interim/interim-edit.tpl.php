<?php
global $axian_ddr_interim;
global $interim_process_msg;

$is_edit = isset($_GET['id']) && isset($_GET['action']) && 'edit' == $_GET['action'] && $_GET['id'] > 0;
$is_create = !isset($_GET['id']) && !isset($_GET['action']);

if( $is_edit ){
    $post_data = AxianDDRInterim::getById(intval($_GET['id']));
    $post_data['date_interim'] = axian_ddr_convert_to_normal_date($post_data['date_debut']) . ':' . axian_ddr_convert_to_normal_date($post_data['date_fin']);
}else $post_data = null;
?>
<?php
if ( isset($_GET['msg']) ){
    $msg = AxianDDRInterim::manage_message($_GET['msg']);
}
if ( !is_null($interim_process_msg) ){
    $msg = $interim_process_msg;
}
?>
<?php if ( isset($msg) ) : ?>
    <div class="notice <?php echo $msg['code'];?>">
        <p><?php echo $msg['msg'];?></p>
    </div>
<?php endif;?>
<div class="wrap">

    <h1 class="wp-heading-inline"><?php if ( $is_create ): ?> Ajouter un Intérim<?php else:?>Modifier Intérim N°<?php echo $post_data['id'];?><?php endif;?></h1>
    <br>
    <br>
    <form method="post" action="">

        <div class="ddr-settings">
            <?php foreach ( $axian_ddr_interim->fields as $field ) :?>
                <div class="form-field form-required term-name-wrap form-row col-md-6">
                    <?php axian_ddr_render_field($field , $post_data,true);?>
                </div>
            <?php endforeach ?>
        </div>

        <?php if ( $is_create ): ?>
            <input type=submit name='submit-interim' class="button button-primary confirm-before" value="Soumettre">
        <?php else : ?>
            <input type=hidden name='id' value="<?php echo $_GET['id'];?>">
            <input type=submit name='update-interim' class="button button-primary confirm-before" value="Enregistrer">
        <?php endif;?>
    </form>

</div><!-- .wrap -->

<div class="wrap list-table-interim">
    <form method="get" action="">
        <input type="hidden" name="page" value="axian-ddr-interim">
        <?php
        $DDRInterimListTable = new AxianDDRInterimList();
        $DDRInterimListTable->prepare_items();
        $DDRInterimListTable->display();
        ?>
    </form>
</div>