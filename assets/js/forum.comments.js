$(document).ready(function(){

    let comments = [];

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
                    const addedComments = data.filter(element => {
                        return comments.every(comment => comment.id !== element.id);
                    });
                    const indexesToRemove = comments.flatMap((comment, index) => {
                        const isNeedToRemove = data.every(dataItem => dataItem.id !== comment.id);
                        return isNeedToRemove ? index : [];
                    });
                    removeMessages(indexesToRemove);
                    addedComments.forEach(comment => renderMessage(comment));
                    comments = data;
                })
                .fail(errorCb)
                .always(alwaysCb);

    }
});

function renderMessage(item) {
    return`<li class="col-lg-10 col-md-12 mx-auto my-2">
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

/*
                    const filteredComments = data.filter(element => {
                        return comments.every(comment => comment.id !== element.id);
                    });
                    filteredComments.forEach(item => {
                        $(".message").append(renderMessage(item));

                    })
                    console.log (filteredComments);
                    comments = data;
 */