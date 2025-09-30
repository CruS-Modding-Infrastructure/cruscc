<?php

function ratingToRank(?float $rating): string {
	return match(true) {
		$rating === null => "X",
		$rating >= 0.83 => "S",
		$rating >= 0.66 => "A",
		$rating >= 0.40 => "B",
		default => "C",
	};
}

function _createReview(string $text, string $user = "", string $rating = ""): array {
	$user = $user ?: "Anonymous";

	$review = [
		"user" => $user,
		"text" => $text,
	];

	if ($rating) {
		$review["rating"] = $rating;

		$value = getRatingValue($rating);

		if ($value !== null) {
			$review["value"] = $value;
		}
	}

	return $review;
}

function getRatingValue(string $rating): ?float {
	return @($p = explode("/", $rating, 2))[1] ? $p[0] / $p[1] : null;
}

function Review(string $text, string $user = "", string $rating = "") : void {
	global $__reviews;

	if (isset($__reviews)) {
		$__reviews[] = _createReview($text, $user, $rating);
	}
};

function parseReviews(string $path, string $identifier = ""): array {
	static $cache = [];

	$key = $identifier ?: realpath($path);

	if (isset($cache[$key])) {
		return $cache[$key];
	}

	if (!file_exists($path)) {
		return [];
	}

	global $__reviews;
	$__reviews = [];

	try {
		include $path;

		$ratings = [];

		foreach ($__reviews as $review) {
			if (isset($review["value"])) {
				$ratings[] = $review["value"];
			}
		}

		$total_rating = empty($ratings) ? null
			: array_sum($ratings) / count($ratings);

		$cache[$key] = [
			"list" => &$__reviews,
			"total_rating" => $total_rating,
			"rank" => ratingToRank($total_rating),
		];
	} finally {
		unset($__reviews);
	}

	return $cache[$key];
}
