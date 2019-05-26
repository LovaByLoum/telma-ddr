<div class="wrap">
    <h1 class="wp-heading-inline">Demandes de recrutement</h1><a href="admin.php?page=new-axian-ddr" class="page-title-action">Ajouter</a>

	<form id="posts-filter" method="get" action="admin.php?page=axian-ddr">
        <input type="hidden" name="page" value="axian-ddr-list"/>
		<?php
        global $DDRListTable;
        $DDRListTable->prepare_items();
        $DDRListTable->display();
		?>
	</form>

</div>