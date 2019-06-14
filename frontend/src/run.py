from innovation_portal import app

# TODO Move to somewhere configurable
app.config['DEFAULT_VIEW'] = "featured"

app.run(host='0.0.0.0', port=5000, debug=True)