<div class="wrap nosubsub">
<h1 class="wp-heading-inline">Catégories</h1>


<hr class="wp-header-end">

<div id="ajax-response"></div>

<form class="search-form wp-clearfix" method="get">
<input type="hidden" name="taxonomy" value="category">
<input type="hidden" name="post_type" value="post">

<p class="search-box">
	<label class="screen-reader-text" for="tag-search-input">Rechercher dans les catégories:</label>
	<input type="search" id="tag-search-input" name="s" value="">
	<input type="submit" id="search-submit" class="button" value="Rechercher dans les catégories"></p>

</form>

<div id="col-container" class="wp-clearfix">

<div id="col-left">
<div class="col-wrap">


<div class="form-wrap">
<h2>Ajouter une nouvelle catégorie</h2>
<form id="addtag" method="post" action="edit-tags.php" class="validate">
<input type="hidden" name="action" value="add-tag">
<input type="hidden" name="screen" value="edit-category">
<input type="hidden" name="taxonomy" value="category">
<input type="hidden" name="post_type" value="post">
<input type="hidden" id="_wpnonce_add-tag" name="_wpnonce_add-tag" value="7881a4fc5c"><input type="hidden" name="_wp_http_referer" value="/projets/axian-recrutement/srcs/wp-admin/edit-tags.php?taxonomy=category">
<div class="form-field form-required term-name-wrap">
	<label for="tag-name">Nom</label>
	<input name="tag-name" id="tag-name" type="text" value="" size="40" aria-required="true">
	<p>Ce nom est utilisé un peu partout sur votre site.</p>
</div>
<div class="form-field term-slug-wrap">
	<label for="tag-slug">Identifiant</label>
	<input name="slug" id="tag-slug" type="text" value="" size="40">
	<p>L’identifiant est la version normalisée du nom. Il ne contient généralement que des lettres minuscules non accentuées, des chiffres et des traits d’union.</p>
</div>
<div class="form-field term-parent-wrap">
	<label for="parent">Catégorie parente</label>
	<select name="parent" id="parent" class="postform">
	<option value="-1">Aucun</option>
	<option class="level-0" value="1">Non classé</option>
</select>
			<p>Les catégories, contrairement aux étiquettes, peuvent avoir une hiérarchie. Vous pouvez avoir une catégorie nommée Jazz, et à l’intérieur, plusieurs catégories comme Bebop et Big Band. Ceci est totalement facultatif.</p>
	</div>
<div class="form-field term-description-wrap">
	<label for="tag-description">Description</label>
	<textarea name="description" id="tag-description" rows="5" cols="40"></textarea>
	<p>La description n’est pas très utilisée par défaut, cependant de plus en plus de thèmes l’affichent.</p>
</div>

<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Ajouter une nouvelle catégorie"></p></form></div>

</div>
</div><!-- /col-left -->

<div id="col-right">
<div class="col-wrap">


<form id="posts-filter" method="post">
<input type="hidden" name="taxonomy" value="category">
<input type="hidden" name="post_type" value="post">

<input type="hidden" id="_wpnonce" name="_wpnonce" value="31fe9ce081"><input type="hidden" name="_wp_http_referer" value="/projets/axian-recrutement/srcs/wp-admin/edit-tags.php?taxonomy=category">	<div class="tablenav top">

				<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-top" class="screen-reader-text">Sélectionnez l’action groupée</label><select name="action" id="bulk-action-selector-top">
<option value="-1">Actions groupées</option>
	<option value="delete">Supprimer</option>
</select>
<input type="submit" id="doaction" class="button action" value="Appliquer">
		</div>
		<div class="tablenav-pages one-page"><span class="displaying-num">1 élément</span>
<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
<span class="paging-input"><label for="current-page-selector" class="screen-reader-text">Page actuelle</label><input class="current-page" id="current-page-selector" type="text" name="paged" value="1" size="1" aria-describedby="table-paging"><span class="tablenav-paging-text"> sur <span class="total-pages">1</span></span></span>
<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
<span class="tablenav-pages-navspan" aria-hidden="true">»</span></span></div>
		<br class="clear">
	</div>
