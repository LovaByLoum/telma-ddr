<div class="wrap">
    <h1 class="wp-heading-inline">Traitement des tickets</h1>

    <form id="posts-filter" method="get" action="admin.php?page=axian-historique-list">
        <input type="hidden" name="page" value="axian-historique-list"/>

        <?php
        global $DDRHistoriqueListTable;
        $DDRHistoriqueListTable->prepare_items();
        $DDRHistoriqueListTable->display();
        ?>
    </form>

</div>