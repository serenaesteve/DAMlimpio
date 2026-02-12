import json

with open("persona.json", "r", encoding="utf-8") as f:
    data = json.load(f)

print(data)

