# import os
# import pandas as pd
# import numpy as np
# import tensorflow as tf
# from flask import Flask, render_template, request, send_from_directory
# from sklearn.preprocessing import LabelEncoder
# from tensorflow.keras.preprocessing.text import Tokenizer
# from tensorflow.keras.preprocessing.sequence import pad_sequences
# from tensorflow.keras.models import Sequential
# from tensorflow.keras.layers import Embedding, LSTM, Dense
# from gtts import gTTS
# import io
# import sys


# from tensorflow.keras.models import Sequential
# from tensorflow.keras.layers import Embedding, LSTM, Dropout, Dense, BatchNormalization
# app = Flask(__name__)

# # Ensure the default encoding is set to UTF-8
# sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

# # Load and preprocess the dataset
# dataset_path = os.path.join('datasets', 'finalnccsdata.csv')
# try:
#     df = pd.read_csv(dataset_path)
#     print("CSV file read successfully")
#     print("DataFrame columns:", df.columns)
#     print("DataFrame head:\n", df.head())
#     if 'tag' not in df.columns or 'query' not in df.columns or 'response' not in df.columns:
#         raise ValueError("CSV file must contain 'tag', 'query', and 'response' columns")
    
#     # Drop any rows with NaN values
#     df = df.dropna()
# except Exception as e:
#     print(f"Error reading the dataset: {e}")
#     df = pd.DataFrame({'tag': [], 'query': [], 'response': []})

# # Prepare the tokenizer and sequences
# tokenizer = Tokenizer(num_words=1000, oov_token="<OOV>")
# if not df.empty:
#     tokenizer.fit_on_texts(df['query'].values)
# max_length = 20
# padding_type = 'post'
# truncating_type = 'post'

# # Tokenize and pad sequences
# sequences = tokenizer.texts_to_sequences(df['query'].values)
# padded_sequences = pad_sequences(sequences, maxlen=max_length, padding=padding_type, truncating=truncating_type)

# # Encode tags
# label_encoder = LabelEncoder()
# encoded_tags = label_encoder.fit_transform(df['tag'].values)

# # Define the LSTM model
# # i will revert again from here
# # model = Sequential([
# #     Embedding(1000, 64, input_length=max_length),
# #     LSTM(64),
# #     Dense(64, activation='relu'),
# #     Dense(len(np.unique(encoded_tags)), activation='softmax')
# # ])
# # changedcode
# model = Sequential([
#     Embedding(1000, 128, input_length=max_length),
#     LSTM(128, return_sequences=True),
#     Dropout(0.2),
#     LSTM(64),
#     Dropout(0.2),
#     Dense(64, activation='tanh'),
#     BatchNormalization(),
#     Dense(len(np.unique(encoded_tags)), activation='softmax')
# ])

# # Compile the model
# model.compile(loss='sparse_categorical_crossentropy', optimizer='adam', metrics=['accuracy'])

# # Fit the model
# if not df.empty:
#     model.fit(padded_sequences, encoded_tags, epochs=200, verbose=2)

# @app.route('/', methods=['GET', 'POST'])
# def homepage():
#     chatbot_response = ""
#     user_query = ""
#     if request.method == 'POST':
#         user_query = request.form['user_query']
#         # Process the user_query and generate a response
#         user_sequence = tokenizer.texts_to_sequences([user_query])
#         print("User sequence:", user_sequence)
#         if not user_sequence or not user_sequence[0]:  # if the sequence is empty or None
#             chatbot_response = "Sorry, I didn't understand that. Can you please rephrase?"
#         else:
#             padded_user_sequence = pad_sequences(user_sequence, maxlen=max_length, padding=padding_type, truncating=truncating_type)
#             prediction = model.predict(padded_user_sequence)
#             tag_index = np.argmax(prediction)
#             tag = label_encoder.inverse_transform([tag_index])[0]
#             print("Predicted tag:", tag)  # Debug print
#             response_df = df[df['tag'] == tag]
#             print("Response DF:\n", response_df)  # Debug print
#             if not response_df.empty:
#                 chatbot_response = response_df.sample(n=1)['response'].values[0]
#             else:
#                 chatbot_response = "Sorry, I don't have an answer for that."
            
#             # Convert the response to speech
#             tts = gTTS(chatbot_response, lang='en')
#             tts.save("static/response.mp3")
#     return render_template('index.html', user_query=user_query, chatbot_response=chatbot_response)

# @app.route('/play_response')
# def play_response():
#     return send_from_directory('static', 'response.mp3')

