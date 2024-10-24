// Galería de libros
// Galería de libros
const books = [
    { 
        src: "../img/libro1.jpg", 
        title: "Mitos y Leyendas de mi Tierra", 
        description: "Una fascinante colección de relatos orales transmitidos de generación en generación en Colombia. Este libro explora los mitos más arraigados en la cultura del país, desde historias sobre la creación hasta leyendas de seres sobrenaturales que habitan la selva y los ríos." 
    },
    { 
        src: "../img/libro2.jpg", 
        title: "La Biblia Para Todos los Niños", 
        description: "Una adaptación de las escrituras bíblicas dirigida a los más pequeños. Este libro presenta las historias más conocidas de la Biblia de manera simple y accesible, ayudando a los niños a comprender los principios de la fe cristiana a través de ilustraciones y narraciones fáciles de seguir." 
    },
    { 
        src: "../img/libro3.jpg", 
        title: "La Odisea", 
        description: "La clásica epopeya de Homero que relata las aventuras del héroe griego Odiseo en su largo y peligroso viaje de regreso a casa después de la guerra de Troya. Un relato lleno de seres mitológicos, desafíos épicos y la lucha eterna entre el destino y la voluntad humana." 
    },
    { 
        src: "../img/libro4.jpg", 
        title: "Narraciones Extraordinarias", 
        description: "Una colección de cuentos del maestro del terror, Edgar Allan Poe. Estos relatos exploran el lado más oscuro de la mente humana, llenos de suspenso, misterio y elementos góticos, que han influenciado a generaciones de escritores y cineastas." 
    },
    { 
        src: "../img/libro5.jpg", 
        title: "El Túnel", 
        description: "Una novela psicológica de Ernesto Sabato, que narra la historia de un pintor que, obsesionado con una mujer, comete un asesinato. A través de un monólogo introspectivo, el protagonista revela la complejidad de su mente, sumergiéndonos en una reflexión sobre la soledad, el amor y la locura." 
    },
    { 
        src: "../img/libro6.jpg", 
        title: "Constitución Política de la República de Colombia 1991", 
        description: "El documento fundamental que rige los derechos y deberes de los ciudadanos de Colombia. Esta constitución es clave para entender el funcionamiento del Estado, las instituciones públicas y los derechos fundamentales en la república moderna." 
    },
    { 
        src: "../img/libro7.jpg", 
        title: "Atlas Universal y de Colombia", 
        description: "Un detallado compendio de mapas del mundo y de Colombia, que ofrece una visión geográfica clara de continentes, países y regiones. Es ideal para estudiantes y aficionados a la geografía que desean explorar el mundo a través de representaciones cartográficas." 
    },
    { 
        src: "../img/libro8.jpg", 
        title: "El Terror de Sexto B", 
        description: "Un relato juvenil que narra las aventuras y desventuras de un grupo de estudiantes de sexto grado, con toques de humor, amistad y misterios escolares. Una lectura ligera y entretenida para niños y adolescentes que disfrutan de las historias ambientadas en la escuela." 
    },
    { 
        src: "../img/libro9.jpg", 
        title: "La Culpa es de la Vaca", 
        description: "Un libro de historias cortas inspiradoras y reflexivas sobre el liderazgo, el trabajo en equipo y la superación personal. A través de relatos sencillos y con moraleja, invita al lector a reflexionar sobre sus valores y cómo estos afectan la vida diaria." 
    },
    { 
        src: "../img/libro10.png", 
        title: "El Caballero de la Armadura Oxidada", 
        description: "Un relato alegórico sobre un caballero que, tras quedar atrapado en su propia armadura, emprende un viaje interior en busca de la verdad y la libertad. Es una fábula espiritual sobre la autoexploración y el autoconocimiento, ideal para aquellos en busca de crecimiento personal." 
    },
    { 
        src: "../img/libro11.jpg", 
        title: "Cien Años de Soledad", 
        description: "La obra maestra de Gabriel García Márquez que sigue la historia de la familia Buendía a lo largo de siete generaciones en el mítico pueblo de Macondo. Una epopeya del realismo mágico que explora los temas del amor, la soledad, el poder y el destino a través de un estilo narrativo único." 
    },
    { 
        src: "../img/libro12.jpg", 
        title: "Crónica de una Muerte Anunciada", 
        description: "Un relato de Gabriel García Márquez que narra un asesinato en un pequeño pueblo colombiano. A través de la reconstrucción de los hechos, el autor explora la inevitabilidad del destino, la culpabilidad colectiva y la pasividad de una comunidad que presenció los eventos sin intervenir." 
    },
    { 
        src: "../img/libro13.jpg", 
        title: "Diccionario de Inglés - Chicago", 
        description: "Un diccionario práctico para quienes buscan mejorar su dominio del inglés. Este libro proporciona definiciones claras y concisas, además de ejemplos de uso, lo que lo convierte en una herramienta invaluable tanto para estudiantes como para profesionales." 
    },
    { 
        src: "../img/libro14.jpg", 
        title: "Diccionario de Español", 
        description: "Un recurso esencial para los hablantes de español que desean perfeccionar su conocimiento del idioma. Incluye definiciones precisas, reglas gramaticales y recomendaciones ortográficas, ideal para consultas rápidas o estudios profundos." 
    },
    { 
        src: "../img/libro15.jpg", 
        title: "Diccionario de Sinónimos y Antónimos", 
        description: "Una herramienta fundamental para quienes buscan enriquecer su vocabulario en español. Este diccionario ofrece una amplia gama de sinónimos y antónimos para cada palabra, facilitando la escritura y el habla más variada y precisa." 
    },
    { 
        src: "../img/libro16.png", 
        title: "Diccionario de Biología", 
        description: "Un diccionario especializado en términos biológicos, perfecto para estudiantes y profesionales de las ciencias de la vida. Ofrece definiciones claras y concisas de los términos clave en áreas como genética, ecología, anatomía y bioquímica." 
    },
    { 
        src: "../img/libro17.jpg", 
        title: "El Mundo de Sofía", 
        description: "Una novela filosófica que sigue a Sofía, una joven que recibe misteriosas cartas que la introducen al mundo de la filosofía. A través de su viaje de descubrimiento, el lector es guiado por un recorrido sobre las grandes ideas filosóficas desde los presocráticos hasta el presente." 
    },
    { 
        src: "../img/libro18.jpg", 
        title: "El Alquimista", 
        description: "La famosa novela de Paulo Coelho que relata la historia de Santiago, un joven pastor andaluz que emprende un viaje en busca de su leyenda personal. Una obra inspiradora sobre los sueños, la autoexploración y la importancia de seguir el corazón." 
    },
    { 
        src: "../img/libro19.jpg", 
        title: "Álgebra de Baldor", 
        description: "Uno de los textos clásicos en la enseñanza del álgebra en América Latina. Conocido por su enfoque práctico y sus explicaciones claras, este libro es utilizado por generaciones de estudiantes para aprender álgebra desde los conceptos básicos hasta los más avanzados." 
    },
    { 
        src: "../img/libro20.jpg", 
        title: "Introducción a la Biología Celular", 
        description: "Un texto esencial para estudiantes de biología que introduce los fundamentos de la biología celular. Aborda temas clave como la estructura y función de las células, las técnicas de biología molecular y los avances en la investigación biomédica." 
    },
    { 
        src: "../img/libro21.jpg", 
        title: "Ciencias y Tecnología Biología 1", 
        description: "Un libro de texto que introduce a los estudiantes a los conceptos fundamentales de la biología, con un enfoque en la ciencia y la tecnología aplicada al estudio de los seres vivos. Es un recurso didáctico y completo para la enseñanza escolar." 
    },
    { 
        src: "../img/libro22.jpg", 
        title: "Ciencias Sociales", 
        description: "Un manual educativo que cubre los principales temas de ciencias sociales, desde historia hasta geografía, pasando por educación cívica. Ideal para estudiantes de secundaria que desean comprender el mundo que los rodea a través de una perspectiva social y política." 
    },
    { 
        src: "../img/libro23.jpg", 
        title: "Fundamentos de Química Orgánica", 
        description: "Un libro académico que explica de manera clara y detallada los conceptos fundamentales de la química orgánica. Perfecto para estudiantes universitarios que están comenzando en esta área, con ejemplos prácticos y problemas resueltos." 
    },
    { 
        src: "../img/libro24.jpg", 
        title: "Anatomía Humana", 
        description: "Un compendio que abarca de manera exhaustiva la estructura del cuerpo humano, sus sistemas y su funcionamiento. Ideal para estudiantes de medicina, fisioterapia y carreras afines que necesitan una comprensión profunda de la anatomía." 
    },
    { 
        src: "../img/libro25.jpg", 
        title: "Malditas Matemáticas", 
        description: "Una novela que mezcla aventura y aprendizaje, donde la protagonista se enfrenta a un mundo donde las matemáticas gobiernan. A través de una serie de acertijos, descubre que los números no son tan aterradores como parecen." 
    },
    { 
        src: "../img/libro26.jpg", 
        title: "La Metamorfosis", 
        description: "La famosa obra de Franz Kafka en la que el protagonista, Gregor Samsa, despierta un día convertido en un insecto gigante. Una alegoría sobre la alienación, el sentido de identidad y la indiferencia de la sociedad." 
    },
    { 
        src: "../img/libro27.jpg", 
        title: "La Divina Comedia", 
        description: "El gran poema épico de Dante Alighieri, que narra su viaje imaginario a través del Infierno, el Purgatorio y el Paraíso. Es una obra fundamental de la literatura medieval que explora temas como el pecado, la redención y la justicia divina." 
    },
    { 
        src: "../img/libro28.jpg", 
        title: "Misión Olvido", 
        description: "Una novela de María Dueñas que narra la historia de Blanca Perea, quien, en busca de huir de su doloroso pasado, se embarca en un proyecto académico en California que cambiará su vida para siempre. Una historia de segundas oportunidades, amor y redención." 
    }
];

