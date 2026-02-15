<?php $active = "clientes"; ?>
<?php include("includes/header.php"); ?>
<?php include("includes/menu.php"); ?>

<main class="f-5 p-20 flex fd-column g-20">

  <!-- Cabecera -->
  <div class="card p-20 flex fj-between fa-center">
    <div>
      <h2 class="m-0">Clientes</h2>
      <div class="fs-12 c-gray">Listado de clientes registrados</div>
    </div>

    <a href="#" class="btn b-teal c-white">+ Nuevo cliente</a>
  </div>

  <!-- Tabla -->
  <div class="card p-10" style="overflow:auto;">
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
        <tr>
          <td>Serena</td>
          <td>Sania Esteve</td>
          <td>serena@example.com</td>
          <td>612345678</td>
          <td class="flex g-10">
            <a class="btn b-lightgray c-black fs-12">Editar</a>
            <a class="btn b-lightgray c-black fs-12">Borrar</a>
          </td>
        </tr>
        <tr>
          <td>Hector</td>
          <td>Lopez</td>
          <td>hector@example.com</td>
          <td>623456789</td>
          <td class="flex g-10">
            <a class="btn b-lightgray c-black fs-12">Editar</a>
            <a class="btn b-lightgray c-black fs-12">Borrar</a>
          </td>
        </tr>
        <tr>
          <td>Thais</td>
          <td>Esteve Sania</td>
          <td>thais@example.com</td>
          <td>634567890</td>
          <td class="flex g-10">
            <a class="btn b-lightgray c-black fs-12">Editar</a>
            <a class="btn b-lightgray c-black fs-12">Borrar</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

</main>

<?php include("includes/footer.php"); ?>

