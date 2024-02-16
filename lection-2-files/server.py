# server.py

import http.server
import socketserver
import json

PORT = 8000

class MyHandler(http.server.BaseHTTPRequestHandler):
    def do_POST(self):
        content_length = int(self.headers['Content-Length'])
        post_data = self.rfile.read(content_length)
        post_data = json.loads(post_data.decode('utf-8'))

        self.send_response(200)
        self.send_header('Content-type', 'application/json')
        self.end_headers()

        response_message = {'data': post_data}
        self.wfile.write(json.dumps(response_message).encode('utf-8'))

with socketserver.TCPServer(("", PORT), MyHandler) as httpd:
    print("Server started at localhost:" + str(PORT))
    httpd.serve_forever()
