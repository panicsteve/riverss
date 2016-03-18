<h2><?= $table_title ?></h2>
<table>
	<?php foreach ( $feed_items as $feed_item ) : ?>
		<tr>
			<td>
				<a class="feed-item-link" href="<?= $feed_item->permalink ?>"><?= $feed_item->title ?></a>
			</td>
		</tr>
		<tr>
			<td class="feed-item-dateline">
				<?= $feed_item->date ?> &mdash;
				<a href="<?= site_url() ?>/feeds/view/<?= $feed_item->feed_id ?>"><?= $feed_item->feed_title ?></a>
			</td>
		</tr>
		<tr>
			<td class="feed-item-tags">
				<?php foreach ( $feed_item->tags as $tag ) : ?>
					<a class="tag" href="<?= site_url() ?>/tags/view/<?= $tag->id ?>"><?= $tag->title ?></a>
				<?php endforeach; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
