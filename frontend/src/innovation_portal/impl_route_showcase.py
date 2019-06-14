from flask import redirect, render_template, url_for

def handle_request(request):
    if len(request.args) == 0:
        return redirect(url_for('showcase', view=app.config['DEFAULT_VIEW']))

    return render_template("showcase.html")