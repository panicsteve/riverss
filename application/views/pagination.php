<?php if ( $page > 0 ) : ?>
	<a href="<?= site_url() ?><?= $pagination_route ?><?= $page - 1 ?>">&laquo; Newer</a> |
<?php endif; ?>
<a href="<?= site_url() ?><?= $pagination_route ?><?= $page + 1 ?>">Older &raquo;</a>
