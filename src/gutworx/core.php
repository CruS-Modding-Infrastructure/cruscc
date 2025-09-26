<?php

function component(string $path): void {
	global $ROOT;
	include($ROOT . "gutworx/components/" . $path . ".php");
}

function getCallerScript(): string {
	return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]["file"];
}

function getCallerBaseDir(): string {
	return basename(dirname(getCallerScript()));
}

function getMaps(): array {
	global $_MAPS;

	if (isset($_MAPS)) {
		return $_MAPS;
	}

	global $ROOT;

	$var_names = [
		"MAP_NAME" => true,
		"MAP_AUTHOR" => true,
		"MAP_VERSION" => true,
		"MAP_DATE" => true,
		"MAP_RANK" => false,
	];

	$_MAPS = [];

	foreach (new DirectoryIterator($ROOT . "map") as $dir) {
		if (!$dir->isDir() || $dir->isDot()) {
			continue;
		}

		$info_path = $ROOT . "map/" . $dir . "/info.php";

		if (!file_exists($info_path)) {
			continue;
		}

		foreach ($var_names as $key => $required) {
			unset($$key);
		}

		require $info_path;

		$info = [];

		foreach ($var_names as $key => $required) {
			if (isset($$key)) {
				$info[$key] = $$key;
			} elseif ($required) {
				fwrite(STDERR, "Warning: \${$key} is not set in map/{$dir}/info.php" . PHP_EOL);
			}
		}

		$info["DateTimeObj"] = DateTime::createFromFormat("j/M/Y", $info["MAP_DATE"]);

		$_MAPS[$dir->getFilename()] = $info;
	}

	uasort($_MAPS, fn($a, $b) => $b["DateTimeObj"] <=> $a["DateTimeObj"]);

	return $_MAPS;
}

function getMapsAlphabetical(): array {
	$maps = getMaps();

	uasort($maps, fn($a, $b) => strcmp($a["MAP_NAME"], $b["MAP_NAME"]));

	return $maps;
}

function getMods(): array {
	global $_MODS;

	if (isset($_MODS)) {
		return $_MODS;
	}

	global $ROOT;

	$var_names = [
		"MOD_NAME" => true,
		"MOD_AUTHOR" => true,
		"MOD_VERSION" => true,
		"MOD_DATE" => true,
		"MOD_RANK" => false,
	];

	$_MODS = [];

	foreach (new DirectoryIterator($ROOT . "mod") as $dir) {
		if (!$dir->isDir() || $dir->isDot()) {
			continue;
		}

		$info_path = $ROOT . "mod/" . $dir . "/info.php";

		if (!file_exists($info_path)) {
			continue;
		}

		foreach ($var_names as $key => $required) {
			unset($$key);
		}

		require $info_path;

		$info = [];

		foreach ($var_names as $key => $required) {
			if (isset($$key)) {
				$info[$key] = $$key;
			} elseif ($required) {
				fwrite(STDERR, "Warning: \${$key} is not set in mod/{$dir}/info.php" . PHP_EOL);
			}
		}

		$info["DateTimeObj"] = DateTime::createFromFormat("j/M/Y", $info["MOD_DATE"]);

		$_MODS[$dir->getFilename()] = $info;
	}

	uasort($_MODS, fn($a, $b) => $b["DateTimeObj"] <=> $a["DateTimeObj"]);

	return $_MODS;
}

function getModsAlphabetical(): array {
	$mods = getMods();

	uasort($mods, fn($a, $b) => strcmp($a["MOD_NAME"], $b["MOD_NAME"]));

	return $mods;
}

function getMapCount(): int {
	return count(getMaps());
}

function getModCount(): int {
	return count(getMods());
}

function getMapName(string $map_id = ""): string {
	if ($map_id) {
		$map_id = getCallerBaseDir();
	}

	return getMaps()[$map_id]["MAP_NAME"];
}

function getMapAuthorId(string $map_id = ""): string|array {
	if ($map_id) {
		$map_id = getCallerBaseDir();
	}

	return getMaps()[$map_id]["MAP_AUTHOR"];
}

function getMapAuthorName(string $map_id = ""): string|array {
	$author_id = getMapAuthorId($map_id);

	return is_array($author_id)
		? array_map("getUserName", $author_id)
		: getUserName($author_id);
}

function getUserName(string $user_id = ""): string {
	if ($user_id) {
		$user_id = getCallerBaseDir();
	}

	return $user_id;
}
