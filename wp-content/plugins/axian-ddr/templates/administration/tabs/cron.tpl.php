<?php
global $axian_ddr_settings;
global $axian_ddr_administration;
$result = AxianDDRAdministration::submit_settings();
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
?>
<?php
if ( isset($_GET['msg'])  && $_GET['msg'] == 'cron-forced'){
    $result = array(
        'code' => 'updated',
        'msg' => 'Tache cron executée avec succés.',
    );
}
if ( $result ) : ?>
    <div class="notice <?php echo $result['code'];?>">
        <p><?php echo $result['msg'];?></p>
    </div>
<?php endif;?>

<div class="wrap">

    <h1>Configuration des tâches périodiques</h1>
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

    <h4>Forcer l'execution</h4>
    <ul>
        <li>
            <strong>Gestion des intérims : </strong> <a class="confirm-before" href="admin.php?page=axian-ddr-admin&tab=cron&forceruncron=interim">Forcer l'execution maintenant</a>
            <p>Vérifie la liste des intérims actifs, Attribue les intérims aux groupes des collaborateurs qu'ils remplacent, Assigne les tickets des collaborateurs qu'ils remplacent, Restaure les groupes et attribution des tickets lorsque la période d'intérim est passé.</p>

        </li>
        <li>
            <strong>Rappel de validation : </strong> <a class="confirm-before" href="admin.php?page=axian-ddr-admin&tab=cron&forceruncron=daily_rappel">Forcer l'execution maintenant</a>
            <p>Envoi un mail de rappel de validation aux collaborateurs ayant des tickets en attente de validation</p>
        </li>
    </ul>



</div><!-- .wrap -->