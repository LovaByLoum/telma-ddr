<div class="wrap">
    <h1 class="wp-heading-inline">Demandes de recrutement</h1>

    <?php if ( current_user_can(DDR_CAP_CAN_CREATE_DDR) ) :?>
    <a href="admin.php?page=axian-ddr" class="page-title-action">Ajouter</a>
    <?php endif;?>

    <?php if (  isset($_GET['msg']) ) :
        $msg = AxianDDR::manage_message($_GET['msg'])?>
        <div class="notice <?php echo $msg['code'];?>">
            <p><?php echo $msg['msg'];?></p>
        </div>
    <?php endif;?>

	<form id="posts-filter" method="get" action="admin.php?page=axian-ddr">
        <input type="hidden" name="page" value="axian-ddr-list"/>

        <ul class="subsubsub">
            <?php $current_filter = isset($_GET['prefilter']) ? $_GET['prefilter'] : '';?>
            <li><a href="javascript:addParameterToURL('prefilter=myvalidation');" class="<?php if ($current_filter == 'myvalidation' ) echo 'current';?>">Mes validations</a> </li>|
            <li><a href="javascript:addParameterToURL('prefilter=mytickets');" class="<?php if ($current_filter == 'mytickets' ) echo 'current';?>">Mes tickets</a> </li>|
            <li><a href="javascript:addParameterToURL('prefilter=alltickets');" class="<?php if ($current_filter == 'alltickets' ) echo 'current';?>">Tous</a> </li>
        </ul>
        <input type="hidden" name="prefilter" value="<?php echo $current_filter;?>"/>

		<?php
        global $DDRListTable;
        $DDRListTable->prepare_items();
        $DDRListTable->display();
		?>
	</form>

</div>