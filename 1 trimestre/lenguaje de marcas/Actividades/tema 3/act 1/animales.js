function iniciarExpedicion() {
   
    function muestraAnimal(animal) {
        console.log("Encontramos un(a) " + animal + " en el campo!");
    }
    
    let animalesEnCampo = ["zorro", "conejo", "ardilla", "búho", "ciervo"];

    for (let i = 0; i < animalesEnCampo.length; i++) {
        muestraAnimal(animalesEnCampo[i]);
    }

    function compararAnimales(animal1, animal2) {
        if (animal1 === animal2) {
            console.log(animal1 + " y " + animal2 + " son iguales.");
        } else {
            console.log(animal1 + " y " + animal2 + " son diferentes.");
        }
    }

    compararAnimales("zorro", "zorro");   
    compararAnimales("conejo", "búho");   
}


iniciarExpedicion();