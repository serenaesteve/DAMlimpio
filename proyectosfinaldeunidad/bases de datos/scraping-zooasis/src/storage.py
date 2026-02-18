import json
import pandas as pd
from dataclasses import asdict
from pathlib import Path

from src.config import OUTPUT_DIR


def save(animals):
    Path(OUTPUT_DIR).mkdir(exist_ok=True)

    data = [asdict(a) for a in animals]
    df = pd.DataFrame(data)

    df.to_csv(f"{OUTPUT_DIR}/zooasis_perros.csv", index=False, encoding="utf-8")

    with open(f"{OUTPUT_DIR}/zooasis_perros.json", "w", encoding="utf-8") as f:
        json.dump(data, f, ensure_ascii=False, indent=2)

