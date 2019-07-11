from flask import Blueprint, current_app, redirect, request, url_for
from . import render_methods as Renderers

showcase = Blueprint('showcase', __name__)


@showcase.route('/')
@showcase.route('/showcase', methods=['GET','POST'])
def navigate():
    # FIXME What if args contains data we need to preserve but not view?
    if len(request.args) == 0 or 'view' not in request.args:
        return redirect(url_for('showcase.navigate', view=current_app.config['DEFAULT_VIEW']))

    view = request.args.get('view')
    if "featured" == view:
        return Renderers.featured(request)
    if "frequently-viewed" == view:
        return Renderers.frequently_viewed(request)
    elif "newly-added" == view:
        return Renderers.newly_added(request)
    elif "simple-search" == view:
        return Renderers.simpler_search(request)
    else:
        return Renderers.default(request)