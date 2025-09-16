<?php

//$ALLOWED_EXTENSIONS = "apng asc atom avif bin cjs css csv dae eot epub geojson gif glb glsl gltf gpg htm html ico jpeg jpg js json key kml knowl less manifest map markdown md mf mid midi mjs mtl obj opml osdx otf pdf pgp pls png py rdf resolveHandle rss sass scss svg text toml ts tsv ttf txt webapp webmanifest webp woff woff2 xcf xml yaml yml";
$ALLOWED_EXTENSIONS = "html css jpg png gif svg ico";

$ROOT = __DIR__ . "/src/";
$DEVMODE = in_array("dev", $argv);

$ALLOWED_EXTENSIONS = array_fill_keys(explode(" ", $ALLOWED_EXTENSIONS), true);

function make_directory(string $path) {
	if (is_dir($path) === false && mkdir($path, 0755, true) === false) {
		throw new RuntimeException("Failed to make directory: " . $path);
	}
}

if (is_dir("build")) {
	foreach (
		new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator("build", RecursiveDirectoryIterator::SKIP_DOTS),
			RecursiveIteratorIterator::CHILD_FIRST
		) as $file
	) {
		if ($file->isDir()) {
			rmdir($file->getRealPath());
		} else {
			unlink($file->getRealPath());
		}
	}
} else {
	make_directory("build");
}

$count_php = 0;
$count_built = 0;
$count_copied = 0;
$count_ignored = 0;

foreach (
	new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator("src", RecursiveDirectoryIterator::SKIP_DOTS),
		RecursiveIteratorIterator::SELF_FIRST
	) as $file
) {
	if ($file->isFile() === false) {
		continue;
	}

	$ext = strtolower($file->getExtension());

	$path = $file->getPathname();

	if ($ext === "php") {
		if ($file->getFilename() === "index.php") {
			echo "Generating HTML from PHP...\n\tSource: " . $path . "\n";

			//$newpath = preg_replace("/^src\/(.+).php$/", "build/$1.html", $path);
			$newpath = "build/" . substr($path, 4, -4) . ".html";

			make_directory(dirname($newpath));

			ob_start();

			require_once $path;

			if (file_put_contents($newpath, ob_get_clean()) === false) {
				throw new RuntimeException("Failed to write to ". $newpath);
			}

			$count_built++;

			echo "\tSuccess: " . $newpath . "\n";
		} else {
			echo "PHP file not copied: " . $path . "\n";
		}

		$count_php++;
	} elseif (isset($ALLOWED_EXTENSIONS[$ext])) {
		echo "Copying file...\n\tSource: " . $path . "\n";

		//$newpath = preg_replace("/^src\//", "build/", $path);
		$newpath = "build/" . substr($path, 4);

		make_directory(dirname($newpath));

		if (copy($path, $newpath) === false) {
			throw new RuntimeException("Failed to copy to ". $newpath);
		}

		$count_copied++;

		echo "\tSuccess: " . $newpath . "\n";
	} else {
		$count_ignored++;

		echo "File ignored: " . $path . "\n";
	}
}

echo $count_php . " PHP files detected\n";
echo $count_built . " PHP files built\n";
echo $count_copied . " asset files copied\n";
echo $count_ignored . " files ignored\n";
