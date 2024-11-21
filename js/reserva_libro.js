function openReserveModal(codLibro, nombreLibro) {
    document.getElementById('cod_libro').value = codLibro;
    document.getElementById('nombre_libro').value = nombreLibro;

    let reserveModal = new bootstrap.Modal(document.getElementById('reserveModal'));
    reserveModal.show();
}

function toggleSearch() {
    let searchInput = document.getElementById('searchInput');
    searchInput.classList.toggle('d-none');
    searchInput.focus();
}

function searchBook() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const books = document.querySelectorAll('.col'); // Busca en todas las columnas de libros
    const noResultsMessage = document.getElementById('noResultsMessage');
    let hasResults = false;

    books.forEach(book => {
        const title = book.querySelector('img').alt.toLowerCase();
        if (title.includes(filter)) {
            book.style.display = 'block'; // Asegúrate de mostrarlo si coincide
            hasResults = true;
        } else {
            book.style.display = 'none'; // Oculta si no coincide
        }
    });

    // Mostrar mensaje de "No hay resultados" si no hay coincidencias
    if (!hasResults) {
        noResultsMessage.classList.remove('d-none');
    } else {
        noResultsMessage.classList.add('d-none');
    }
}
