//SELECCION MULTIPLE

//CURSOS

function showOptions(e) {
    
// Obtiene el elemento con el id "divOptions".
    let divOptions = document.getElementById("divOptions");

    // Si el estilo de display del elemento es "none" o está vacío,
    // cambia el estilo a "inline-block" para mostrar las opciones.
    // De lo contrario, oculta las opciones estableciendo el estilo en "none".

    if (divOptions.style.display == "none" || divOptions.style.display == "") {
        divOptions.style.display = "inline-block";
    } else {
        divOptions.style.display = "none";
    }
}



function clickMe(e) {
    console.log('click me');
    e.stopPropagation();
}

    // Si el elemento clicado está dentro del contenedor "divOptions", muestra las opciones.
    // De lo contrario, oculta las opciones.

function hideOptions(e) {
    let divOptions = document.getElementById("divOptions");

    if (divOptions.contains(e.target)) {
        divOptions.style.display = "inline-block";
    } else {
        divOptions.style.display = "none";
    }
}

// Esta parte del código se ejecuta cuando se ha cargado el DOM.

document.addEventListener("DOMContentLoaded", function () {

     // Obtiene todos los elementos de entrada de tipo checkbox dentro del contenedor "divOptions".
    let checkbox = document.querySelectorAll("#divOptions input");

    // Obtiene el elemento de entrada de tipo checkbox con el id "inputCheckbox".
    let inputCheckbox = document.getElementById("inputCheckbox");

    for (let i = 0; i < checkbox.length; i++) {
        checkbox[i].addEventListener("change", (e) => {
            if (e.target.checked == true) {
                // Si el checkbox se ha marcado, agrega su valor al campo "inputCheckbox".
                // Si el campo está vacío, simplemente agrega el valor; de lo contrario, agrega con coma.
                if (inputCheckbox.value == "") {
                    inputCheckbox.value = checkbox[i].value;
                } else {
                    inputCheckbox.value += `,${checkbox[i].value}`;
                }
            } else {// Si el checkbox se desmarca, elimina su valor del campo "inputCheckbox".
                let values = inputCheckbox.value.split(",");
                for (let r = 0; r < values.length; r++) {
                    if (values[r] == e.target.value) {
                        values.splice(r, 1);
                    }
                }
                inputCheckbox.value = values;
            }
        });
    }
});

  //FIN CURSOS

  // MATERIAS


function showOptions2(e) {
    let divOptions2 = document.getElementById("divOptions2");
    if (divOptions2.style.display == "none" || divOptions2.style.display == "") {
        divOptions2.style.display = "inline-block";
    } else {
        divOptions2.style.display = "none";
    }
}
function clickMe2(e) {
    console.log('click me');
    e.stopPropagation();
}
function hideOptions2(e) {
    let divOptions2 = document.getElementById("divOptions2");

    if (divOptions2.contains(e.target)) {
        divOptions2.style.display = "inline-block";
    } else {
        divOptions2.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    let checkbox2 = document.querySelectorAll("#divOptions2 input");
    let inputCheckbox2 = document.getElementById("inputCheckbox2");

    for (let i = 0; i < checkbox2.length; i++) {
        checkbox2[i].addEventListener("change", (e) => {
            if (e.target.checked == true) {
                if (inputCheckbox2.value == "") {
                    inputCheckbox2.value = checkbox2[i].value;
                } else {
                    inputCheckbox2.value += `,${checkbox2[i].value}`;
                }
            } else {
                let values = inputCheckbox2.value.split(",");
                for (let r = 0; r < values.length; r++) {
                    if (values[r] == e.target.value) {
                        values.splice(r, 1);
                    }
                }
                inputCheckbox2.value = values;
            }
        });
    }
});

//FIN MATERIAS

//FIN SELECCION MULTIPLE

//MENSAJE DE BIENVENIDA

document.addEventListener("DOMContentLoaded", function () {
    const Bienvenida = document.getElementById("Bienvenida");
    Bienvenida.style.display = "block"; // Mostrar el bloque

    // Agregar clase para animación
    Bienvenida.classList.add("show-animation");

    // Ocultar la caja después de 5 segundos (5000 milisegundos)
    setTimeout(function() {
        Bienvenida.style.display = "none";
    }, 8000);
});


// Mostrar las materias y cursos anteriores

document.addEventListener("DOMContentLoaded", function () {
    const materiasAnteriores = document.getElementById("materiasAnteriores");
    materiasAnteriores.style.display = "block"; // Mostrar el bloque

    // Agregar clase para animación
    materiasAnteriores.classList.add("show-animation");
});
















