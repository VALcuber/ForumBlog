$(document).ready(function(){

    let comments = [];

    setInterval(loadMessages, 15000);

    function loadMessages() {

            $.ajax({
                method: 'post',
                url: "../../CommentController",
                dataType: 'json',
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                }
            })
                .done(function (data) {
                    //console.log(data);
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
    return`<p class="col-lg-10 col-md-12 mx-auto my-2">${item.Comment}</p>`
}
