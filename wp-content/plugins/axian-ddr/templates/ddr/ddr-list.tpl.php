<div class="wrap">
    <h1 class="wp-heading-inline">Demandes de recrutement</h1><a href="admin.php?page=new-axian-ddr" class="page-title-action">Ajouter</a>

	<form id="posts-filter" method="get" action="admin.php?page=axian-ddr">
        <input type="hidden" name="page" value="axian-ddr-list"/>

        <ul class="subsubsub">
            <?php $current_filter = isset($_GET['prefilter']) ? $_GET['prefilter'] : '';?>
            <li><a href="javascript:addParameterToURL('prefilter=myvalidation');" class="<?php if ($current_filter == 'myvalidation' ) echo 'current';?>">Mes validations <span class="count">(<?php echo 1?>)</span></a> </li>|
            <li><a href="javascript:addParameterToURL('prefilter=mytickets');" class="<?php if ($current_filter == 'mytickets' ) echo 'current';?>">Mes tickets <span class="count">(<?php echo 1?>)</span></a> </li>|
            <li><a href="javascript:addParameterToURL('prefilter=alltickets');" class="<?php if ($current_filter == 'alltickets' ) echo 'current';?>">Tous <span class="count">(<?php echo 1?>)</span></a> </li>
        </ul>
        <input type="hidden" name="prefilter" value="<?php echo $current_filter;?>"/>

		<?php
        global $DDRListTable;
        $DDRListTable->prepare_items();
        $DDRListTable->display();
		?>
	</form>

</div>