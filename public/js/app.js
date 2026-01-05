// ===============================
// API KONFIG
// ===============================
const API_BASE_URL = 'http://localhost:84/Rest-API';

async function apiRequest(endpoint) {
    const response = await fetch(API_BASE_URL + endpoint);
    if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.json();
}

// ===============================
// FILM KÁRTYA
// ===============================

function createFilmCard(film) {
    const card = document.createElement('div');
    card.classList.add('film-card');

    card.innerHTML = `
        <div class="film-poster">
        <img src="${film.poster_url}" alt="${film.title}">
        </div>

        <div class="film-title">${film.title}</div>
        <div class="film-meta">Kategória: ${film.category_name}</div>
        <div class="film-meta">Rendező: ${film.director_name}</div>
    `;

    return card;
}


// ===============================
// FILMEK RENDERELÉSE
// ===============================

function renderFilms(films) {
    const grid = document.getElementById('filmsGrid');
    grid.innerHTML = '';

    if (!films || films.length === 0) {
        grid.innerHTML = '<p>Nincs találat.</p>';
        return;
    }

    films.forEach(film => {
        grid.appendChild(createFilmCard(film));
    });
}

// ===============================
// FILMEK BETÖLTÉSE
// ===============================

async function loadFilms(categoryId = '') {
    let endpoint = '/films';

    if (categoryId) {
        endpoint += `?category_id=${categoryId}`;
    }

    try {
        const films = await apiRequest(endpoint);
        console.log('Films JSON:', films);
        renderFilms(films);
    } catch (error) {
        console.error('Film fetch error:', error);
    }
}

// ===============================
// KATEGÓRIÁK
// ===============================

async function loadCategories() {
    try {
        const categories = await apiRequest('/categories');
        const select = document.getElementById('categoryFilter');

        categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.id;
            option.textContent = cat.name;
            select.appendChild(option);
        });
    } catch (error) {
        console.error('Category fetch error:', error);
    }
}

// ===============================
// ESEMÉNYEK
// ===============================

document.getElementById('categoryFilter').addEventListener('change', (e) => {
    loadFilms(e.target.value);
});

document.addEventListener('DOMContentLoaded', async () => {
    await loadCategories();
    await loadFilms();
});
