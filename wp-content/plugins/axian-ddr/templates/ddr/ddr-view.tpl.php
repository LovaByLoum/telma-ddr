<?php
global $axian_ddr;
if ( (isset($_GET['id']) && !empty($_GET['id']) ) ){
    $post_data = $axian_ddr->getbyId(intval($_GET['id']));
}else $post_data = null;


?>
<div class="warp ddr-view">

    <div class="card w-50">
        <div class="card-header bg-danger">
            <h3>DDR - <?php echo $post_data['id'];?></h3>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#detail">Détail</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#historique">Historique</a>
                </li>
            </ul>
        </div>
        <!-- Tab panes -->
        <div class="tab-content">
            <div id="detail" class="container tab-pane active"><br>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <h4 class="card-title"><?php echo $post_data['title'];?></h4>
                        <p>
                            <span>Type de demande</span>: <?php echo $axian_ddr::$types_demande[$post_data['type']];?> dans le budget</br>
                            <span>Attribution</span>:  <?php echo $post_data['assignee_id'];?></br>
                            <span>Direction</span>:  <?php echo $axian_ddr::$directions[$post_data['direction']];?></br>
                            <span>Département</span>: <?php echo $axian_ddr::$departements[$post_data['departement']];?> </br>
                            <span>Lieu de travail</span>: <?php echo $axian_ddr::$lieux[$post_data['lieu']];?> </br>
                            <span>Motif</span>: <?php echo $post_data['motif'];?> </br>
                            <span>Commentaire</span>: <?php echo $post_data['comment'];?> </br>
                            <span>Date de création</span>: <?php echo $post_data['created'];?> </br>
                            <span>Date dernier modification</span>: <?php echo $post_data['modified'];?> </br>
                            <span>Etat</span>: <?php echo $axian_ddr::$etats[$post_data['etat']];?> </br>
                            <span>Etape</span>: <?php echo $axian_ddr::$etapes[$post_data['etape']];?> </br>
                            <span>Date prévisionnel d'embauche</span>: <?php echo $post_data['date_previsionnel'];?> </br>
                        </p>
                        <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                    </blockquote>
                </div>
                <div class="card-body">
                    <a href="#" class="card-link">Valider</a>
                    <a href="#" class="card-link">Refuser</a>
                </div>
            </div>
            <div id="historique" class="container tab-pane fade"><br>
                <div class="card-body">
                    <h4>Historique</h4>
                </div>

            </div>
        </div>
    </div>
</div>





