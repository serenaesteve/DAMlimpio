import json
import os
import stat
import time
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


def format_bytes(n: int) -> str:
    x = float(n)
    for unit in ("B", "KB", "MB", "GB", "TB"):
        if x < 1024 or unit == "TB":
            return f"{x:.1f} {unit}"
        x /= 1024
    return f"{x:.1f} TB"


def format_time(seconds: float) -> str:
    seconds = int(seconds)
    h, rem = divmod(seconds, 3600)
    m, s = divmod(rem, 60)
    if h > 0:
        return f"{h}h {m:02d}m {s:02d}s"
    if m > 0:
        return f"{m}m {s:02d}s"
    return f"{s}s"


class GlobalProgress:
    def __init__(self, total_bytes: int):
        self.total_bytes = total_bytes
        self.transferred = 0
        self.start = time.time()

    def add(self, delta: int):
        self.transferred += delta
        self.print()

    def print(self):
        elapsed = time.time() - self.start
        speed = self.transferred / elapsed if elapsed > 0 else 0.0
        remaining = (self.total_bytes - self.transferred) / speed if speed > 0 else 0.0
        percent = (self.transferred / self.total_bytes) * 100.0 if self.total_bytes > 0 else 0.0

        bar_len = 30
        filled = int(bar_len * percent / 100.0)
        bar = "█" * filled + "-" * (bar_len - filled)

        msg = (
            f"\r[{bar}] {percent:6.2f}% "
            f"| {format_bytes(self.transferred)}/{format_bytes(self.total_bytes)} "
            f"| elapsed {format_time(elapsed)} "
            f"| ETA {format_time(remaining)}"
        )
        print(msg, end="", flush=True)

        if self.transferred >= self.total_bytes:
            print()


def collect_remote_files(sftp: paramiko.SFTPClient, root_path: str):
    """
    Devuelve lista de (ruta_remota, tamaño) de todos los archivos bajo root_path (recursivo).
    """
    files = []

    def _walk(path: str):
        try:
            entries = sftp.listdir_attr(path)
        except IOError as e:
            print(f"\n[ERROR] No se pudo listar {path}: {e}")
            return

        for entry in entries:
            name = entry.filename
            if name in (".", ".."):
                continue

            remote_path = posixpath.join(path, name)

            if stat.S_ISDIR(entry.st_mode):
                _walk(remote_path)
            else:
                files.append((remote_path, entry.st_size))

    _walk(root_path)
    return files


def download_all_with_progress(sftp: toggle, files, remote_root: str, local_root: str):
    total_bytes = sum(size for _, size in files)
    progress = GlobalProgress(total_bytes)

    remote_root_clean = remote_root.rstrip("/")

    for remote_path, _size in files:
        # Parte relativa (lo que va dentro de la carpeta local)
        rel = remote_path[len(remote_root_clean) + 1:]
        local_path = os.path.join(local_root, rel)

        os.makedirs(os.path.dirname(local_path), exist_ok=True)

        last = {"v": 0}

        def callback(transferred, total):
            delta = transferred - last["v"]
            last["v"] = transferred
            progress.add(delta)

        sftp.get(remote_path, local_path, callback=callback)


def main():
    cfg = load_config("config.json")

    remote_root = cfg.get("root_path")
    if not remote_root:
        print("ERROR: En config.json falta 'root_path' (ej: /var/www/html/capitol)")
        return

    local_root = os.path.basename(remote_root.rstrip("/"))
    if local_root == "":
        local_root = "descarga"

    os.makedirs(local_root, exist_ok=True)

    ssh = None
    sftp = None
    try:
        ssh = create_ssh_client(cfg)
        sftp = ssh.open_sftp()

        print(f"Buscando archivos en: {remote_root} ...")
        files = collect_remote_files(sftp, remote_root)
        print(f"Archivos encontrados: {len(files)}")
        print(f"Destino local: ./{local_root}\n")

        if len(files) == 0:
            print("No hay archivos para descargar.")
            return

        print("Descargando con progreso:")
        download_all_with_progress(sftp, files, remote_root, local_root)
        print("✅ Descarga terminada.")

    finally:
        if sftp:
            sftp.close()
        if ssh:
            ssh.close()


if __name__ == "__main__":
    main()


