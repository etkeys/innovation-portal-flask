from flask import current_app

from innovation_portal.enums import AppMode

def get_mock_response(*args, **kwargs):
    from innovation_portal.services.mocks import MockResponseFactory as mrf

    factory = mrf.MockResponseFactory(**kwargs)
    return factory.create_response()

def get_server_response(*args, **kwargs):
    pass

def send_request(*args, **kwargs):
    if AppMode.IsolatedDevelop == current_app.config["APP_MODE"]:
        return get_mock_response(*args, **kwargs)
    else:
        return get_server_response(*args, **kwargs)


    