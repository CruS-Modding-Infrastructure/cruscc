<table id="listing" border="8" cellpadding="0" cellspacing="0"><tr><td>
	<?php foreach($maps as $map_id => $map): ?>
		<?=component("listing/map",
			id: $map_id,
			link: getMapLink($map_id),
			name: strtoupper(getMapName($map_id)),
			author_name: strtoupper(getMapAuthorName($map_id)),
			author_hover: getMapAuthorName($map_id) === "Multiple Authors"
				? implode("\n", getMapAuthorNames($map_id)) : "",
			date: getMapDate($map_id),
			rank: getMapRank($map_id),
			icon: getMapIcon($map_id),
		)?>
	<?php endforeach ?>
</td></tr></table>
