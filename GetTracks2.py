#This parses files with a different format

import csv
import requests
from bs4 import BeautifulSoup

with open('classic-rock-raw-data.csv', newline='') as csvfile:
    tracksDict = dict()
    for row in csvfile.readlines():
        array = row.split(',')
        songName = array[0].strip('\"')
        songName = songName.strip(' ')
        artist = array[1].strip('\"')
        artist = artist.strip(' ')
        tracksDict[songName] = artist
    #del tracksDict['Track Name']

_URL_API = "https://api.genius.com"
_URL_SEARCH = "/search"
headers = {'Authorization': 'Bearer d76WV7aLIYyIopyOou-UA9K91xBeWtIFqvUlh4Z3Bvt4cxpL5lngniUNpj8ZzJpZ'}

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
    outputFile = open("ClassicRock.txt", "w")
    for key in tracksDict:
        query = _URL_API + _URL_SEARCH
        searchWithArtist = key + " " + tracksDict[key]
        data = {'q': searchWithArtist}
        response = requests.get(query, data=data, headers=headers)
        json = response.json()
        song_info = None
        artist = tracksDict[key]
        # for hit in json["response"]["hits"]:
        #     print(hit["result"]["primary_artist"]["name"].lower() == artist.lower())
        #     if hit["result"]["primary_artist"]["name"].lower() == artist.lower():
        #         print("hi")
        #         song_info = hit
        #         break
        if len(json["response"]["hits"]) > 0:
            song_info = json["response"]["hits"][0]
            print(song_info)
        if song_info:
            song_api_path = song_info["result"]["api_path"]
            lyrics = lyrics_from_song_api(song_api_path)
            outputFile.write(lyrics)
    outputFile.close()
