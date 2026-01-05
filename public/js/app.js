// Backend URL – állítsd a saját backend path-ra
const API_BASE_URL = '';
// Egyszerű fetch wrapper
async function apiRequest(endpoint) {
    const res = await fetch(API_BASE_URL + endpoint);
    if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
    return res.json();
}

// Render filmek listába
function renderFilms(films) {
    const list = document.getElementById('filmList');
    list.innerHTML = '';
    films.forEach(film => {
        const li = document.createElement('li');
        li.textContent = `${film.title} (${film.category_name}) - ${film.director_name}`;
        list.appendChild(li);
    });
}

// Lekéri a filmeket a backendtől
async function loadFilms(categoryId = '') {
    let endpoint = '/films';
    if (categoryId) {
        endpoint += `?category_id=${categoryId}`;
    }

    try {
        const films = await apiRequest(endpoint);
        console.log('Backend JSON response:', films); // konzolban is látszik
        renderFilms(films);
    } catch (err) {
        console.error('Fetch error:', err);
    }
}

// Lekéri a kategóriákat és feltölti a legördülőt
async function loadCategories() {
    try {
        const categories = await apiRequest('/categories');
        const select = document.getElementById('categoryFilter');

        categories.forEach(cat => {
            const option = document.createElement('option');
            option.value = cat.id;    // vagy cat.name, ha név alapján filterezel
            option.textContent = cat.name;
            select.appendChild(option);
        });
    } catch (err) {
        console.error('Category fetch error:', err);
    }
}

// Szűrő esemény
document.getElementById('categoryFilter').addEventListener('change', (e) => {
    const selected = e.target.value;
    loadFilms(selected);
});

// Fő betöltés
document.addEventListener('DOMContentLoaded', async () => {
    await loadCategories();   // először a kategóriák
    await loadFilms();        // majd minden film
});
