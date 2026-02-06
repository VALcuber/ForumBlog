let currentPage = 1;
let totalPages = 1;

$(document).ready(function() {

    load(1);

    setInterval(function () {
        load(currentPage);
    }, 5000);
});
    const url = window.location.pathname;

    function load(page = 1) {
        currentPage = page; // Remember curent page

        $.ajax({
            url: window.location.pathname,
            method: 'POST',
            data: {
                list_only: true,
                page: page
            },
            dataType: 'json',
            success: function (response) {
                // Clean container before show
                $("#messages").empty();

                // Выводим комментарии из массива items
                if (response.items && response.items.length > 0) {
                    response.items.forEach(function (item) {
                        $("#messages").append(`
                            <li class="col-lg-10 col-md-12 mx-auto my-2" data-id="${item.id}">
                                <div><u>${item.name}</u></div>
                                <div><p>${item.Comment}</p></div>
                            </li>
                        `);
                    });
                }

                // Refresh global page numbers and show buttons
                totalPages = response.total_pages;
                renderPagination();
            }
        });
    }

    function renderPagination() {
        const nav = $('#pagination');
        if (nav.length === 0) return;

        // If page numbers = 1 - hide pagination
        if (totalPages <= 1) {
            nav.empty(); // Delete buttons if they exist
            return;
        }

        nav.empty();
        const group = $('<div class="btn-group" role="group"></div>');

        // Кнопка Назад
        const prevBtn = $(`<button class="btn btn-outline-primary ${currentPage <= 1 ? 'disabled' : ''}">Назад</button>`);
        prevBtn.on('click', function() {
            if (currentPage > 1) load(currentPage - 1);
        });

        const pageInfo = $(`<button class="btn btn-outline-primary disabled">Стр. ${currentPage} из ${totalPages}</button>`);

        const nextBtn = $(`<button class="btn btn-outline-primary ${currentPage >= totalPages ? 'disabled' : ''}">Вперед</button>`);
        nextBtn.on('click', function() {
            if (currentPage < totalPages) load(currentPage + 1);
        });

        group.append(prevBtn).append(pageInfo).append(nextBtn);
        nav.append(group);
    }

    $('#comments-send').on('submit', function (e) {
        e.preventDefault();
        const val = $('#comment_text').val();

        $.post(url, {
            comment: val,
            act: 'Commit'
        }, function () {
            $('#comment_text').val('');
            load();
        });
    });
