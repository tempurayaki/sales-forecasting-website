from flask import Flask, request, jsonify
from tensorflow.keras.models import load_model
import numpy as np

# Muat model LSTM
model = load_model('model/path_to_your_model.h5')

# Inisialisasi Flask app
app = Flask(__name__)

# Fungsi untuk memproses input dan membuat prediksi
def forecast_sales(data):
    # Proses data input sesuai dengan yang diharapkan oleh model
    data = np.array(data).reshape(1, -1)  # Sesuaikan dengan modelmu
    prediksi = model.predict(data)  # Prediksi menggunakan model LSTM
    return prediksi[0][0]  # Kembalikan prediksi (misalnya, penjualan berikutnya)

# Endpoint untuk menerima permintaan prediksi
@app.route('/predict', methods=['POST'])
def predict():
    content = request.get_json()  # Ambil data dari body request
    data = content['data']  # Ambil data yang diperlukan untuk prediksi
    forecast = forecast_sales(data)  # Prediksi penjualan
    return jsonify({'forecast': forecast})  # Kirimkan hasil prediksi dalam format JSON

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0')  # Menjalankan server Flask
