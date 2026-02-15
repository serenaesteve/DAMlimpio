<?php
header("Content-Type: text/css; charset=UTF-8");

echo "@media (min-width:1024px){";


echo ".d-flex{display:flex;}";
echo ".d-grid{display:grid;}";
echo ".d-block{display:block;}";
echo ".d-none{display:none;}";
echo ".d-fd-row{flex-direction:row;}";
echo ".d-fd-column{flex-direction:column;}";
echo ".d-fj-center{justify-content:center;}";
echo ".d-fa-center{align-items:center;}";


for($i=1;$i<=20;$i++){
  echo ".d-gc-$i{grid-template-columns:repeat($i,1fr);}";
}


for($i=0;$i<=1200;$i++){
  echo ".d-w-$i{width:{$i}px;}";
  echo ".d-h-$i{height:{$i}px;}";
}
for($i=0;$i<=200;$i++){
  echo ".d-p-$i{padding:{$i}px;}";
  echo ".d-m-$i{margin:{$i}px;}";
  echo ".d-g-$i{gap:{$i}px;}";
}

echo "}";

