from flask import Flask, request

from . import impl_route_showcase

app = Flask(__name__)

# TODO Can these be moved to it's only file?
# TODO Can there be a whole sub folder called "routes" that contain impl modules?
@app.route('/')
@app.route('/showcase', methods=['GET','POST'])
def showcase():
    return impl_route_showcase.handle_request(request)
