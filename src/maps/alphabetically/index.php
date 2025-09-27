<?php
require_once $ROOT . "gutworx/core.php";
?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="/gutworx/images/cruelty_squad/cruscc.ico">
		<link rel="stylesheet" href="/gutworx/stylesheets/cruscc.css">
		<link rel="stylesheet" href="/gutworx/stylesheets/listing.css">
		<link rel="stylesheet" href="/maps/ranks.css">
		<link rel="stylesheet" href="index.css">
		<title>CRUELTY SQUAD CUSTOM MAPS</title>
	</head>
	<body><center>
		<?=component("announcements")?>
		<?=component("title-map")?>

		<div id="navigator">
			<div style="display: flex; align-items: flex-end;">
				<div style="flex-shrink: 0;">
					<b class="sort-by">sort by:</b
					><a class="newestLink" href="/maps/newest/"><b>newest</b></a
					><a class="popularLink" href="/maps/most-popular/"><b>most-popular</b></a
					><b class="alphabetActive">alphabetically</b>
				</div>
				<marquee class="cometMarquee" style="flex-grow: 1; height: 100%">
					<b>&#9733;&nbsp;<?=getMapCount()?> maps indexed!</b>
				</marquee>
			</div>
			<a class="go-down" href="#bottom" style="float: left;"><b>go down</b></a>
			<br/>
		</div>

		<?=component("listing/maps", maps: getMapsAlphabetical())?>

		<table border="0" cellpadding="0" cellspacing="0" id="bottom"><tr><td><a class="go-up" href="#top"><b>go up</b></a></td></tr></table>

		<?=component("footer")?>
	</center></body>
</html>
