import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email.mime.image import MIMEImage
from pathlib import Path

from_email = "serenaestevee@gmail.com"
to_email = "buho41112@gmail.com"
password = "mbgz lpoo gdvd gegs"


msg = MIMEMultipart("related")
msg["Subject"] = "Correo desde python"
msg["From"] = from_email
msg["To"] = to_email

alt = MIMEMultipart("alternative")
msg.attach(alt)


text_fallback = (
    "Thais Esteve · Fotografía\n"
    "Luz natural. Momentos reales.\n\n"
    "Pedir presupuesto: mailto:buho41112@gmail.com\n"
    "Ver portfolio: https://serenaesteve.github.io/thais/thais/\n"
)
alt.attach(MIMEText(text_fallback, "plain", "utf-8"))


html_path = Path("emailthais.html")
html_content = html_path.read_text(encoding="utf-8")
alt.attach(MIMEText(html_content, "html", "utf-8"))


img_path = Path("perfil.jpg")
with img_path.open("rb") as f:
    img_data = f.read()

img = MIMEImage(img_data, _subtype="jpg")  
img.add_header("Content-ID", "<foto1>")
img.add_header("Content-Disposition", "inline", filename=img_path.name)
msg.attach(img)

# Envío
with smtplib.SMTP_SSL("smtp.gmail.com", 465) as server:
    server.login(from_email, password)
    server.sendmail(from_email, [to_email], msg.as_string())








