import json
import smtplib
import ssl
from email.message import EmailMessage


def load_config(path):
    with open(path, "r", encoding="utf-8") as f:
        return json.load(f)


config = load_config("config2.json")

smtp_host = config["smtp"]["host"]
smtp_port = config["smtp"]["port"]
smtp_user = config["smtp"]["user"]
smtp_password = config["smtp"]["password"]

email_from = config["email"]["from"]
email_to = config["email"]["to"]
email_subject = config["email"]["subject"]
html_template_path = config["email"]["html_template"]


with open(html_template_path, "r", encoding="utf-8") as f:
    html_content = f.read()


message = EmailMessage()
message.set_content(html_content, subtype="html")
message["From"] = email_from
message["To"] = ", ".join(email_to)
message["Subject"] = email_subject


context = ssl.create_default_context()
with smtplib.SMTP(smtp_host, smtp_port) as server:
    server.starttls(context=context)
    server.login(smtp_user, smtp_password)
    server.sendmail(email_from, email_to, message.as_string())

print("Correo enviado correctamente ✅")