<h2 class="screen-reader-text">Liste des catégories</h2><table class="wp-list-table widefat fixed striped tags">
	<thead>
	<tr>
		<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Tout sélectionner</label><input id="cb-select-all-1" type="checkbox"></td><th scope="col" id="name" class="manage-column column-name column-primary sortable desc"><a href="http://localhost/projets/axian-recrutement/srcs/wp-admin/edit-tags.php?taxonomy=category&amp;orderby=name&amp;order=asc"><span>Nom</span><span class="sorting-indicator"></span></a></th><th scope="col" id="description" class="manage-column column-description sortable desc"><a href="http://localhost/projets/axian-recrutement/srcs/wp-admin/edit-tags.php?taxonomy=category&amp;orderby=description&amp;order=asc"><span>Description</span><span class="sorting-indicator"></span></a></th><th scope="col" id="slug" class="manage-column column-slug sortable desc"><a href="http://localhost/projets/axian-recrutement/srcs/wp-admin/edit-tags.php?taxonomy=category&amp;orderby=slug&amp;order=asc"><span>Identifiant</span><span class="sorting-indicator"></span></a></th><th scope="col" id="posts" class="manage-column column-posts num sortable desc"><a href="http://localhost/projets/axian-recrutement/srcs/wp-admin/edit-tags.php?taxonomy=category&amp;orderby=count&amp;order=asc"><span>Compte</span><span class="sorting-indicator"></span></a></th>	</tr>
	</thead>

	<tbody id="the-list" data-wp-lists="list:tag">
			<tr id="tag-1"><th scope="row" class="check-column">&nbsp;</th><td class="name column-name has-row-actions column-primary" data-colname="Nom"><strong><a class="row-title" href="http://localhost/projets/axian-recrutement/srcs/wp-admin/term.php?taxonomy=category&amp;tag_ID=1&amp;post_type=post&amp;wp_http_referer=%2Fprojets%2Faxian-recrutement%2Fsrcs%2Fwp-admin%2Fedit-tags.php%3Ftaxonomy%3Dcategory" aria-label="«&nbsp;Non classé&nbsp;» (Modifier)">Non classé</a></strong><br><div class="hidden" id="inline_1"><div class="name">Non classé</div><div class="slug">non-classe</div><div class="parent">0</div></div><div class="row-actions"><span class="edit"><a href="http://localhost/projets/axian-recrutement/srcs/wp-admin/term.php?taxonomy=category&amp;tag_ID=1&amp;post_type=post&amp;wp_http_referer=%2Fprojets%2Faxian-recrutement%2Fsrcs%2Fwp-admin%2Fedit-tags.php%3Ftaxonomy%3Dcategory" aria-label="Modifier «&nbsp;Non classé&nbsp;»">Modifier</a> | </span><span class="inline hide-if-no-js"><a href="#" class="editinline aria-button-if-js" aria-label="Modifier rapidement “Non classé” en ligne" role="button">Modification&nbsp;rapide</a> | </span><span class="view"><a href="http://localhost/projets/axian-recrutement/srcs/category/non-classe/" aria-label="Voir l&amp;rquo;archive pour «&nbsp;Non classé&nbsp;»">Afficher</a> | </span><span class="aam"><a href="http://localhost/projets/axian-recrutement/srcs/wp-admin/admin.php?page=aam&amp;oid=1|category&amp;otype=term#post" target="_blank">Access</a></span></div><button type="button" class="toggle-row"><span class="screen-reader-text">Afficher plus de détails</span></button></td><td class="description column-description" data-colname="Description"><span aria-hidden="true">—</span><span class="screen-reader-text">No description</span></td><td class="slug column-slug" data-colname="Identifiant">non-classe</td><td class="posts column-posts" data-colname="Compte"><a href="edit.php?category_name=non-classe">1</a></td></tr>	</tbody>

	<tfoot>
	<tr>
		<td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Tout sélectionner</label><input id="cb-select-all-2" type="checkbox"></td><th scope="col" class="manage-column column-name column-primary sortable desc"><a href="http://localhost/projets/axian-recrutement/srcs/wp-admin/edit-tags.php?taxonomy=category&amp;orderby=name&amp;order=asc"><span>Nom</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-description sortable desc"><a href="http://localhost/projets/axian-recrutement/srcs/wp-admin/edit-tags.php?taxonomy=category&amp;orderby=description&amp;order=asc"><span>Description</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-slug sortable desc"><a href="http://localhost/projets/axian-recrutement/srcs/wp-admin/edit-tags.php?taxonomy=category&amp;orderby=slug&amp;order=asc"><span>Identifiant</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-posts num sortable desc"><a href="http://localhost/projets/axian-recrutement/srcs/wp-admin/edit-tags.php?taxonomy=category&amp;orderby=count&amp;order=asc"><span>Compte</span><span class="sorting-indicator"></span></a></th>	</tr>
	</tfoot>

</table>
	<div class="tablenav bottom">

				<div class="alignleft actions bulkactions">
			<label for="bulk-action-selector-bottom" class="screen-reader-text">Sélectionnez l’action groupée</label><select name="action2" id="bulk-action-selector-bottom">
<option value="-1">Actions groupées</option>
	<option value="delete">Supprimer</option>
</select>
<input type="submit" id="doaction2" class="button action" value="Appliquer">
		</div>
		<div class="tablenav-pages one-page"><span class="displaying-num">1 élément</span>
<span class="pagination-links"><span class="tablenav-pages-navspan" aria-hidden="true">«</span>
<span class="tablenav-pages-navspan" aria-hidden="true">‹</span>
<span class="screen-reader-text">Page actuelle</span><span id="table-paging" class="paging-input"><span class="tablenav-paging-text">1 sur <span class="total-pages">1</span></span></span>
<span class="tablenav-pages-navspan" aria-hidden="true">›</span>
<span class="tablenav-pages-navspan" aria-hidden="true">»</span></span></div>
		<br class="clear">
	</div>

</form>

<div class="form-wrap edit-term-notes">
<p>
	<strong>Note&nbsp;:</strong><br>Supprimer une catégorie ne supprime pas les articles qu’elle contient. Les articles affectés uniquement à la catégorie supprimée seront affectés à la catégorie <strong>Non classé</strong>.</p>
<p>Les catégories peuvent être converties de manière sélective en étiquettes via le <a href="http://localhost/projets/axian-recrutement/srcs/wp-admin/import.php">convertisseur catégories vers étiquettes</a>.</p>
</div>

</div>
</div><!-- /col-right -->

</div><!-- /col-container -->
</div>