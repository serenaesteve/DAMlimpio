from dataclasses import dataclass
from typing import Optional, List


@dataclass
class Animal:
    nombre: Optional[str]
    sexo: Optional[str]
    edad: Optional[str]
    tamano: Optional[str]
    fecha_publicacion: Optional[str]
    url_ficha: Optional[str]
    descripcion: Optional[str] = None
    imagenes: Optional[List[str]] = None

