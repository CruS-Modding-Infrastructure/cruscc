<table id="listing" border="8" cellpadding="0" cellspacing="0" ><tr><td>
	<?php foreach($MAP_LIST as $map_id => $map): ?>
		<b id="listing-<?=$map_id?>" class="listing-map">
			<a href="<?=getMapLink($map_id)?>">
				<b2><?=strtoupper(getMapName($map_id))?></b2
				><i title="<?=is_array(getMapAuthorId($map_id)) ? implode("\n", getMapAuthorNames($map_id)) : ""?>"
				> by <?=strtoupper(getMapAuthorName($map_id))?> </i
				><u><?=getMapDate($map_id)?></u
				><i> </i><rank class="rank<?=getMapRank($map_id)?>"></rank>
			</a>
			<div class="hover-image" style="background-image: url('<?=getMapIcon($map_id)?>');"></div>
		</b><br>
	<?php endforeach ?>
</td></tr></table>
