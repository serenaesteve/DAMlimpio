<?php
header("Content-Type: text/css; charset=UTF-8");

include __DIR__."/colores.php";


foreach($colores as $color){
  $c = strtolower($color);
  echo ".b-$c{background:$c;}";
  echo ".c-$c{color:$c;}";
}


for($i=0; $i<2000; $i++){
  echo ".p-$i{padding:{$i}px;}";
  echo ".m-$i{margin:{$i}px;}";
  echo ".w-$i{width:{$i}px;}";
  echo ".w-{$i}pc{width:{$i}%;}";
  echo ".h-$i{height:{$i}px;}";
  echo ".h-{$i}pc{height:{$i}%;}";
  echo ".fs-$i{font-size:{$i}px;}";
  echo ".g-$i{gap:{$i}px;}";
  echo ".bradius-$i{border-radius:{$i}px;}";
  echo ".f-$i{flex:$i;}";
}


echo ".flex{display:flex;}";
echo ".fd-row{flex-direction:row;}";
echo ".fd-column{flex-direction:column;}";
echo ".fj-center{justify-content:center;}";
echo ".fa-center{align-items:center;}";


include __DIR__."/familiasfuentes.php";
foreach($familias as $familia){
  $ff = strtolower($familia);
  echo ".ff-$ff{font-family:$ff;}";
}


echo ".grid{display:grid;}";
for($i=1; $i<=20; $i++){
  echo ".gc-$i{grid-template-columns:repeat($i,1fr);}";
}


$alineaciones = ['left','right','center','justify'];
foreach($alineaciones as $a){
  echo ".ta-$a{text-align:$a;}";
}
echo ".td-none{text-decoration:none;}";


$tiposLineaCss = ["none","hidden","solid","dashed","dotted","double","groove","ridge","inset","outset"];
for($i=0; $i<20; $i++){
  foreach($tiposLineaCss as $tipo){
    foreach($colores as $color){
      $c = strtolower($color);
      echo ".br-$i-$tipo-$c{border:{$i}px $tipo $c;}";
    }
  }
}


echo ".shadow-1{box-shadow:0 10px 25px rgba(0,0,0,.08);}";
echo ".shadow-2{box-shadow:0 18px 45px rgba(0,0,0,.12);}";
echo ".lh-24{line-height:24px;}";
echo ".fw-wrap{flex-wrap:wrap;}";

