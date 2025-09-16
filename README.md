i made this because updating the crus.cc site is a headache, so now we can use php to make things a lot easier

(i also wanted to minimise the site's use of javascript and iframes)

this is essentially a static site generator, pushing to this repo will automatically render a static site and deploy changes to neocities using github actions

see sections below if you wanna develop the site on your local machine

## prerequisites

php 8

python 3

## file structure

the `index.php` files are the entrypoints and each of them correspond to an html page

(other php files don't get turned into pages)

```
map/
	mapname/
		index.php - actual web page for the map
		data.php - contains map data
		reviews/
			whatever.php - review filenames can be whatever
mod/
	modname/
		index.php - actual web page for the mod
		data.php - contains mod data
godhead/
	username/
		index.php - actual web page for the user
		data.php - contains user data
```

## generate html

```bash
php build.php
```

this goes through every `index.php` file in the `src` folder and renders them into html in the `build` folder

please note that this will overwrite the entire `build` folder (so don't store random stuff in it)

## preview site

```bash
python test.py
```

this hosts the site at https://localhost:8000

(this local site updates automatically whenever you build)

you need to put site assets in the `assets` folder first for this to work

(just download the whole neocities site and plop it in there, there's site downloaders out there idk just look them up)

## auto rebuild

```bash
find src/ -name '*.php' -o -name '*.css' | entr -c php build.php dev
```

if you wanna automatically run the build script whenever you edit a php or css file, you can run something like this on linux

this means you just have to refresh the page in your browser (assuming you have test.py running) without having to run the build script each time to see your changes

for windows idk lol, i just use WSL, git bash, or mingw on windows to maintain my sanity, so i would just run the same command through any of those

## pushing changes to neocities

make a pull request
