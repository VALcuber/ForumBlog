const searchInput = document.getElementById('search');
const searchResults = document.getElementById('searchResults');
let timer;

// check existence (failsafe)
if (searchInput) {

    searchInput.addEventListener('input', function() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            const query = encodeURIComponent(searchInput.value);

            fetch('/search', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'query=' + query
            })
                .then(res => res.text())
                .then(html => searchResults.innerHTML = html);
        }, 300);
    });

    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();

            const query = encodeURIComponent(searchInput.value);

            fetch('/search', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'query=' + query
            })
                .then(res => res.text())
                .then(html => searchResults.innerHTML = html);
        }
    });
}
