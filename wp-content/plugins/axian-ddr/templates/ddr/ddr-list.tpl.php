<?php
?>
<div class="col-wrap">
	<form id="posts-filter" method="post" action="?page=<?php echo esc_attr( $_REQUEST['page'] );?>">
		<h2>Liste des demandes</h2>
		<p>
			<span style="white-space:nowrap;float:right">
				<label>
					Recherche pour:
					<input type="text" id="" value="">
				</label>
				<input class="button" type="button" value="Recherche" id="">
			</span>
		</p>
        <p>
            Sélectionner par type :
            <select name="">
                <option value="" selected="selected">Toutes</option>
                <option value="planned">Prévu</option>
                <option value="not_planned">Non prévu</option>
            </select>

            &nbsp;&nbsp;
			<span style="white-space:nowrap">Status :
				<select name="">
                    <option value="">Tous</option>
                    <option value="draft">Broullion</option>
                    <option value="in_progress">En cours</option>
                </select>
			</span>

			<span style="white-space:nowrap">
				Type de candidature:
				<select name="icl-st-filter-translation-priority">
                    <option value="">Toutes</option>
                    <option value="internal">Interne</option>
                    <option value="external">Externe</option>
                </select>
			</span>
        </p>

		<?php
		$list_ddr = new AxianDDRList();
		$list_ddr->prepare_items();
		$list_ddr->display();
		?>

	</form>


</div>