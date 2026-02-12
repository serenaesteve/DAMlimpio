<?php

class Perro {
    private $color;
    private $edad;

    public function __construct($color, $edad) {
        $this->color = $color;
        $this->edad = $edad;
    }

    public function getColor() {
        return $this->color;
    }

    public function getEdad() {
        return $this->edad;
    }
}

$perro1 = new Perro("marrón", 5);
$perro2 = new Perro("blanco", 3);

echo "Perro 1: Color = " . $perro1->getColor() . ", Edad = " . $perro1->getEdad() . " años<br>";
echo "Perro 2: Color = " . $perro2->getColor() . ", Edad = " . $perro2->getEdad() . " años<br>";

?>

