<?php
require_once $ROOT . "gutworx/core.php";

$current_date = strtoupper(date("j/M/Y"));

$map_count = getMapCount();

$mod_count = getModCount();

if (!$DEVMODE) { // don't run this in dev to speed up builds
	$views = json_decode(file_get_contents("https://neocities.org/api/info?sitename=cruscc"), true)["info"]["views"];
}

$views ??= 2200000;

?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" href="/gutworx/images/cruelty_squad/cruscc.ico">
		<link rel="stylesheet" href="/gutworx/stylesheets/cruscc.css">
		<link rel="stylesheet" href="/maps/ranks.css">
		<link rel="stylesheet" href="/mods/ranks.css">
		<link rel="stylesheet" href="index.css">
		<title>CRUELTY SQUAD CUSTOM CONTENT</title>
		<meta property="og:title" content=" WELCOME TO CRUELTY SQUAD CUSTOM CONTENT!"/>
		<meta property="og:description" content="This website is dedicated toward archiving all custom maps, mods and custom textures for Cruelty Squad. All of it is hand-coded and manually kept, so please be indulgent of any delays with updates!"/>
		<meta property="og:url" content="https://cruscc.neocities.org/index.html"/>
		<meta property="og:image" content="https://cruscc.neocities.org/texture/de_sinople/cruelty_squad/bl_black_magenta.png"/>
		<meta name="theme-color" content="#FF00FF">
		<meta property="og:type" content="website"/>
		<meta property="og:site_name" content="CRUELTY SQUAD CUSTOM CONTENT"/>
		<script>
			document.documentElement.style.setProperty("--cruscc-bg", "url('" + (
				(o,r=Math.random()*Object.values(o).reduce((a,b)=>a+b))=>Object.entries(o).find(([k,w])=>(r-=w)<=0)[0]
			)({ // weighted random
				"/gutworx/images/cruelty_squad/maps/base/greyface.png": 2,
				"/gutworx/images/cruelty_squad/maps/base/MarbleFace1.png": 7,
				"/gutworx/images/cruelty_squad/maps/base/Stone2face.png": 1,
				"/gutworx/images/cruelty_squad/maps/pyramid/skull1.png": 1,
				"/gutworx/images/cruelty_squad/maps/pyramid/skull2.png": 1,
				"/gutworx/images/cruelty_squad/maps/ship/cabinwindow.png": 1,
				"/gutworx/images/cruelty_squad/maps/ship/sun.png": 1,
			}) + "')");

			window.addEventListener("DOMContentLoaded", () => {
				//fetch("https://neocities.org/api/info?sitename=cruscc")
				fetch("https://weirdscifi.ratiosemper.com/neocities.php?sitename=cruscc")
					.then(res => res.json())
					.then(data => document.body.querySelectorAll(".viewsCountNum")
						.forEach(element =>
							element.textContent = new Intl.NumberFormat("en-US").format(data.info.views)
						)
					);
			});
		</script>
	</head>
	<body><center>
		<?=component("announcements")?>
		<?=component("title-map")?>
		<a href="/maps/newest/">
			<table id="mapsButton" border="1" cellpadding="0" cellspacing="2"><tbody>
				<tr><td><img src="/gutworx/images/cruelty_squad/menu/start_normal.png"></td></tr>
				<tr><td><center><big><b>CUSTOM<br>MAPS</b></big></center></td></tr>
			</tbody></table>
		</a>
		<a href="/mods/newest/">
			<table id="modsButton" border="1" cellpadding="0" cellspacing="2"><tbody>
				<tr><td><img src="/gutworx/images/cruelty_squad/menu/implant_menu_button.png"></td></tr>
				<tr><td><center><big><b>MODS<br>&amp; TOOLS</b></big></center></td></tr>
			</tbody></table>
		</a>
		<a href="/textures/">
			<table id="texturesButton" border="1" cellpadding="0" cellspacing="2"><tbody>
				<tr><td><img src="/texture/de_sinople/cruelty_squad/bl_black_magenta.png"></td></tr>
				<tr><td><center><big><b>CUSTOM<br>TEXTURES</b></big></center></td></tr>
			</tbody></table>
		</a>
		<!-- <a href="/texture_wall/"><table id="texturewallButton" border="1" cellpadding="0" cellspacing="2"><tbody><tr><td>
			<img src="/texture_wall/icon.png">
			</td></tr><tr><td><center><big><b>TEXTURE<br>WALL</b></big></center></td></tr></tbody></table></a> -->
		<!--
			<a href="/tracks/newest/"><table id="musicButton" border="1" cellpadding="0" cellspacing="2"><tbody><tr><td>
				<img src="/gutworx/images/cruelty_squad/misc/radio_128px.png">
				</td></tr><tr><td><center><big><b>CUSTOM<br>MUSIC</b></big></center></td></tr></tbody></table></a>
			-->
		<table id="introTable" border="8" cellpadding="0" cellspacing="0"><tbody><tr><td>
			<marquee>
				<big><b class="welcomeText"><img src="/gutworx/images/cc0/target.png">Welcome to CruS.CC!<img src="/gutworx/images/cc0/target.png"></b></big>&nbsp;
				<b class="lastUpdated"><i><u>Last updated:</u> <?=$current_date?></i></b>&nbsp;
				<b><a href="/maps/newest/" class="mapsCountStyle"><?=$map_count?> maps indexed!</a></b>&nbsp;
				<b><a href="/mods/newest/" class="modsCountStyle"><?=$mod_count?> mods indexed!</a></b>&nbsp;
				<b class="viewsCount">♥ <span class="viewsCountNum"><?=number_format($views)?></span> views ♥</b>
				<b><a href="https://discord.gg/csoftproducts" target="_blank" class="discordLink">Join the official Cruelty Squad discord!</a></b>
				<!--<b class="warningMessage"><img src="/gutworx/images/cc0/sign.gif">&nbsp;The Custom Textures &amp; Custom Music sections are currently under construction&nbsp;<img src="/gutworx/images/cc0/sign.gif">&nbsp;thank you for your understanding.</b>-->
			</marquee>
			<i class="textIntro">Welcome to Cruelty Squad Custom Content!</i><br>
			<i class="textIntro">This website is dedicated toward archiving all custom maps, mods</i><br>
			<i class="textIntro">and custom textures for Cruelty Squad.</i><br>
			<i class="textIntro">All of it is hand-coded and manually kept, so please be indulgent of any delays with updates!</i><br>
			<i class="textIntro">This website is still under construction, thank you for your understanding.</i><br>
			<br>
		</td></tr></tbody></table>
		<?=component("footer")?>
		<a href="/texture_wall" style="float: right;"><img src="/gutworx/images/dx/wallbutton.gif" width="48" height="48" alt="Texture Wall"></a>
	</center></body>
</html>
