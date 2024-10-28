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
    let input = document.getElementById('searchInput');
    let filter = input.value.toLowerCase();
    let table = document.getElementById('booksTable');
    let rows = table.getElementsByTagName('tr');
    let noResultsMessage = document.getElementById('noResultsMessage');
    let hasResults = false;

    for (let i = 1; i < rows.length; i++) {
        let cells = rows[i].getElementsByTagName('td');
        let bookName = cells[0].textContent.toLowerCase();
        if (bookName.includes(filter)) {
            rows[i].style.display = '';
            hasResults = true;
        } else {
            rows[i].style.display = 'none';
        }
    }

    // Mostrar mensaje de "No hay resultados" si no hay coincidencias
    if (!hasResults) {
        noResultsMessage.classList.remove('d-none');
    } else {
        noResultsMessage.classList.add('d-none');
    }
}