def creaDivision(dividendo, divisor):
    
    if type(dividendo) == str:
        if dividendo.replace('.', '', 1).isdigit():
            dividendo = float(dividendo)
        else:
            return 0

    
    if type(divisor) == str:
        if divisor.replace('.', '', 1).isdigit():
            divisor = float(divisor)
        else:
            return 0

    
    if divisor == 0:
        return "infinidad"

    return dividendo / divisor


print(creaDivision(10, 2))         
print(creaDivision(10, 0))         
print(creaDivision("20", "4"))    
print(creaDivision("hola", 5))    
print(creaDivision(100, "0"))      
print(creaDivision("7.5", "2.5"))