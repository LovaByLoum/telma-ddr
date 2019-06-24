<?php
global $axian_ddr_interim;
global $interim_process_msg;

$is_edit = isset($_GET['id']) && isset($_GET['action']) && 'edit' == $_GET['action'] && $_GET['id'] > 0;
$is_create = !isset($_GET['id']) && !isset($_GET['action']);
$is_view = isset($_GET['id']) && isset($_GET['action']) && 'view' == $_GET['action'] && $_GET['id'] > 0;

if( $is_edit || $is_view ){
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

    <h1 class="wp-heading-inline">Intérim</h1>
    <?php if ( $is_view ): ?>
        <a href="admin.php?page=axian-ddr-interim&action=edit&id=<?php echo $_GET['id'];?>" class="page-title-action">Modifier</a>
    <?php endif;?>
    <br>
    <form method="post" action="">

        <div class="ddr-settings">
            <?php foreach ( $axian_ddr_interim->fields as $field ) :?>
                <div class="form-field form-required term-name-wrap form-row col-md-6">
                    <?php axian_ddr_render_field($field , $post_data,true, $is_view);?>
                </div>
            <?php endforeach ?>
        </div>

        <?php if ( $is_create ): ?>
        <input type=submit name='submit-interim' class="button button-primary confirm-before" value="Soumettre">
        <?php else :?>
        <input type=hidden name='id' value="<?php echo $_GET['id'];?>">
            <?php if ( $is_edit):?>
        <input type=submit name='update-interim' class="button button-primary confirm-before" value="Enregistrer">
            <?php endif;?>
        <input type=submit name='delete-interim' class="button confirm-before" value="Supprimer">
        <?php endif;?>
        <a href="admin.php?page=axian-ddr-list" class="btn btn-sm btn-outline-danger confirm-before">Retour</a>
    </form>

</div><!-- .wrap -->