$(document).ready(function(){

    let comments = [];

    //setTimeout(loadMessages, 1000);

    let delay = 500;

    let timerId = setTimeout(function request() {


        if (!loadMessages()) {
            // увеличить интервал для следующего запроса
            delay *= 2;
        }

        timerId = setTimeout(request, delay);

    }, delay);

    function loadMessages() {

            $.ajax({
                method: 'post',
                url: "../CommentController",
                dataType: 'json',
            })
                .done(function (data) {
                    const filteredComments = data.filter(element => {
                        return comments.every(comment => comment.id !== element.id);
                    });
                    filteredComments.forEach(item => {
                        $(".message").append(renderMessage(item));

                    })
                    comments = data;
                });

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