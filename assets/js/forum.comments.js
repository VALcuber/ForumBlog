
$(document).ready(function(){
    $.ajax({
        url: "../controllers/PageController.php",
        type:"POST",
        //dataType:'json',
        data: {
            action: 'echo_comments'
        },
        success: function(data) {
            console.log(data);
        }

    })
});

