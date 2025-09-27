import os, time

WATCH_PATH = "src"
BUILD_CMD = "php build.php dev"

num_builds = 0

def run_build(events = None):
	global num_builds
	num_builds += 1

	os.system("cls" if os.name == "nt" else "clear")

	print(f" ======== BUILD #{num_builds} START ======== ")

	if os.system(BUILD_CMD):
		print(f" ======== BUILD #{num_builds} FAIL ======== ")
	else:
		print(f" ======== BUILD #{num_builds} SUCCESS ======== ")

	if events:
		print("File changes:")
		for event in events:
			print(f"{event.event_type[0].upper()} {event.src_path}")

	print("Press Ctrl+C to stop watching files")

try:
	from watchdog.observers import Observer
	from watchdog.events import FileSystemEventHandler
	from threading import Thread
	from queue import Queue

	event_queue = Queue()

	def build_worker():
		run_build()

		while True:
			events = [event_queue.get()]

			time.sleep(0.3)

			while event_queue.qsize():
				events.append(event_queue.get())

			run_build(events)

	def on_modified(event):
		if not event.is_directory:
			event_queue.put(event)

	handler = FileSystemEventHandler()
	handler.on_modified = on_modified
	handler.on_created = on_modified
	handler.on_deleted = on_modified
	handler.on_moved = on_modified

	observer = Observer()
	observer.schedule(handler, WATCH_PATH, recursive=True)
	observer.daemon = True
	observer.start()

	Thread(target=build_worker, daemon=True).start()

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

		for entry in recursive_scan(WATCH_PATH):
			current ^= hash((entry.path, entry.stat().st_mtime))

		if current != previous:
			previous = current

			run_build()

		try:
			time.sleep(2.0)
		except KeyboardInterrupt:
			print("Keyboard interrupt received, exiting.")
			break
