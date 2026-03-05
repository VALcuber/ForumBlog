document.addEventListener('click', function (e) {
    // Search click on button with class js-ajax-page
    const btn = e.target.closest('.js-ajax-page');
    if (btn) {
        const page = btn.getAttribute('data-page');
        const container = document.getElementById('pagination-target');

        if (!container) {
            console.error('Error: Container #ajax-container not found in HTML!');
            return;
        }

        container.style.opacity = '0.4';

        // Create data for send (FormData)
        const formData = new FormData();
        formData.append('page', page);

        // Send request for current URL
        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';
                // Scroll to the start
                window.scrollTo({ top: container.offsetTop - 20, behavior: 'smooth' });
            })
            .catch(err => {
                console.error('Load error:', err);
                container.style.opacity = '1';
            });
    }
});