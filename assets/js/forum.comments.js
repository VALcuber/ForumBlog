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
            url: getCurrentPathWithSlash() + "CommentController",
            dataType: 'json',
        })
            .done(function (data) {
                const removedCommentIds = comments.filter(comment => {
                    return data.every(dataItem => dataItem.id !== comment.id);
                }).map(comment => comment.id);

                removeMessages(removedCommentIds);

                removedCommentIds.forEach(id => {
                    comments = comments.filter(comment => comment.id !== id);
                });

                data.forEach(comment => {
                    if (!comments.some(c => c.id === comment.id)) {
                        mainObject[comment.id] = { id: comment.id };
                        $(".message").append(renderMessage(comment));
                        comments.push({ id: comment.id });
                    }
                });
            })
            .fail(errorCb)
            .always(alwaysCb);
    } // function for adding new messages to forum
});

function renderMessage(item) {
    return `<li name="comments_id" class="col-lg-10 col-md-12 mx-auto my-2" data-id="${item.id}">
                <div><u>${item.name}</u></div>
                <div>
                    <p>${item.Comment}</p>
                </div>
            </li>`;
}// Add messages from db

function removeMessages(commentIds) {
    const messagesContainer = document.querySelector('.message');
    commentIds.forEach(id => {
        const message = messagesContainer.querySelector(`li[data-id="${id}"]`);
        if (message) {
            message.remove();
        }
    });
}// Remove messages if they removed in db

function getCurrentPathWithSlash() {
    let path = window.location.pathname;
    if (!path.endsWith('/')) {
        path += '/';
    }
    return path;
} //function for getting current url and adding '/' to the end of it for correct work redirecting

$('#comments-send').submit(function (e) {

    $.ajax({
        method: 'post',
        url: getCurrentPathWithSlash() + "CommentController",
        data: {'action' : 'add_comment',
               'comment' : $('#comment_text').val()},
    }).done(function (data) {$('#comment_text').val('')});
    return false;
}) //Adding comments