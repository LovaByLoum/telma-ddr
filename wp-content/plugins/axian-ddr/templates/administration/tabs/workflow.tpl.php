<?php
global $axian_ddr_settings;
global $axian_ddr_administration;
$result = AxianDDRAdministration::submit_settings();
$step = AxianDDRWorkflow::$etapes;
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'workflow';
?>
<?php if ($result) : ?>
    <div class="notice <?php echo $result['code']; ?>">
        <p><?php echo $result['msg']; ?></p>
    </div>
    !<?php endif; ?>


<div class="wrap">

    <h1>Workflow</h1>
    <br>
    <form method="post" action="">
        <label>Etapes :
            <select name="step" multiple size="15" class="selectpicker">
                <?php foreach ($step as $key => $value) { ?>
                    <optgroup label="Etape <?php echo $key ?>">
                        <?php foreach ($value['acteur'] as $nom => $actions) { ?>
                            <option value="acteur"><?php echo $nom ?></option>
                        <?php } ?>
                    </optgroup>
                <?php } ?>
            </select>
        </label>
        <br>
        <div class="container">
            <div class='row' id='etape'>
                <div class='col-3'>
                    <select class="chosen" multiple="true" style="width:400px;" data-placeholder="Liste des étapes..." name="etape[]">
                        <optgroup label="Etapes">
                            <option value="etape1">Etape 1</option>
                            <option value="etape2">Etape 2</option>
                            <option value="etape3">Etape 3</option>
                            <option value="etape4">Etape 4</option>
                            <option value="etape5">Etape 5</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class='row' id='acteur'>
                <div class='col-3'>
                    <select class="chosen" multiple="true" style="width:400px;" data-placeholder="Liste des acteurs..." name="acteur[]">
                        <optgroup label="Acteur">
                            <option value="assistante_direction">ASSISTANTE DE DIRECTION</option>
                            <option value="controleur_budget">CONTROLEUR BUDGET RH</option>
                            <option value="drh">DRH</option>
                            <option value="dg">DG</option>
                            <option value="gt_telma">GT Telma</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class='row' id='action'>
                <div class='col-3'>
                    <select class="chosen" multiple="true" style="width:400px;" data-placeholder="Liste des actions..." name="action[]">
                        <optgroup label="Actions">
                            <option value='enregistrer_la_demande'>Enregistrer la demande</option>
                            <option value='annuler_la_demande'>Annuler la demande</option>
                            <option value='inserer_piece_jointe'>Insérer une pièce jointe</option>
                            <option value='inserer_groupe'>Insérer groupe ou personnes à notifier</option>
                            <option value='valider_la_demande'>Valider la demande</option>
                            <option value='modifier_la_demande'>Modifier la demande</option>
                            <option value='refuser_la demande'>Refuser la demande</option>
                            <option value='valider_information'>Valider les informations</option>
                            <option value='consulter_la_demande'>Consulter la demande</option>
                            <option value='creer_offre'>Créer une offre</option>
                            <option value='publier_modifier_offre'>Publier ou modifier l'offre</option>
                        </optgroup>
                    </select>
                </div>
            </div>
            <div class='row' id='etat'>
                <div class='col-3'>
                    <select class="chosen" multiple="true" style="width:400px;" data-placeholder="Liste des etats..." name="etat[]">
                        <optgroup label="Etat">
                            <option value='en_cours'>En cours</option>
                            <option value='valide'>Validé</option>
                            <option value='cloture'>Clôturer</option>
                        </optgroup>
                        <!-- <optgroup label="Etape 5">
                <option value="gestionnaire_de_talent">GETSIONNAIRE DE TALENT</option>
            </optgroup>
            <optgroup label="Etape 6">
                <option value="gestionnaire_de_talent">GETSIONNAIRE DE TALENT</option>
            </optgroup>
            <optgroup label="Etape 7">
                <option value="gestionnaire_de_talent">GETSIONNAIRE DE TALENT</option>
            </optgroup> -->
                    </select>
                </div>
            </div>
        </div>




        <?php submit_button(); ?>
    </form>

</div><!-- .wrap -->