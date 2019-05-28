<?php
global $axian_ddr;
global $ddr_process_msg;

if( !empty($_POST) ){
    $post_data = $_POST;
    $post_data['id'] = $_GET['id'];
}elseif ( (isset($_GET['id']) && !empty($_GET['id']) ) ){
    $post_data = AxianDDR::getbyId(intval($_GET['id']));
}else $post_data = null;

if ( null != $post_data ){
    $assignee = AxianDDRUser::getById(intval($post_data['assignee_id']));
    $author = AxianDDRUser::getById(intval($post_data['author_id']));
}
$historiques = AxianDDRHistorique::getByDDRId(intval($_GET['id']));
?>
<div class="warp ddr-view">

    <div class="card w-100">
        <div class="card-header bg-danger">
            <h3>DDR - <?php echo $post_data['id'];?></h3>

            <?php
            if ( !is_null($ddr_process_msg) ){
                $msg = $ddr_process_msg;
            }
            if ( isset($_GET['msg']) ){
                $msg = AxianDDR::manage_message($_GET['msg']);
            }
            ?>
            <?php if ( isset($msg) ) : ?>
                <div class="notice <?php echo $msg['code'];?>">
                    <p><?php echo $msg['msg'];?></p>
                </div>
            <?php endif;?>
            <hr class="wp-header-end">

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
                <h4 class="card-title text-center"><?php echo $post_data['title'];?></h4>
                <div class="card-body detail">
                    <blockquote class="blockquote mb-0">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Type de demande :</label>
                                    <p class="col-sm-7 control-label"> <?php echo AxianDDR::$types_demande[$post_data['type']];?> dans le budget</p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Attribution :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo $assignee->display_name;?>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Direction :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo $axian_ddr->directions[$post_data['direction']];?>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Département :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo $axian_ddr->departements[$post_data['departement']];?>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Lieu de travail :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo $axian_ddr->lieux[$post_data['lieu_travail']];?>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Motif :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo $post_data['motif'];?>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Commentaire :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo $post_data['comment'];?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Date création :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo axian_ddr_convert_to_human_datetime($post_data['created']);?>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Date dernier modification :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo  axian_ddr_convert_to_human_datetime($post_data['modified']);?>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Type de candidature :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo AxianDDR::$types_candidature[$post_data['type_candidature']];?>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Etat :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo AxianDDR::$etats[$post_data['etat']];?>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Etape :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo AxianDDR::$etapes[$post_data['etape']];?>
                                    </p>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-5 control-label">Date previsionnel d'embauche :</label>
                                    <p class="col-sm-7 control-label">
                                        <?php echo axian_ddr_convert_to_human_date($post_data['date_previsionnel']);?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <footer class="blockquote-footer">Le demandeur:  <cite title="Source Title"><?php echo $author->display_name;?></cite></footer>
                    </blockquote>
                </div>
                <div class="card-body text-center">
                    <a href="#" class="card-link">Valider</a>
                    <a href="#" class="card-link">Refuser</a>
                </div>
            </div>
            <div id="historique" class="container tab-pane fade"><br>
                <div class="card-body">
                    <fieldset class="ddr-box-bordered text-center">
                        <legend><h4>Historiques</h4></legend>

                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="libelle">Utilisateur</th>
                                    <th class="libelle">Date</th>
                                    <th class="libelle">Etat avant</th>
                                    <th class="libelle">Etat après</th>
                                    <th class="libelle">Etape</th>
                                    <th class="libelle">Commentaire</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($historiques as $key => $value):?>
                                    <tr class=" <?php echo ($key % 2 == 0) ? 'odd' : 'even';?> ">
                                        <td valign="top">
                                            <?php echo $value['display_name'];?>
                                        </td>
                                        <td><?php echo axian_ddr_convert_to_human_datetime($value['date']);?></td>
                                        <td>
                                            <?php echo AxianDDR::$etats[$value['etat_avant']];?>
                                        </td>
                                        <td>
                                            <?php echo AxianDDR::$etats[$value['etat_apres']];?>
                                        </td>
                                        <td>
                                            <?php echo AxianDDR::$etapes[$value['etape']];?>
                                        </td>
                                        <td>
                                            <?php echo $value['comment'];?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>





