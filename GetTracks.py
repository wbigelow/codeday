import csv
import requests
from bs4 import BeautifulSoup

with open('regional-us-daily-latest.csv', newline='') as csvfile:
    tracksDict = dict()
    for row in csvfile.readlines():
        array = row.split(',')
        artist = array[2].strip('\"')
        songName = array[1].strip('\"')
        tracksDict[songName] = artist
    del tracksDict['Track Name']

_URL_API = "https://api.genius.com"
_URL_SEARCH = "/search"
headers = {'Authorization': 'Bearer JDndxEZOpwM-t1usfurLT3MnTXhyypjV9445CmtYrVc72yBbMQupyEJB_4BasnvG'}

def lyrics_from_song_api(song_api_path):
    song_url = _URL_API + song_api_path
    response = requests.get(song_url, headers=headers)
    json = response.json()
    path = json["response"]["song"]["path"]
    page_url = "http://genius.com" + path
    page = requests.get(page_url)
    html = BeautifulSoup(page.text, "html.parser")
    [h.extract() for h in html('script')]
    lyrics = html.find("div", class_="lyrics").get_text()
    return lyrics

if __name__ == "__main__":
    outputFile = open("Output.txt", "w")
    for key in tracksDict:
        query = _URL_API + _URL_SEARCH
        data = {'q': key}
        response = requests.get(query, data=data, headers=headers)
        json = response.json()
        song_info = None
        artist = tracksDict[key]
        for hit in json["response"]["hits"]:
            if hit["result"]["primary_artist"]["name"] == artist:
                song_info = hit
                break
        if song_info:
            song_api_path = song_info["result"]["api_path"]
            lyrics = lyrics_from_song_api(song_api_path)
            outputFile.write(lyrics)
    outputFile.close()
