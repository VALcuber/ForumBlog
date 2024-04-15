$(document).ready(function(){

    // Получение элементов DOM и извлечение значений data-id
    var liElements = Array.from(document.querySelectorAll('#messages li[data-id]'));
    var dataValues = liElements.map(function(liElement) {
        return liElement.dataset.id;
    });

    // Создание объекта с вложенными объектами, где ключами будут значения data-id, а значениями будут пустые объекты
    var mainObject = {};

    dataValues.forEach(function(id, index) {
        mainObject[index] = { id: id }; // Добавление объекта с ключом index и пустым значением
    });


    let comments = Object.values(mainObject);


    let delay = 1000;

    let timerId = setTimeout(function request() {

        loadMessages(
            function () {
                // увеличить интервал для следующего запроса
                delay *= 2;
        },  function () {
                timerId = setTimeout(request, delay);
        })

    }, delay);

    function loadMessages(errorCb, alwaysCb) {

            $.ajax({
                method: 'post',
                url: "../CommentController",
                dataType: 'json',
            })
                .done(function (data) {
                    const lastCommentId = data[data.length - 1].id;

                    const addedComments = data.filter(element => {
                        return comments.every(comment => comment.id !== element.id);
                    });
console.log(addedComments)
                    const indexesToRemove = comments.flatMap((comment, index) => {
                        const isNeedToRemove = data.every(dataItem => dataItem.id !== comment.id);
                        return isNeedToRemove ? index : [];
                    });

                    removeMessages(indexesToRemove);

                    addedComments.forEach(comment => $(".message").append(renderMessage(comment, lastCommentId)));
                    //comments = data;

                })
                .fail(errorCb)
                .always(alwaysCb);

    }
});

function renderMessage(item, lastCommentId) {
    return`<li name="comments_id" class="col-lg-10 col-md-12 mx-auto my-2" data-id="${lastCommentId}">
                <div><u>${item.name}</u></div>
                <div>
                    <p>${item.Comment}</p>
                </div>
            </li>`
}

function removeMessages(messageIndexes) {
    const messagesContainer = document.querySelector('.message');
    const messagesList = messagesContainer.children;
    const messagesArray = Array.from(messagesList);
    messagesArray
        .filter((message, index) => {
            return messageIndexes.some(indexItem => indexItem === index);
        })
        .forEach(message => message.remove())
}

//Adding comments
$('#comments-send').submit(function (e) {

    $.ajax({
        method: 'post',
        url: "../CommentController",
        data: {'action' : 'add_comment',
               'comment' : $('#comment_text').val()},
    }).done(function (data) {$('#comment_text').val('')});
    return false;
})