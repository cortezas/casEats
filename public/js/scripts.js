document.addEventListener('DOMContentLoaded', function() {
    const filterIcons = document.querySelectorAll('.filter-icon');
    const joinItems = document.querySelectorAll('.join-item');
    const comidaItems = document.querySelectorAll('.comida-item');

    // Mostrar las primeras 12 comidas al cargar la página
    comidaItems.forEach((comida, index) => {
        if (index < 12) {
            comida.style.display = 'block';
        }
    });

    joinItems.forEach(item => {
        item.addEventListener('click', () => {
            const index = parseInt(item.getAttribute('data-index'));

            // Ocultar todas las comidas
            comidaItems.forEach(comida => {
                comida.style.display = 'none';
            });

            // Mostrar las comidas correspondientes al índice
            const startIndex = (index - 1) * 12;
            const endIndex = startIndex + 12;
            for (let i = startIndex; i < endIndex && i < comidaItems.length; i++) {
                comidaItems[i].style.display = 'block';
            }

            // Quitar la clase 'active' de todos los botones y añadirla al botón clickeado
            joinItems.forEach(joinItem => {
                joinItem.classList.remove('active');
            });
            item.classList.add('active');
        });
    });


});
// Selecciona el checkbox
const toggleDarkmode = document.getElementById('toggle-darkmode');

// Función para cambiar la imagen del logo
function cambiarLogo() {
    const logoImg = document.getElementById('logo-img');
    if (toggleDarkmode.checked) {
        logoImg.src = "logo-darkmode.png";
        logoImg.alt = "Logo Oscuro";
    } else {
        logoImg.src = "logo-lightmode.png";
        logoImg.alt = "Logo Claro";
    }
}

// Agrega un event listener al checkbox para detectar cambios en su estado
toggleDarkmode.addEventListener('change', cambiarLogo);

// Llama a la función para asegurarte de que la imagen del logo se actualice correctamente cuando se carga la página
cambiarLogo();

