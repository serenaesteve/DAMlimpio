<?php
include "colores.php";
foreach($colores as $c){
  echo ".b-".strtolower($c)."{background:$c;}";
  echo ".c-".strtolower($c)."{color:$c;}";
}

for($i=0;$i<=300;$i++){
  echo ".p-$i{padding:${i}px;}";
  echo ".m-$i{margin:${i}px;}";
  echo ".w-$i{width:${i}px;}";
  echo ".h-$i{height:${i}px;}";
  echo ".fs-$i{font-size:${i}px;}";
  echo ".bradius-$i{border-radius:${i}px;}";
  echo ".f-$i{flex:$i;}";
}

echo ".flex{display:flex;}";
echo ".fd-column{flex-direction:column;}";
echo ".fj-center{justify-content:center;}";
echo ".fa-center{align-items:center;}";

include "familiasfuentes.php";
foreach($familias as $f){
  echo ".ff-$f{font-family:$f;}";
}

echo ".td-none{text-decoration:none;}";

