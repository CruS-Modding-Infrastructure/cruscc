<?php

require_once "core_maps.php";
require_once "core_mods.php";
require_once "core_users.php";
require_once "core_reviews.php";

function component(string $path, mixed ...$vars): void {
	extract($vars);
	include(SRC . "gutworx/components/" . $path . ".php");
}

function getCallerScript(): string {
	return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]["file"];
}

function getCallerBaseDir(): string {
	return basename(dirname(getCallerScript()));
}
