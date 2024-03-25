$(document).ready(function(){

    let start = 0;

    setInterval(loadMessages, 1000);

    function loadMessages() {
        if(start != start) {
            $.ajax({
                method: 'POST',
                url: "../../CommentController",

                dataType: 'json',
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                }
            })
                .done(function (data) {
                    //console.log(data);
                    data.forEach(item => {
                        $(".message").append(renderMessage(item));
                        start = item.id;
                        console.log(start);
                    })
                });
        }
        else{

        }


    }
});
function renderMessage(item) {
    return`<p class="col-lg-10 col-md-12 mx-auto my-2">${item.Comment}</p>`
}
