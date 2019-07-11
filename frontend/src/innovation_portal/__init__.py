from flask import Flask, request

import innovation_portal.config as config

def create_app(config_class=config.IsolatedDevelop):
    app = Flask(__name__)
    app.config.from_object(config_class)
    
    from innovation_portal.showcase.routes import showcase
    app.register_blueprint(showcase)

    return app
    