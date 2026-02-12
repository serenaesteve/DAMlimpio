import json
import os
import stat
import posixpath
import paramiko


def load_config(path: str) -> dict:
    with open(path, "r", encoding="utf-8") as f:
        return json.load(f)


def create_ssh_client(cfg: dict) -> paramiko.SSHClient:
    client = paramiko.SSHClient()
    client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

    host = cfg["host"]
    port = cfg.get("port", 22)
    username = cfg["username"]
    password = cfg["password"]

    client.connect(hostname=host, port=port, username=username, password=password)
    return client


def ensure_local_dir(path: str) -> None:
    os.makedirs(path, exist_ok=True)


def download_dir(sftp, remote_dir: str, local_dir: str) -> None:
    ensure_local_dir(local_dir)

    try:
        entries = sftp.listdir_attr(remote_dir)
    except IOError as e:
        print(f"[ERROR] No se pudo listar {remote_dir}: {e}")
        return

    for entry in entries:
        remote_path = posixpath.join(remote_dir, entry.filename)
        local_path = os.path.join(local_dir, entry.filename)

        if stat.S_ISDIR(entry.st_mode):
            download_dir(sftp, remote_path, local_path)
        else:
            print(f"Descargando: {remote_path} -> {local_path}")
            sftp.get(remote_path, local_path)


def main():
    cfg = load_config("config.json")

    remote_path = cfg.get("path")
    if not remote_path:
        print("ERROR: En config.json falta 'path' (ej: /var/www/html)")
        return

    local_folder = os.path.basename(remote_path.rstrip("/"))
    if local_folder == "":
        local_folder = "descarga"

    ssh = None
    sftp = None
    try:
        ssh = create_ssh_client(cfg)
        sftp = ssh.open_sftp()

        print(f"Descargando TODO desde: {remote_path}")
        print(f"Destino local: ./{local_folder}\n")

        download_dir(sftp, remote_path, local_folder)

        print("\n✅ Descarga completada.")

    finally:
        if sftp:
            sftp.close()
        if ssh:
            ssh.close()


if __name__ == "__main__":
    main()


