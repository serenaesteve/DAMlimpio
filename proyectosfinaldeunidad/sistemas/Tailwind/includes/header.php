<!doctype html>
<html lang="es" class="w-100pc h-100pc">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel Admin</title>

  <style><?php include("JVestilo/JVestilo.php"); ?></style>

  <style>

    * { box-sizing: border-box; }
    body { font-family: system-ui, sans-serif; }


    .card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 10px 25px rgba(0,0,0,.08);
    }


    .sidebar { min-width: 220px; }
    .navlink {
      border-radius: 10px;
      transition: .15s;
      display: block;
    }
    .navlink:hover { opacity: .92; transform: translateX(2px); }
    .navlink.active { background: rgba(255,255,255,.85); font-weight: 700; }


    .topbar {
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap: 10px;
    }


    .input {
      padding: 10px;
      border: 1px solid #d1d5db;
      border-radius: 10px;
      outline: none;
    }
    .input:focus { border-color: teal; }

    .btn {
      padding: 10px 12px;
      border-radius: 10px;
      text-decoration: none;
      display: inline-block;
      border: 1px solid rgba(0,0,0,.08);
      transition: .15s;
      cursor: pointer;
      user-select: none;
    }
    .btn:hover { opacity: .9; transform: translateY(-1px); }

    /* Tabla */
    table { border-collapse: collapse; width: 100%; }
    th, td { padding: 12px; border-bottom: 1px solid #eef2f7; }
    thead th { text-align: left; }
    tbody tr:hover { background: #f0fdfa; }
  </style>
</head>

<body class="flex w-100pc h-100pc b-lightgray">

