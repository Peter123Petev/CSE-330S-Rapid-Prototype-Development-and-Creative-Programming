import sys
import re


class Player:

    def __init__(self, name, at_bats, hits, runs):
        self.name = name
        self.at_bats = at_bats
        self.hits = hits
        self.runs = runs
        if self.at_bats > 0:
            self.batting_average = self.hits / self.at_bats
        else:
            self.at_bats = -1;

    def add_stats(self, at_bats, hits, runs):
        self.at_bats += at_bats
        self.hits += hits
        self.runs += runs
        if self.at_bats > 0:
            self.batting_average = self.hits / self.at_bats
        else:
            self.at_bats = -1;

    def toStats(self):
        return self.name + ": " + str(self.batting_average)


if len(sys.argv) != 2:
    print("Usage: python.exe " + str(sys.argv[0]) + " file_location")
    exit(0)

file_location = str(sys.argv[1])
players = {}

with open(file_location, 'r') as file:
    text = file.read()
    player_regex = re.compile(r"(\w*\s\w*\W\w*) batted (\d*) times with (\d*) hits and (\d*) runs")
    matches = player_regex.findall(text)
    if matches is not None:
        for event in matches:
            name = event[0]
            at_bats = event[1]
            hits = event[2]
            runs = event[3]
            if name in players.keys():
                players[name].add_stats(int(at_bats), int(hits), int(runs))
            else:
                players[name] = Player(name, int(at_bats), int(hits), int(runs))

    else:
        print("No matches.")

bas_players = zip([players[key].batting_average for key in players], [players[key].name for key in players])
[print((name+":").strip(), format(round(ba, 3), '.3f')) for ba, name in sorted(bas_players, reverse=True)]
