<?php
?>
<div class="col-wrap">
	<form id="posts-filter" method="get" action="">
		<h2>Liste des demandes</h2>
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page']?>">
		<?php
		$list_ddr = new AxianDDRList();
		$list_ddr->prepare_items();
		$list_ddr->display();
		?>

	</form>


</div>