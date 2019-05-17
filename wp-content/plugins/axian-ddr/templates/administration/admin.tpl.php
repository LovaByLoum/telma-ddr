<div class="wrap">
    <h1>Administration Axian DDR</h1>
    <?php
    $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general';
    ?>
    <h2 class="nav-tab-wrapper">

        <a href="?page=axian-ddr-admin&amp;tab=general" class="nav-tab ">Configuration générale</a>
        <a href="?page=axian-ddr-admin&amp;tab=term" class="nav-tab <?php echo $active_tab == 'term' ? 'nav-tab-active' : ''; ?>">Termes de taxonomie</a>

    </h2>
</div>
<?php

include 'tabs' . DIRECTORY_SEPARATOR . $active_tab . '.tpl.php';