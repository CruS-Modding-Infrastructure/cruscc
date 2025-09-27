<?php

// full name of the map
$MAP_NAME = "An Example Map Name";

// author's string id, not full name, example: use "keith_mason" instead of "Keith Mason"
$MAP_AUTHOR = "example_author";
// however, you can prefix the name with ? if you just want to use the full name
// (this is for authors that don't want a godhead page or whatever)
$MAP_AUTHOR = "?Example Author Name";
// use a list for $MAP_AUTHOR if there's multiple authors
$MAP_AUTHOR = [
	"example_author1",
	"example_author2",
	"?Anonymous Author",
];

// latest version string, can be anything, doesn't have to be numbers
$MAP_VERSION = "1.0.0";

// submission date, needs to be in DD/MMM/YYYY format
// month part should be exactly three letters long
$MAP_DATE = "01/JAN/1970";

// optional, overrides the calculated rank from reviews
// possible values are: New, S, A, B, C, X
$MAP_RANK = "New";

// list of download links for the map
$MAP_DOWNLOAD = [
	// first link is the main download
	// name and hover for entries like these are automagically parsed
	"https://www.mediafire.com/file/example_map.zip",
	"https://www.dropbox.com/scl/fi/example_map.zip",
	// for more control, use an associative array like this:
	[
		// optional, automatically parsed from link
		"name" => "Google Drive",
		// required
		"link" => "https://drive.google.com/file/d/EXAMPLEMAP/view",
		// optional, defaults to "Download from {name}"
		"hover" => "Download from Google Drive",
	],
	[
		"name" => "2",
		"link" => "https://drive.google.com/file/d/EXAMPLEMAPAGAIN/view",
		"hover" => "Download from Google Drive (Mirror)",
	],
];

// optional
$MAP_ARCHIVE = [
	[
		// optional, defaults to current map name
		"name" => "Example Beta Map",
		// required, same rules as $MAP_VERSION
		"version" => "0.1.0",
		// required, same rules as $MAP_DOWNLOAD
		"download" => [
			"https://www.mediafire.com/file/example_map_beta.zip",
		],
	],
	[
		"name" => "Example Alpha Map",
		"version" => "0.0.1",
		"download" => [
			"https://www.mediafire.com/file/example_map_alpha.zip",
		],
	],
];

// optional, defaults to "/map/{map_id}/preview.png"
$MAP_ICON = "/textures/whatever.png";

// optional, defaults to "/map/{map_id}/"
// you may use this if you want to list a map that links externally
$MAP_LINK = "https://gamebanana.com/mods/12345";

// you can also make any custom variable
// you may use this for map description and objectives or whatever if you want
$MAP_EXAMPLEVAR = "example value";
