from flask import current_app, redirect, render_template, url_for
import json
import requests

from innovation_portal.services import banner_quote, bls_request

def default(user_request):
    return render_template("showcase.html")

def featured(user_request):
    # Fetch content
    serv_response = bls_request.send_request(
        request="showcase-featured")

    # Check content result
    # if serv_response.status != 200:
    #     route_whoopsie.handle_request(serv_response)

    # Convert to dict
    content = serv_response.json()

    print(f"serv_response payload:\n{content}")

    return render_template(
        "showcase.html",
        banner_quote=banner_quote.get_quote(),
        content_label="Featured Projects",
        projects=content['projects'])

def frequently_viewed(user_request):
    return render_template("showcase.html")

def newly_added(user_request):
    return render_template("showcase.html")

def simple_search(user_request):
    return render_template("showcase.html")