let currentPage = 1;
const booksPerPage = 10;

// Función para cargar libros en la galería
function loadBooks(page) {
    const gallery = document.getElementById('book-gallery');
    gallery.innerHTML = ''; // Limpiar la galería antes de cargar nuevos libros

    const start = (page - 1) * booksPerPage;
    const end = page * booksPerPage;
    const paginatedBooks = books.slice(start, end);

    paginatedBooks.forEach((book, index) => {
        const col = document.createElement('div');
        col.classList.add('col');
        const img = document.createElement('img');
        img.src = book.src;
        img.classList.add('img-fluid', 'rounded', 'book-img');
        img.alt = book.title;

        // Añadir evento de clic a la imagen para abrir el modal
        img.addEventListener('click', () => {
            showBookModal(book);
        });

        col.appendChild(img);
        gallery.appendChild(col);
    });
}

// Función para mostrar el modal con la información del libro
function showBookModal(book) {
    document.getElementById('bookModalImg').src = book.src;
    document.getElementById('bookModalLabel').innerText = book.title;
    document.getElementById('bookModalInfo').innerText = book.description;

    // Mostrar el modal
    const bookModal = new bootstrap.Modal(document.getElementById('bookModal'));
    bookModal.show();
}

// Función para manejar el botón "Siguiente"
document.getElementById('next-btn').addEventListener('click', () => {
    if (currentPage * booksPerPage < books.length) {
        currentPage++;
        loadBooks(currentPage);
    }
});

