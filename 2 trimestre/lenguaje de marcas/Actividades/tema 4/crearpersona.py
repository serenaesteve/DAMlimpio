import xml.etree.ElementTree as ET
from xml.dom import minidom
from datetime import datetime
import re

xsd_file = 'esquema.xsd'
tree = ET.parse(xsd_file)
root = tree.getroot()

ns = {'xs': 'http://www.w3.org/2001/XMLSchema'}

persona_elements = []
for elem in root.findall(".//xs:element[@name='persona']/xs:complexType/xs:sequence/xs:element", ns):
    persona_elements.append(elem.attrib['name'])

persona_data = {}
for field in persona_elements:
    while True:
        value = input(f"Ingrese {field}: ")
        if field == "fechaNacimiento":
            try:
                datetime.strptime(value, "%Y-%m-%d")
                break
            except ValueError:
                print("Error: la fecha debe estar en formato AAAA-MM-DD. Intente nuevamente.")
        elif field == "email":
            if re.match(r"[^@]+@[^@]+\.[^@]+", value):
                break
            else:
                print("Error: el email debe tener un formato valido (usuario@dominio.com).")
        else:
            break
    persona_data[field] = value

persona_xml = ET.Element('persona')
for field, value in persona_data.items():
    sub_elem = ET.SubElement(persona_xml, field)
    sub_elem.text = value

xml_str = ET.tostring(persona_xml, encoding='utf-8')
dom = minidom.parseString(xml_str)
pretty_xml = dom.toprettyxml(indent="  ")

with open('persona.xml', 'w', encoding='utf-8') as f:
    f.write(pretty_xml)

print("Archivo 'persona.xml' creado correctamente.")

