<div class="wrap">
    <h1>Administration Axian DDR</h1>
    <?php
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
    ?>
    <h2 class="nav-tab-wrapper">
        <?php  foreach ( AxianDDRAdministration::$list_tabs as $tab => $label ) : ?>
            <a href="?page=axian-ddr-admin&amp;tab=<?php echo $tab;?>" class="nav-tab <?php echo $active_tab == $tab ? 'nav-tab-active' : ''; ?>"><?php echo $label;?></a>
        <?php endforeach; ?>
    </h2>
</div>
<?php

include 'tabs' . DIRECTORY_SEPARATOR . $active_tab . '.tpl.php';