from enum import Enum

class AppMode(Enum):
    Unknown = 0
    IsolatedDevelop = 1
    Develop = 2
    Testing = 3
    Production = 4