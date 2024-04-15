$(document).ready(function(){

    var liElements = Array.from(document.querySelectorAll('#messages li[data-id]'));
    var dataValues = liElements.map(function(liElement) {
        return liElement.dataset.id;
    });

    var mainObject = {};

    dataValues.forEach(function(id, index) {
        mainObject[index] = { id: id };
    });


    let comments = Object.values(mainObject);


    let delay = 1000;

    let timerId = setTimeout(function request() {

        loadMessages(
            function () {
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

                    const indexesToRemove = comments.flatMap((comment, index) => {
                        const isNeedToRemove = data.every(dataItem => dataItem.id !== comment.id);
                        return isNeedToRemove ? index : [];
                    });

                    removeMessages(indexesToRemove);

                    addedComments.forEach(comment => {
                        const newIndex = Object.keys(mainObject).length;
                        mainObject[newIndex] = { id: comment.id };
                        $(".message").append(renderMessage(comment, lastCommentId));
                    });

                })
                .fail(errorCb)
                .always(alwaysCb);

    }
});
//Add messages from db
function renderMessage(item, lastCommentId) {
    return`<li name="comments_id" class="col-lg-10 col-md-12 mx-auto my-2" data-id="${lastCommentId}">
                <div><u>${item.name}</u></div>
                <div>
                    <p>${item.Comment}</p>
                </div>
            </li>`
}
//Remove messages if they removed in db
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