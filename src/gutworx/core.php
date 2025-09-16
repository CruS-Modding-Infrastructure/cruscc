<?php

function component(string $path) {
	global $ROOT;
	include($ROOT . "gutworx/components/" . $path . ".php");
}
