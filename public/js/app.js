// ===============================
// API KONFIG
// ===============================
const API_BASE_URL = 'http://localhost/Rest-API';

async function apiRequest(endpoint) {
    const url = API_BASE_URL + endpoint;
    console.log('[apiRequest] GET', url);
    const response = await fetch(url);
    if (!response.ok) {
        console.error('[apiRequest] Response not ok', response.status);
        const text = await response.text().catch(() => null);
        console.error('[apiRequest] body:', text);
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

const categorySelect = document.getElementById('categoryFilter');
if (categorySelect) {
    categorySelect.addEventListener('change', (e) => {
        loadFilms(e.target.value);
    });
} else {
    console.warn('[init] categoryFilter not found');
}

document.addEventListener('DOMContentLoaded', async () => {
    try {
        await loadCategories();
        await loadFilms();

        const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        const debouncedSearch = debounce((value) => searchFilms(value), 300);
        searchInput.addEventListener('input', (e) => {
            const value = e.target.value.trim();
            debouncedSearch(value);
        });

        // Ha Enter-t nyomnak, azonnal keresünk
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                searchFilms(e.target.value.trim());
            }
        });
    }
    } catch (err) {
        console.error('[DOMContentLoaded] init error', err);
    }
});

// ===============================
// KERESÉS
// ===============================

function debounce(fn, delay = 300) {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            try {
                fn(...args);
            } catch (err) {
                console.error('[debounce] handler error', err);
            }
        }, delay);
    };
}

async function searchFilms(keyword) {
    if (!keyword) {
        await loadFilms();
        return;
    }

    try {
        const encoded = encodeURIComponent(keyword);
        console.log('[searchFilms] keyword:', keyword, 'encoded:', encoded);
        const films = await apiRequest(`/films/search/${encoded}`);
        console.log('[searchFilms] results count:', Array.isArray(films) ? films.length : 0);
        renderFilms(films);
    } catch (error) {
        console.error('[searchFilms] Search error:', error);
    }
}