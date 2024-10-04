# sentiment_analysis.py
import sys
import json
from textblob import TextBlob

def analyze_sentiment(text):
    analysis = TextBlob(text)
    polarity = analysis.sentiment.polarity
    subjectivity = analysis.sentiment.subjectivity
    if polarity > 0:
        sentiment = 'Positive'
    elif polarity == 0:
        sentiment = 'Neutral'
    else:
        sentiment = 'Negative'
    return {'sentiment': sentiment, 'polarity': polarity, 'subjectivity': subjectivity}

if __name__ == "__main__":
    # Read input text from command line arguments
    input_text = sys.argv[1]
    result = analyze_sentiment(input_text)
    print(json.dumps(result))
