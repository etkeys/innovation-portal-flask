import json as lib_json
import os
import random
from requests import Request
import sys

class MockResponse(Request):
    def __init__(self, status_code, payload):
        self.status_code = status_code
        self.json_data = lib_json.loads(payload)
    
    def json(self, **kwargs):
        return self.json_data

    def status_code(self):
        return self.status_code


class MockResponseFactory():
    def __init__(self, **user_request):
        self.request = user_request
    
    def create_response(self):
        req_type = self.request['request'].split('-')[0]

        if 'showcase' == req_type:
            return self.create_showcase_response()
        else:
            return self.create_404_response()
        
        pass
    
    def create_404_response(self):
        return MockResponse(404, "{ }")

    def create_showcase_response(self):
        req = self.request["request"]
        if 'showcase-featured' == self.request["request"]:
            payload = get_mock_payload(prefix=req)
            return MockResponse(200, payload)
        else:
            return self.create_404_response()


def get_mock_file_root_dir():
    encoding = sys.getfilesystemencoding()
    return os.path.join(
        os.path.dirname(__file__),
        '..',
        '..',
        '_mocks',
        'bls_responses')

def get_mock_files(**kwargs):
    path = get_mock_file_root_dir()
    prefix = kwargs['prefix']

    print(f"path: {path}")
    print(f"prefix: {prefix}")

    print(f"files in dir\n{os.listdir(path)}")
    result = [os.path.join(path,f) for f in os.listdir(path)
                if os.path.isfile(os.path.join(path,f))]
                # if os.path.isfile(os.path.join(path, f) and
                #     f.startswith(prefix))]

    return result

def get_mock_payload(**kwargs):
    with open(random.choice(get_mock_files(**kwargs)), 'r') as f:
        content = f.read()

    return content
