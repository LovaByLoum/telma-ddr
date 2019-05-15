<?php global $axian_ddr_term;?>

<?php
//process submit term
$result = $axian_ddr_term->submit_term();
?>


<div class="wrap nosubsub">
    <h1 class="wp-heading-inline">Administration des termes</h1>

    <hr class="wp-header-end">

    <div id="col-container" class="wp-clearfix">

        <div id="col-left">
            <div class="col-wrap">

                <div class="form-wrap">
                    <h2>Ajouter un terme</h2>
                    <form id="add-term" method="post" action="" class="validate">

                        <?php if ( $result ) : ?>
                        <div class="notice <?php echo $result['code'];?>">
                            <p><?php echo $result['msg'];?></p>
                        </div>
                        <?php endif;?>

                        <div class="form-field form-required term-name-wrap">
                            <?php axian_ddr_render_field($axian_ddr_term->fields['type']);?>
                        </div>

                        <div class="form-field form-required term-name-wrap">
                            <?php axian_ddr_render_field($axian_ddr_term->fields['label']);?>
                        </div>

                        <p class="submit">
                            <input type="submit" name="submit-term" id="submit" class="button button-primary" value="Ajouter">
                        </p>
                    </form>
                </div>

            </div>
        </div><!-- /col-left -->

        <div id="col-right">
            <div class="col-wrap">
                <form id="posts-filter" method="post">
                    <h2 class="screen-reader-text">Liste des termes</h2>

                    list

                </form>


            </div>
        </div><!-- /col-right -->

    </div><!-- /col-container -->
</div>