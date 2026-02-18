import time
import requests

from src.config import HEADERS, REQUEST_TIMEOUT, SLEEP_SECONDS
from src.exceptions import AntiBotDetected


def fetch(session: requests.Session, url: str) -> str:
    response = session.get(url, headers=HEADERS, timeout=REQUEST_TIMEOUT)
    response.raise_for_status()

    html = response.text.lower()
    if "request is being verified" in html:
        raise AntiBotDetected("Protección anti-bot detectada")

    time.sleep(SLEEP_SECONDS)
    return response.text

