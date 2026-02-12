class Codificador:
    def codifica(self, cadena, modo="codificar"):
        resultado = ""
        for letra in cadena:
            if modo == "codificar":
                nuevo_ascii = ord(letra) + 5
            else:
                nuevo_ascii = ord(letra) - 5
            resultado += chr(nuevo_ascii)
        return resultado

cod = Codificador()


codificado = cod.codifica("Serena Sania", "codificar")
print(codificado)

decodificado = cod.codifica(codificado, "decodificar")
print(decodificado)