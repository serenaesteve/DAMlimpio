tipo_adaptador = "Cat6"

velocidad_maxima = 0

if tipo_adaptador == "Cat5":
    velocidad_maxima = 100
elif tipo_adaptador == "Cat5e":
    velocidad_maxima= 1000
elif tipo_adaptador == "Cat6":
    velocidad_maxima= 1000
elif tipo_adaptador == "Cat7":
    velocidad_maxima = 10000
    
print(velocidad_maxima)
