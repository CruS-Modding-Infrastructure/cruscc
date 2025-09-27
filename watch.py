import os, time

BUILD_CMD = "php build.php dev"

num_builds = 0

def run_build():
	global num_builds
	num_builds += 1

	os.system("cls" if os.name == "nt" else "clear")

	print(f" ======== BUILD #{num_builds} START ======== ")

	if os.system(BUILD_CMD):
		print(f" ======== BUILD #{num_builds} FAIL ======== ")
	else:
		print(f" ======== BUILD #{num_builds} SUCCESS ======== ")

	print("Press Ctrl+C to stop watching files")

try:
	import threading
	from watchdog.observers import Observer
	from watchdog.events import FileSystemEventHandler

	build_event = threading.Event()

	def build_worker():
		while True:
			build_event.wait()
			time.sleep(0.2)
			build_event.clear()

			run_build()

	def on_modified(event):
		build_event.set()

	handler = FileSystemEventHandler()
	handler.on_modified = on_modified
	handler.on_created = on_modified
	handler.on_deleted = on_modified
	handler.on_moved = on_modified

	observer = Observer()
	observer.schedule(handler, "src", recursive=True)
	observer.daemon = True
	observer.start()

	threading.Thread(target=build_worker, daemon=True).start()

	build_event.set()

	try:
		observer.join()
	except KeyboardInterrupt:
		print("Keyboard interrupt received, exiting.")
		observer.stop()
		observer.join()

except ImportError:
	def recursive_scan(path):
		for entry in os.scandir(path):
			if entry.is_dir():
				yield from recursive_scan(entry.path)
			elif entry.is_file():
				yield entry

	previous = -1

	while True:
		current = 0

		for entry in recursive_scan("src"):
			current ^= hash((entry.path, entry.stat().st_mtime))

		if current != previous:
			previous = current

			run_build()

		try:
			time.sleep(2.0)
		except KeyboardInterrupt:
			print("Keyboard interrupt received, exiting.")
			break
