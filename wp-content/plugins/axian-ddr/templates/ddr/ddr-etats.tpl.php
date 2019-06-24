<div class="row">
    <?php foreach(AxianDDR::$etats as $etat=>$label):?>
        <div class="card col-md-6 col-sm-12 col-xs-12">
            <div class="" id="heading<?php echo $etat;?>">
                <h5 class="mb-0">
                    <button class="btn btn-danger btn-block" data-toggle="collapse" data-target="#collapse<?php echo $etat;?>" aria-expanded="false" aria-controls="collapse<?php echo $etat;?>">
                        <?php echo $label;?>
                    </button>
                </h5>
            </div>

            <div id="collapse<?php echo $etat;?>" class="collapse show" aria-labelledby="heading<?php echo $etat;?>" data-parent="#third-col">
                <?php
                $list_term = new AxianDDREtatList($etat);
                $list_term->prepare_items();
                $list_term->display();
                ?>
            </div>
        </div>
    <?php endforeach;?>
</div>

