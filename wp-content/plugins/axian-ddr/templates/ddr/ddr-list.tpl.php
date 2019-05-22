<?php
?>
<div class="col-wrap">
	<form id="posts-filter" method="get" action="">
		<h2>Liste des demandes</h2>

		<?php
		$list_ddr = new AxianDDRList();
		$list_ddr->prepare_items();
		$list_ddr->display();
		?>

	</form>


</div>