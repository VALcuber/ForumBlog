document.addEventListener('DOMContentLoaded', () => {
    console.log("JS loaded");

    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('liveSearchResults');
    const searchForm = searchInput?.closest('form');

    let timer = null;

    if (!searchInput) {
        console.error("searchInput not found");
        return;
    }

    if (!searchResults) {
        console.error("liveSearchResults not found");
        return;
    }

    // Живой поиск при вводе
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.trim();

        if (query === '') {
            searchResults.classList.add('hidden');
            searchResults.innerHTML = '';
            return;
        }

        clearTimeout(timer);
        timer = setTimeout(() => {

            fetch('/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'query=' + encodeURIComponent(query)
            })
                .then(r => r.text())
                .then(html => {
                    searchResults.innerHTML = html;
                    searchResults.classList.remove('hidden');
                })
                .catch(err => {
                    console.error(err);
                    searchResults.classList.add('hidden');
                });

        }, 300);
    });

    // Закрытие при клике вне поиска
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });

    // Повторное открытие при фокусе, если есть текст
    searchInput.addEventListener('focus', () => {
        if (searchInput.value.trim() !== '' && searchResults.innerHTML !== '') {
            searchResults.classList.remove('hidden');
        }
    });

    // При submit формы - скрываем живой поиск и идём на страницу результатов
    if (searchForm) {
        searchForm.addEventListener('submit', () => {
            searchResults.classList.add('hidden');
        });
    }
});