// Función para manejar el botón "Anterior"
document.getElementById('previous-btn').addEventListener('click', () => {
    if (currentPage > 1) {
        currentPage--;
        loadBooks(currentPage);
    }
});

// Cargar los libros iniciales en la primera página
loadBooks(currentPage);

// Simulación de la reserva (puede conectarse a la base de datos)
document.getElementById('reserveBtn').addEventListener('click', () => {
    alert('Libro reservado con éxito.');
});

// Funcionalidad de búsqueda
const searchIcon = document.querySelector('.fa-search');
const searchContainer = document.getElementById('search-container');
const searchInput = document.getElementById('search-input');
const noResults = document.getElementById('no-results');  // Elemento de alerta

// Mostrar/ocultar el campo de búsqueda
searchIcon.addEventListener('click', () => {
    searchContainer.classList.toggle('d-none'); // Alternar visibilidad
    searchInput.focus(); // Colocar el foco en el campo de búsqueda
});

// Filtrar libros mientras se escribe
searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase();
    const books = document.querySelectorAll('#book-gallery .col');
    let found = false;  // Bandera para saber si se encuentra algún resultado

    books.forEach(book => {
        const title = book.querySelector('img').alt.toLowerCase();
        if (title.includes(query)) {
            book.style.display = 'block'; // Mostrar libro si coincide
            found = true;
        } else {
            book.style.display = 'none';  // Ocultar libro si no coincide
        }
    });

    // Mostrar alerta si no se encontraron resultados
    if (found) {
        noResults.classList.add('d-none'); // Ocultar la alerta si hay coincidencias
    } else {
        noResults.classList.remove('d-none'); // Mostrar la alerta si no hay coincidencias
    }
});


