<?php

function getUserName(string $user_id = ""): string {
	$user_id = $user_id ?: getCallerBaseDir();

	if (substr($user_id, 0, 1) === "?") {
		return substr($user_id, 1);
	}

	return $user_id;
}
