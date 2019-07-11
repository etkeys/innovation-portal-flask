
from innovation_portal.enums import AppMode

class Base(object):
    APP_MODE = AppMode.Unknown
    DEBUG = True
    DEFAULT_VIEW = 'featured'
    SERVER_NAME = 'localhost:5001'

class IsolatedDevelop(Base):
    APP_MODE = AppMode.IsolatedDevelop
