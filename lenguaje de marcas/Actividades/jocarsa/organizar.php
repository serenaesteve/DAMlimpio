<?php
$archivoCategorias = file_get_contents('db/categorias.json');
$categorias = json_decode($archivoCategorias, true);

$archivoProductos = file_get_contents('db/productos.json');
$productos = json_decode($archivoProductos, true);

$archivoPie = file_get_contents('db/piedepagina.json');
$pie = json_decode($archivoPie, true);
?>
<!doctype html>
<html lang="es">
  <head>
    <title>jocarsa</title>
    <meta charset="utf-8">

    <style>
      
      @font-face {font-family: Ubuntu;src: url(estilo/Ubuntu-R.ttf);}
      @font-face {font-family: UbuntuB;src: url(estilo/Ubuntu-B.ttf);}

      
      html,body{
        padding:0px;
        margin:0px;
        font-family:Ubuntu,sans-serif;
        width:100%;
        height:100%;
        background:#f3f3f7;
      }

     
      header{
        width:100%;
        display:flex;
        justify-content:center;
        align-items:center;
        box-shadow:0px 2px 4px rgba(0,0,0,0.3);
        gap:20px;
        padding:10px;
        background:white;
      }
      header img{width:30px;}
      header a{text-decoration:none;color:indigo;font-size:11px;}

      
      main{
        width:100%;
        display:grid;
        grid-template-columns:1fr;
        gap:10px;
        padding:10px;
        box-sizing:border-box;
      }

      main article{
        width:100%;
        height:320px;
        display:flex;
        justify-content:center;
        align-items:center;
        background:white;
        flex-direction:column;
        gap:10px;
        border:1px solid #d1d5db;
        border-radius:10px;
        box-shadow:0 2px 4px rgba(0,0,0,0.08);
      }
      main article h3,main article h4{padding:0px;margin:0px;text-align:center;}
      main article h3{font-size:26px;font-family:UbuntuB;}
      main article h4{font-size:14px;color:#374151;max-width:260px;}
      main article a{
        background:indigo;
        text-decoration:none;
        color:white;
        padding:10px 20px;
        border-radius:50px;
        font-size:12px;
      }

      
      main article:nth-child(-n+3){
        grid-column:1 / -1;
      }

     
      @media (min-width:600px){
        main{ grid-template-columns:1fr 1fr; }
        main article:nth-child(-n+3){ grid-column:1 / -1; }
      }

      
      footer{
        margin-top:10px;
        background:#111827;
        color:#e5e7eb;
        padding:20px;
      }
      footer .cols{
        display:grid;
        grid-template-columns:1fr;
        gap:20px;
        max-width:900px;
        margin:0 auto;
      }
      footer h5{
        margin:0 0 10px 0;
        font-family:UbuntuB;
        font-size:14px;
        color:#ffffff;
      }
      footer ul{ list-style:none; padding:0; margin:0; }
      footer li{ padding:4px 0; font-size:12px; }
      footer a{ color:#c7d2fe; text-decoration:none; }
      footer a:hover{ text-decoration:underline; }

      @media (min-width:600px){
        footer .cols{ grid-template-columns:1fr 1fr; }
      }
    </style>
  </head>

  <body>
    <header>
      <a href="?"><img src="https://static.jocarsa.com/logos/jocarsa%20%7C%20Indigo.svg" alt="jocarsa"></a>
      <a href="?">Inicio</a>
    </header>

    <main>
      <?php
     
      for($i = 0; $i < count($productos); $i++){
        $nombre = htmlspecialchars($productos[$i]['nombre']);
        $slogan = htmlspecialchars($productos[$i]['slogan']);
      ?>
        <article>
          <h3><?= $nombre ?></h3>
          <h4><?= $slogan ?></h4>
          <a href="producto.php">Saber más</a>
        </article>
      <?php } ?>
    </main>

    <footer>
      <div class="cols">

        
        <div>
          <h5>Categorías</h5>
          <ul>
            <?php for($i = 0; $i < count($categorias); $i++){ ?>
              <li><?= htmlspecialchars($categorias[$i]) ?></li>
            <?php } ?>
          </ul>
        </div>

        
        <div>
          <h5>Enlaces</h5>
          <ul>
            <?php
            
            for($i = 0; $i < count($pie['enlaces']); $i++){
              $nombre = htmlspecialchars($pie['enlaces'][$i]['nombre']);
              $enlace = htmlspecialchars($pie['enlaces'][$i]['enlace']);
            ?>
              <li><a href="<?= $enlace ?>" target="_blank"><?= $nombre ?></a></li>
            <?php } ?>
          </ul>
        </div>

      </div>
    </footer>
  </body>
</html>

