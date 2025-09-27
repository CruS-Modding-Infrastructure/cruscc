<?php

function _createReview(string $user = "", string $rating = "", string $text): array {
	if (!$user) {
		$user = "Anonymous";
	}

	$review = [
		"user" => $user,
		"text" => $text,
	];

	if (isset($rating)) {
		$review["rating"] = $rating;

		$value = getRatingValue($rating);

		if ($value !== null) {
			$review["value"] = $value;
		}
	}

	return $review;
}

function getRatingValue(string $rating): ?float {
	return @($p = explode('/', $rating, 2))[1] ? $p[0] / $p[1] : null;
}

function Review(string $user = "", string $rating = "", string $text) : void {
	global $__reviews;

	if (isset($__reviews)) {
		$__reviews[] = _createReview($user, $rating, $text);
	}
};

function parseReviews(string $path): array {
	static $cache = [];

	$key = realpath($path);

	if (isset($cache[$key])) {
		return $cache[$key];
	}

	global $__reviews;
	$__reviews = [];

	try {
		include $path;

		$cache[$key] = &$__reviews;
	} finally {
		unset($__reviews);
	}

	return $cache[$key];
}
