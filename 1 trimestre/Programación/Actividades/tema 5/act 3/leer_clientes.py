archivo_binario = open("clientes.txt", "rb")


primer_linea = archivo_binario.readline()


print(primer_linea.decode("utf-8"))


archivo_binario.close()
