from http.server import SimpleHTTPRequestHandler
from socketserver import TCPServer
from pathlib import Path

class TestServer(SimpleHTTPRequestHandler):
	def translate_path(self, path_orig):
		path = Path(path_orig)

		if path_orig.endswith("/"):
			path /= "index.html"

		if path.is_absolute():
			path = path.relative_to("/")

		path_new = Path("build") / path

		if not path_new.exists():
			path_new = Path("assets") / path

		return super().translate_path(str(path_new))

TCPServer.allow_reuse_address = True

with TCPServer(("", 8000), TestServer) as httpd:
	print("Serving site at http://localhost:8000/index.html ...")
	print("Press Ctrl+C to stop the server")
	try:
		httpd.serve_forever()
	except KeyboardInterrupt:
		print("Keyboard interrupt received, exiting.")
