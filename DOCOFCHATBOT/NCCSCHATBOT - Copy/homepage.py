import os
import pandas as pd
import numpy as np
import tensorflow as tf
from flask import Flask, render_template, request, send_from_directory
from sklearn.preprocessing import LabelEncoder
from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.naive_bayes import MultinomialNB
from tensorflow.keras.preprocessing.text import Tokenizer
from tensorflow.keras.preprocessing.sequence import pad_sequences
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Embedding, LSTM, Dropout, Dense, BatchNormalization
from gtts import gTTS
import io
import sys

app = Flask(__name__)
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

# Load and preprocess the dataset
dataset_path = os.path.join('datasets', 'cleaned_finalnccsdata.csv')
try:
    df = pd.read_csv(dataset_path)
    print("CSV file read successfully")
    if 'tag' not in df.columns or 'query' not in df.columns or 'response' not in df.columns:
        raise ValueError("CSV must contain 'tag', 'query', and 'response'")
    df = df.dropna()
except Exception as e:
    print(f"Error reading the dataset: {e}")
    df = pd.DataFrame({'tag': [], 'query': [], 'response': []})

# Tokenizer and padding
tokenizer = Tokenizer(num_words=5000, oov_token="<OOV>")  #previous num_words = 1000
if not df.empty:
    tokenizer.fit_on_texts(df['query'].values)

max_length = 20
padding_type = 'post'
truncating_type = 'post'

sequences = tokenizer.texts_to_sequences(df['query'].values)
padded_sequences = pad_sequences(sequences, maxlen=max_length, padding=padding_type, truncating=truncating_type)

# Label Encoding
label_encoder = LabelEncoder()
encoded_tags = label_encoder.fit_transform(df['tag'].values)

# TF-IDF + Naive Bayes
tfidf_vectorizer = TfidfVectorizer()
X_tfidf = tfidf_vectorizer.fit_transform(df['query'].values)
naive_model = MultinomialNB()
naive_model.fit(X_tfidf, encoded_tags)

# LSTM model
model = Sequential([
    Embedding(1000, 128, input_length=max_length),
    LSTM(128, return_sequences=True),
    Dropout(0.2),
    LSTM(64),
    Dropout(0.2),
    Dense(64, activation='tanh'),
    BatchNormalization(),
    Dense(len(np.unique(encoded_tags)), activation='softmax')
])

model.compile(loss='sparse_categorical_crossentropy', optimizer='adam', metrics=['accuracy'])
if not df.empty:
    model.fit(padded_sequences, encoded_tags, epochs=200, verbose=2)

# HOMEPAGE ROUTE
@app.route('/', methods=['GET', 'POST'])
def homepage():
    chatbot_response_lstm = ""
    chatbot_response_naive = ""
    user_query = ""

    if request.method == 'POST':
        user_query = request.form['user_query']
        user_sequence = tokenizer.texts_to_sequences([user_query])

        if not user_sequence or not user_sequence[0]:
            chatbot_response_lstm = chatbot_response_naive = "Sorry, I didn't understand that. Can you rephrase?"
        else:
            # LSTM Prediction
            padded_user_sequence = pad_sequences(user_sequence, maxlen=max_length, padding=padding_type, truncating=truncating_type)
            prediction = model.predict(padded_user_sequence)
            tag_index_lstm = np.argmax(prediction)
            tag_lstm = label_encoder.inverse_transform([tag_index_lstm])[0]
            response_df_lstm = df[df['tag'] == tag_lstm]
            chatbot_response_lstm = response_df_lstm.sample(n=1)['response'].values[0] if not response_df_lstm.empty else "No LSTM response found."

            # Naive Bayes Prediction
            user_tfidf = tfidf_vectorizer.transform([user_query])
            tag_index_nb = naive_model.predict(user_tfidf)[0]
            tag_nb = label_encoder.inverse_transform([tag_index_nb])[0]
            response_df_nb = df[df['tag'] == tag_nb]
            chatbot_response_naive = response_df_nb.sample(n=1)['response'].values[0] if not response_df_nb.empty else "No NB response found."

            # Generate audio for LSTM response
           # Generate audio for both LSTM and Naive Bayes responses
            tts_lstm = gTTS(chatbot_response_lstm, lang='en')
            tts_lstm.save("static/response_lstm.mp3")

            tts_naive = gTTS(chatbot_response_naive, lang='en')
            tts_naive.save("static/response_naive.mp3")



    return render_template('index.html',
                           user_query=user_query,
                           chatbot_response_lstm=chatbot_response_lstm,
                           chatbot_response_naive=chatbot_response_naive)

@app.route('/play_response')
def play_response():
    model_type = request.args.get('model')
    if model_type == 'naive':
        filename = 'response_naive.mp3'
    else:
        filename = 'response_lstm.mp3'
    return send_from_directory('static', filename)

if __name__ == '__main__':
    app.run(debug=True)
