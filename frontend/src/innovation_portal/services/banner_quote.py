import random

_QUOTE_POOL_ = [
"Why do I need a role table?",
"Just use a string.",
"If it was up to me ...",
"I'm going to do it the normal way.",
"I made a dropdown!",
"git revert HEAD~3..HEAD",
"...It just has to work.",
"When you're right, you're right.",
"Entreprenuershipism."
]

def get_quote():
    return random.choice(_QUOTE_POOL_)