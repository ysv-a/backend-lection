import os
from flask import Flask, render_template, request, redirect, url_for, send_file, make_response, session
from werkzeug.utils import secure_filename
import xmltodict

UPLOAD_FOLDER = os.path.abspath("uploads")
ALLOWED_EXTENSIONS = {'txt', 'pdf', 'png', 'jpg', 'jpeg', 'gif'}

app = Flask(__name__)
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER
# app.secret_key = b'_5#y2L"F4Q8z\n\xec]/'



def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS




@app.route('/')
def home():
    return render_template('index.html')

@app.route('/landing')
def landing():
    return "landing"



@app.route('/test-get', methods=["GET"])
def test_get():
    print(request.args.get('filter', ''))
    return "OK"

@app.route('/test-post', methods=["POST"])
def test_post():
    print(request.form)
    return "OK"


@app.route('/test-json', methods=["POST"])
def test_json():
    print(request.json)
    return request.json

@app.route('/test-xml', methods=["POST"])
def test_xml():
    if request.headers.get('Content-Type') == 'application/xml':
        data = request.data
        return xmltodict.parse(data)
        # decoded_string = data.decode("utf-8") # Bytes to String
        # print(decoded_string.split("HAHA"))
        # return "OK"

    return "ERROR"

@app.route('/upload_file', methods=['POST'])
def upload_file():
    file = request.files['file']
    print(request.form)
    print(file)

    if file and allowed_file(file.filename):
        filename = secure_filename(file.filename)
        file.save(os.path.join(app.config['UPLOAD_FOLDER'], filename))
        return redirect(url_for('home'))

    return "OK"


@app.route('/open-file', methods=["GET"])
def open_file():
    return send_file(UPLOAD_FOLDER + '/sample.pdf',   download_name="report.pdf")


@app.route('/cookie-example', methods=["GET"])
def cookie_example():
    #username = request.cookies.get('username')
    name = request.args.get('name', '')
    # session['first_name'] = name
    response = make_response(redirect(url_for('home')))
    response.set_cookie('username', name, httponly=True)
    return response
