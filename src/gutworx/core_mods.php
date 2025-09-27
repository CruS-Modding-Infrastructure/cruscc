<?php

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

function getModCount(): int {
	return count(getMods());
}
