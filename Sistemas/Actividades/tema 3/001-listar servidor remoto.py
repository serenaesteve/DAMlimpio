import json
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


def walk_remote(sftp, root_path: str, prefix: str = "", depth: int = 0, max_depth=None):
    if max_depth is not None and depth > max_depth:
        return

    try:
        entries = sftp.listdir_attr(root_path)
    except IOError as e:
        print(f"{prefix}[ERROR al abrir {root_path}: {e}]")
        return

    entries_sorted = sorted(entries, key=lambda e: (not stat.S_ISDIR(e.st_mode), e.filename.lower()))
    total = len(entries_sorted)

    for i, entry in enumerate(entries_sorted):
        name = entry.filename
        remote_path = posixpath.join(root_path, name)

        is_dir = stat.S_ISDIR(entry.st_mode)
        is_last = (i == total - 1)

        connector = "└── " if is_last else "├── "
        print(f"{prefix}{connector}{name}{'/' if is_dir else ''}")

        if is_dir:
            child_prefix = prefix + ("    " if is_last else "│   ")
            walk_remote(sftp, remote_path, prefix=child_prefix, depth=depth + 1, max_depth=max_depth)


def main():
    cfg = load_config("config.json")
    root_path = cfg.get("root_path", ".")
    max_depth = cfg.get("max_depth", None)

    ssh = None
    sftp = None
    try:
        ssh = create_ssh_client(cfg)
        sftp = ssh.open_sftp()

        print(root_path.rstrip("/") + "/")
        walk_remote(sftp, root_path, prefix="", depth=0, max_depth=max_depth)

    finally:
        if sftp:
            sftp.close()
        if ssh:
            ssh.close()


if __name__ == "__main__":
    main()

