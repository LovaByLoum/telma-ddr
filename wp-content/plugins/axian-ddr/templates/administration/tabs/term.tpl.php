<?php global $axian_ddr_term;?>

<?php
//process submit term
if ( ( $_GET['action'] == 'edit' ) && (isset($_GET['id']) && !empty($_GET['id']) ) ){
    $post_data = $axian_ddr_term->getby_id(intval($_GET['id']));
}else $post_data = null;

$current_type = !empty($_GET['type']) ? $_GET['type'] : 'tous';
$result = $axian_ddr_term->submit_term();
$count = $axian_ddr_term->count_result();
?>

<?php if ( $result ) : ?>
    <div class="notice <?php echo $result['code'];?>">
        <p><?php echo $result['msg'];?></p>
    </div>
<?php endif;?>
<div class="wrap nosubsub">
    <h1 class="wp-heading-inline">Administration des termes</h1>

    <hr class="wp-header-end">

    <div id="col-container" class="wp-clearfix">

        <div id="col-left">
            <div class="col-wrap">

                <div class="form-wrap">
                    <h2>Ajouter un terme</h2>
                    <form id="add-term" method="post" action="<?php if (!is_null($post_data)) echo "?page=" . esc_attr( $_REQUEST['page'] ) ."&tab=term"  ?>" class="validate" style="margin: 60px 0">

                        <div class="form-field form-required term-name-wrap">
                            <?php axian_ddr_render_field($axian_ddr_term->fields['type'],$post_data);?>
                        </div>

                        <div class="form-field form-required term-name-wrap">
                            <?php axian_ddr_render_field($axian_ddr_term->fields['label'],$post_data);?>
                        </div>
                        <?php if (!is_null($post_data)) :?>
                        <p class="submit">
                            <input type="hidden" name="id" value="<?php echo intval($_GET['id']);?>" >
                            <input type="submit" name="update-term" id="submit" class="button button-primary" value="Enregistrer">
                        </p>
                        <?php else : ?>
                        <p class="submit">
                            <input type="submit" name="submit-term" id="submit" class="button button-primary" value="Ajouter">
                        </p>
                        <?php endif;?>
                    </form>
                </div>

            </div>
        </div><!-- /col-left -->

        <div id="col-right">
            <div class="col-wrap">
                <form id="posts-filter" method="post" action="?page=<?php echo esc_attr( $_REQUEST['page'] );?>&tab=term">
                    <h2>Liste des termes</h2>
                    <ul class="subsubsub">
                        <?php
                        $glue = '';
                        foreach( array_reverse($count) as $type=>$value) :
                            echo $glue;?>
                            <li><a href="admin.php?page=<?php echo esc_attr( $_REQUEST['page'] );?>&tab=term&type=<?php echo $type;?>" class="<?php if ($current_type == $type ) echo 'current';?>"><?php echo ucfirst($type);?> <span class="count">(<?php echo $value?>)</span></a> </li>
                        <?php $glue = '|'; endforeach;?>
                    </ul>
                    <?php
                    $list_term = new AxianDDRTermList();
                    $list_term->prepare_items();
                    $list_term->display();
                    ?>

                </form>


            </div>
        </div><!-- /col-right -->

    </div><!-- /col-container -->
</div>