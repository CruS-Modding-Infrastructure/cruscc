<?php

function component(string $path) {
	global $ROOT;
	include($ROOT . "gutworx/components/" . $path . ".php");
}

function countMaps() {
	global $ROOT;

	$count = 0;

	foreach (new DirectoryIterator($ROOT . "map") as $dir) {
		if (!$dir->isDir() || $dir->isDot()) {
			continue;
		}

		if (!file_exists($ROOT . "map/" . $dir . "/info.php")) {
			continue;
		}

		$count++;
	}

	return $count;
}

function countMods() {
	global $ROOT;

	$count = 0;

	foreach (new DirectoryIterator($ROOT . "mod") as $dir) {
		if (!$dir->isDir() || $dir->isDot()) {
			continue;
		}

		if (!file_exists($ROOT . "mod/" . $dir . "/info.php")) {
			continue;
		}

		$count++;
	}

	return $count;
}
