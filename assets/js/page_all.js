document.addEventListener('click', function (e) {
    // Ищем клик по кнопке с классом js-ajax-page
    const btn = e.target.closest('.js-ajax-page');
    if (btn) {
        const page = btn.getAttribute('data-page');
        const container = document.getElementById('pagination-target');

        if (!container) {
            console.error('Error: Container #ajax-container not found in HTML!');
            return;
        }

        // Визуальный отклик (прозрачность), пока идет загрузка
        container.style.opacity = '0.4';

        // Создаем данные для отправки (FormData)
        const formData = new FormData();
        formData.append('page', page);

        // Отправляем запрос на текущий URL
        fetch(window.location.href, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                container.style.opacity = '1';
                // Скроллим к началу списка
                window.scrollTo({ top: container.offsetTop - 20, behavior: 'smooth' });
            })
            .catch(err => {
                console.error('Ошибка загрузки:', err);
                container.style.opacity = '1';
            });
    }
});