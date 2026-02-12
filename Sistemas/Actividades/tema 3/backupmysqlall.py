import os
import json
import subprocess
from datetime import datetime


config_file = "config_mysql_backup.json"

backup_dir_base = "mysql_all_databases_backups"


try:
    with open(config_file, 'r') as f:
        config = json.load(f)
        host = config['host']
        user = config['user']
        password = config['password']
        port = config.get('port', 3306)  
except FileNotFoundError:
    print(f"Error: No se encontró el archivo {config_file}.")
    exit(1)
except KeyError as e:
    print(f"Error: Falta la clave {e} en el archivo de configuración.")
    exit(1)


fecha_hora = datetime.now().strftime("%Y%m%d_%H%M%S")
backup_filename = f"backup_all_mysql_{fecha_hora}.sql.gz"


os.makedirs(backup_dir_base, exist_ok=True)

backup_path = os.path.join(backup_dir_base, backup_filename)



mysqldump_cmd = [
    "mysqldump",
    f"--host={host}",
    f"--user={user}",
    f"--port={port}",
    f"--password={password}",
    "--all-databases"
]


try:
    with open(backup_path, 'wb') as f_out:
        
        gzip_process = subprocess.Popen(
            ["gzip"],
            stdin=subprocess.PIPE,
            stdout=f_out
        )
        
        mysqldump_process = subprocess.Popen(
            mysqldump_cmd,
            stdout=gzip_process.stdin,
            stderr=subprocess.PIPE
        )
        _, stderr = mysqldump_process.communicate()
        gzip_process.stdin.close()
        gzip_process.wait()

    if mysqldump_process.returncode == 0:
        print(f"✅ Backup completado correctamente: {backup_path}")
    else:
        print(f"❌ Error en mysqldump: {stderr.decode()}")
except Exception as e:
    print(f"Error inesperado: {e}")


print("\n===== RESUMEN DEL BACKUP =====")
print(f"Archivo de backup: {backup_path}")
print(f"Fecha y hora del backup: {fecha_hora}")
print("Número de bases de datos volcadas: Todas las disponibles en el servidor MySQL")
print("===============================")

