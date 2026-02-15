<!doctype html>
<html lang="es" class="w-100pc h-100pc p-0 m-0">
<head>
  <meta charset="UTF-8">
  <title>Clientes</title>

  <style>
    <?php include("JVestilo/JVestilo.php"); ?>

  
    td, th { padding: 10px; }

    .card { box-shadow: 0 10px 25px rgba(0,0,0,.08); }

    tbody tr:hover { background: #f0fdfa; }

    .navlink { border-radius: 8px; }
    .navlink:hover { opacity: .9; }
    .active { background: rgba(255,255,255,.85); font-weight: bold; }

    .btn {
      padding: 8px 12px;
      border-radius: 8px;
      text-decoration: none;
      display: inline-block;
    }
    .btn:hover { opacity: .9; }

    .input {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
  </style>
</head>

<body class="w-100pc h-100pc p-0 m-0 flex b-lightgray">

  <!-- Menú lateral -->
  <nav class="f-1 b-teal p-20 flex fd-column g-20">
    <div class="c-white fs-20 fw-bold">Admin</div>

    <a href="clientes" class="navlink active b-white p-10 c-teal td-none">Clientes</a>
    <a href="productos" class="navlink b-white p-10 c-teal td-none">Productos</a>
    <a href="pedidos" class="navlink b-white p-10 c-teal td-none">Pedidos</a>
    <a href="almacen" class="navlink b-white p-10 c-teal td-none">Almacén</a>
  </nav>


  <main class="f-5 p-20">


    <div class="flex fj-between fa-center m-0 p-10 b-white bradius-10 card">
      <div>
        <div class="fs-20 fw-bold">Clientes</div>
        <div class="c-gray fs-12">Listado de clientes</div>
      </div>

      <div class="flex g-10 fa-center">
        <input class="input" type="text" placeholder="Buscar...">
        <a class="btn b-teal c-white" href="#">+ Nuevo</a>
      </div>
    </div>

    <!-- Tabla -->
    <div class="m-20 p-0 b-white bradius-10 card" style="overflow:auto;">
      <table class="w-100pc">
        <thead class="b-teal c-white">
          <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <tbody>
          <tr><td>Serena</td><td>Sania Esteve</td><td>serena@example.com</td><td>612345678</td>
            <td>
              <a class="btn b-lightgray c-black" href="#">Editar</a>
              <a class="btn b-lightgray c-black" href="#">Borrar</a>
            </td>
          </tr>

          <tr><td>Hecor</td><td>Lopez</td><td>hector@example.com</td><td>623456789</td>
            <td>
              <a class="btn b-lightgray c-black" href="#">Editar</a>
              <a class="btn b-lightgray c-black" href="#">Borrar</a>
            </td>
          </tr>

          <tr><td>Thais</td><td>Esteve Sania</td><td>thais@example.com</td><td>634567890</td>
            <td>
              <a class="btn b-lightgray c-black" href="#">Editar</a>
              <a class="btn b-lightgray c-black" href="#">Borrar</a>
            </td>
          </tr>

        </tbody>
      </table>
    </div>

  </main>
</body>
</html>

