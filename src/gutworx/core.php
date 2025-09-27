<?php

function component(string $path, mixed ...$vars): void {
	global $ROOT;
	extract($vars);
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
		"MAP_ICON" => false,
		"MAP_LINK" => false,
	];

	$_MAPS = [];

	foreach (new DirectoryIterator($ROOT . "map") as $dir) {
		if (!$dir->isDir() || $dir->isDot()) {
			continue;
		}

		$info_path = $ROOT . "map/" . $dir . "/data.php";

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
				fwrite(STDERR, "Warning: \${$key} is not set in map/{$dir}/data.php" . PHP_EOL);
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

function getMapsRanked(): array {
	$maps = getMaps();

	uasort($maps, fn($a, $b) => $b["DateTimeObj"] <=> $a["DateTimeObj"]);

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
		"MOD_ICON" => false,
		"MOD_LINK" => false,
	];

	$_MODS = [];

	foreach (new DirectoryIterator($ROOT . "mod") as $dir) {
		if (!$dir->isDir() || $dir->isDot()) {
			continue;
		}

		$info_path = $ROOT . "mod/" . $dir . "/data.php";

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
				fwrite(STDERR, "Warning: \${$key} is not set in mod/{$dir}/data.php" . PHP_EOL);
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

function getModsRanked(): array {
	$mods = getMods();

	uasort($mods, fn($a, $b) => $b["DateTimeObj"] <=> $a["DateTimeObj"]);

	return $mods;
}

function getMapCount(): int {
	return count(getMaps());
}

function getModCount(): int {
	return count(getMods());
}

function getMapName(string $map_id = ""): string {
	if (!$map_id) {
		$map_id = getCallerBaseDir();
	}

	return getMaps()[$map_id]["MAP_NAME"];
}

function getMapIcon(string $map_id = ""): string {
	if (!$map_id) {
		$map_id = getCallerBaseDir();
	}

	return getMaps()[$map_id]["MAP_ICON"] ?? "/map/{$map_id}/preview.png";
}

function getMapLink(string $map_id = ""): string {
	if (!$map_id) {
		$map_id = getCallerBaseDir();
	}

	return getMaps()[$map_id]["MAP_LINK"] ?? "/map/{$map_id}/";
}

function getMapAuthorId(string $map_id = ""): string|array {
	if (!$map_id) {
		$map_id = getCallerBaseDir();
	}

	return getMaps()[$map_id]["MAP_AUTHOR"];
}

function getMapAuthorIds(string $map_id = ""): array {
	$author_id = getMapAuthorId($map_id);

	return is_array($author_id) ? $author_id : [$author_id];
}

function getMapAuthorName(string $map_id = ""): string {
	$author_id = getMapAuthorId($map_id);

	return is_array($author_id)
		? "Multiple Authors"
		: getUserName($author_id);
}

function getMapAuthorNames(string $map_id = ""): array {
	return array_map("getUserName", getMapAuthorIds($map_id));
}

function getMapDate(string $map_id = ""): string {
	if (!$map_id) {
		$map_id = getCallerBaseDir();
	}

	return getMaps()[$map_id]["MAP_DATE"];
}

function getMapRank(string $map_id = ""): string {
	if (!$map_id) {
		$map_id = getCallerBaseDir();
	}

	return getMaps()[$map_id]["MAP_RANK"] ?? "X";
}

function getUserName(string $user_id = ""): string {
	if (!$user_id) {
		$user_id = getCallerBaseDir();
	}

	return $user_id;
}
