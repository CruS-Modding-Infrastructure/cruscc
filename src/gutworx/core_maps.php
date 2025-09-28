<?php

function getMapCount(): int {
	return count(getMaps());
}

function getMaps(): array {
	static $maps = null;

	if ($maps !== null) {
		return $maps;
	}

	$var_names = [
		"MAP_NAME" => true,
		"MAP_AUTHOR" => true,
		"MAP_VERSION" => true,
		"MAP_DATE" => true,
		"MAP_RANK" => false,
		"MAP_ICON" => false,
		"MAP_LINK" => false,
	];

	$maps = [];

	foreach (new DirectoryIterator(SRC . "map") as $dir) {
		if (!$dir->isDir() || $dir->isDot()) {
			continue;
		}

		$info_path = SRC . "map/" . $dir . "/data.php";

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

		$info["id"] = $dir->getFilename();
		$info["DateTimeObj"] = DateTime::createFromFormat("j/M/Y", $info["MAP_DATE"]);

		$maps[$info["id"]] = $info;
	}

	uasort($maps, fn($a, $b) => $b["DateTimeObj"] <=> $a["DateTimeObj"]);

	return $maps;
}

function getMapsAlphabetical(): array {
	$maps = getMaps();

	uasort($maps, fn($a, $b) => strcmp($a["MAP_NAME"], $b["MAP_NAME"]));

	return $maps;
}

function getMapsRanked(): array {
	$maps = getMaps();

	uksort($maps, fn($a, $b) => getMapRating($b) <=> getMapRating($a));

	return $maps;
}

function getMapName(string $map_id = ""): string {
	$map_id = $map_id ?: getCallerBaseDir();

	return getMaps()[$map_id]["MAP_NAME"];
}

function getMapIcon(string $map_id = ""): string {
	$map_id = $map_id ?: getCallerBaseDir();

	return getMaps()[$map_id]["MAP_ICON"] ?? "/map/{$map_id}/preview.png";
}

function getMapLink(string $map_id = ""): string {
	$map_id = $map_id ?: getCallerBaseDir();

	return getMaps()[$map_id]["MAP_LINK"] ?? "/map/{$map_id}/";
}

function getMapAuthorId(string $map_id = ""): string|array {
	$map_id = $map_id ?: getCallerBaseDir();

	return getMaps()[$map_id]["MAP_AUTHOR"];
}

function getMapAuthorIds(string $map_id = ""): array {
	$author_id = getMapAuthorId($map_id);

	return is_array($author_id) ? $author_id : [$author_id];
}

function getMapAuthorName(string $map_id = ""): string {
	$author_id = getMapAuthorId($map_id);

	if (is_array($author_id)) {
		$str = implode(" & ", getMapAuthorNames($map_id));

		return strlen($str) < 25 ? $str : "Multiple Authors";
	}

	return getUserName($author_id);
}

function getMapAuthorNames(string $map_id = ""): array {
	return array_map("getUserName", getMapAuthorIds($map_id));
}

function getMapDate(string $map_id = ""): string {
	$map_id = $map_id ?: getCallerBaseDir();

	return getMaps()[$map_id]["MAP_DATE"];
}

function getMapRank(string $map_id = ""): string {
	$map_id = $map_id ?: getCallerBaseDir();

	return getMaps()[$map_id]["MAP_RANK"]
		?? parseMapReviews($map_id)["rank"]
		?? "X";
}

function getMapRating(string $map_id = ""): float {
	$map_id = $map_id ?: getCallerBaseDir();

	return parseMapReviews($map_id)["total_rating"] ?? -1.0;
}

function parseMapReviews(string $map_id = ""): array {
	$map_id = $map_id ?: getCallerBaseDir();

	return parseReviews(SRC . "map/{$map_id}/reviews.php", "map/{$map_id}");
}