# if __name__ == '__main__':
#     app.run(debug=True)
import os
import pandas as pd
import numpy as np
import tensorflow as tf
from flask import Flask, render_template, request, send_from_directory
from sklearn.preprocessing import LabelEncoder
from tensorflow.keras.preprocessing.text import Tokenizer
from tensorflow.keras.preprocessing.sequence import pad_sequences
from tensorflow.keras.models import Sequential, load_model
from tensorflow.keras.layers import Embedding, LSTM, Dropout, Dense, BatchNormalization
from gtts import gTTS
import io
import sys

app = Flask(__name__)
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding='utf-8')

# Load and preprocess the dataset
dataset_path = os.path.join('datasets', 'finalnccsdata.csv')
try:
    df = pd.read_csv(dataset_path)
    print("CSV file read successfully")
    if 'tag' not in df.columns or 'query' not in df.columns or 'response' not in df.columns:
        raise ValueError("CSV file must contain 'tag', 'query', and 'response' columns")
    df = df.dropna()
except Exception as e:
    print(f"Error reading the dataset: {e}")
    df = pd.DataFrame({'tag': [], 'query': [], 'response': []})

# Tokenizer and padding
tokenizer = Tokenizer(num_words=1000, oov_token="<OOV>")
if not df.empty:
    tokenizer.fit_on_texts(df['query'].values)

max_length = 20
padding_type = 'post'
truncating_type = 'post'

sequences = tokenizer.texts_to_sequences(df['query'].values)
padded_sequences = pad_sequences(sequences, maxlen=max_length, padding=padding_type, truncating=truncating_type)

# Label encoding
label_encoder = LabelEncoder()
encoded_tags = label_encoder.fit_transform(df['tag'].values)

# Check if saved model exists
model_path = "chatbot_model.h5"
if os.path.exists(model_path):
    print("Loading trained model from file...")
    model = load_model(model_path)
else:
    print("Training new model...")
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
    model.fit(padded_sequences, encoded_tags, epochs=200, verbose=2)
    model.save(model_path)
    print("Model trained and saved.")

# @app.route('/', methods=['GET', 'POST'])
# def homepage():
#     chatbot_response = ""
#     user_query = ""
#     if request.method == 'POST':
#         user_query = request.form['user_query']
#         user_sequence = tokenizer.texts_to_sequences([user_query])
#         if not user_sequence or not user_sequence[0]:
#             chatbot_response = "Sorry, I didn't understand that. Can you please rephrase?"
#         else:
#             padded_user_sequence = pad_sequences(user_sequence, maxlen=max_length, padding=padding_type, truncating=truncating_type)
#             prediction = model.predict(padded_user_sequence, verbose=0)
#             tag_index = np.argmax(prediction)
#             tag = label_encoder.inverse_transform([tag_index])[0]
#             response_df = df[df['tag'] == tag]
#             if not response_df.empty:
#                 chatbot_response = response_df.sample(n=1)['response'].values[0]
#             else:
#                 chatbot_response = "Sorry, I don't have an answer for that."
#             tts = gTTS(chatbot_response, lang='en')
#             tts.save("static/response.mp3")
#     return render_template('index.html', user_query=user_query, chatbot_response=chatbot_response)
@app.route('/guest', methods=['GET', 'POST'])
def guest_homepage():
    return handle_chat('index_guest.html')

@app.route('/user', methods=['GET', 'POST'])
def user_homepage():
    return handle_chat('index_user.html')

def handle_chat(template_name):
    chatbot_response = ""
    user_query = ""
    if request.method == 'POST':
        user_query = request.form['user_query']
        user_sequence = tokenizer.texts_to_sequences([user_query])
        if not user_sequence or not user_sequence[0]:
            chatbot_response = "Sorry, I didn't understand that. Can you please rephrase?"
        else:
            padded_user_sequence = pad_sequences(
                user_sequence, maxlen=max_length, padding=padding_type, truncating=truncating_type
            )
            prediction = model.predict(padded_user_sequence, verbose=0)
            tag_index = np.argmax(prediction)
            tag = label_encoder.inverse_transform([tag_index])[0]
            response_df = df[df['tag'] == tag]
            if not response_df.empty:
                chatbot_response = response_df.sample(n=1)['response'].values[0]
            else:
                chatbot_response = "Sorry, I don't have an answer for that."
            tts = gTTS(chatbot_response, lang='en')
            tts.save("static/response.mp3")
    return render_template(template_name, user_query=user_query, chatbot_response=chatbot_response)


@app.route('/play_response')
def play_response():
    return send_from_directory('static', 'response.mp3')

if __name__ == '__main__':
    
    app.run(debug=True)
