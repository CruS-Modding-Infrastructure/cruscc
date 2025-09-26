<?php

$_MAP_VARS = [
	"MAP_NAME",
	"MAP_AUTHOR",
	"MAP_VERSION",
	"MAP_DATE",
	"MAP_RANK",
];

$_MOD_VARS = [
	"MOD_NAME",
	"MOD_AUTHOR",
	"MOD_VERSION",
	"MOD_DATE",
	"MOD_RANK",
];

function component(string $path) {
	global $ROOT;
	include($ROOT . "gutworx/components/" . $path . ".php");
}

function getMaps() {
	global $_MAPS;

	if (isset($_MAPS)) {
		return $_MAPS;
	}

	global $ROOT, $_MAP_VARS;

	$_MAPS = [];

	foreach (new DirectoryIterator($ROOT . "map") as $dir) {
		if (!$dir->isDir() || $dir->isDot()) {
			continue;
		}

		$info_path = $ROOT . "map/" . $dir . "/info.php";

		if (!file_exists($info_path)) {
			continue;
		}

		foreach ($_MAP_VARS as $var_name) {
			unset($$var_name);
		}

		require $info_path;

		foreach ($_MAP_VARS as $var_name) {
			if (isset($$var_name)) {
				$info[$var_name] = $$var_name;
			}
		}

		$_MAPS[$dir->getFilename()] = $info;
	}

	return $_MAPS;
}

function getMods() {
	global $_MODS;

	if (isset($_MODS)) {
		return $_MODS;
	}

	global $ROOT, $_MOD_VARS;

	$_MODS = [];

	foreach (new DirectoryIterator($ROOT . "mod") as $dir) {
		if (!$dir->isDir() || $dir->isDot()) {
			continue;
		}

		$info_path = $ROOT . "mod/" . $dir . "/info.php";

		if (!file_exists($info_path)) {
			continue;
		}

		foreach ($_MOD_VARS as $var_name) {
			unset($$var_name);
		}

		require $info_path;

		foreach ($_MOD_VARS as $var_name) {
			if (isset($$var_name)) {
				$info[$var_name] = $$var_name;
			}
		}

		$_MODS[$dir->getFilename()] = $info;
	}

	return $_MODS;
}

function getMapCount() {
	return count(getMaps());
}

function getModCount() {
	return count(getMods());
}
