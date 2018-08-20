function button() {
    var height = 0;
    $('.inner-content-chat li').each(function (i, value) {
        height += parseInt($(this).height());
    });
    height += '';
    $('.inner-content-chat').animate({scrollTop: height}, 500);
}
$("#chat_message").keyup(function(event){
    if(event.keyCode == 13){
        $(".btn-send-comment").click();
    }
});

function reloadchat(message, clearChat) {
    var url = $(".btn-send-comment").data("url");
    var alias = $(".btn-send-comment").data("alias");
    var orderid = $(".btn-send-comment").data("orderid");

    $.ajax({
        url: url,
        type: "POST",
        data: {message: message, alias: alias, orderid: orderid},
        success: function (html) {
            if (clearChat == true) {
                $("#chat_message").val("");
            }
            $("#chat-box").html(html);
        }
    });
}
button();

function updateuser(dey) {

    $.ajax({
        url: '/chat/update-user',
        type: "POST",
        data: {dey:dey},
        success: function (html) {
            $("#chat-user").html(html);
        }
    });
}

setInterval(function () {
    reloadchat('', false);
    var val = $('#queue-search').val();
    if(!val){
        var dey = $( '.chat-dey' ).val();
        updateuser(dey);
    }
}, 2000);

$(".btn-send-comment").on("click", function () {
    var message = $("#chat_message").val();
    reloadchat(message, true);
    button();
    var dey = $( '.chat-dey' ).val();
    updateuser(dey);

});

$("#queue-search").on("keyup", function () {

    var search_word = $(this).val().toLowerCase();
    $(".queue-vid").each(function (index, element) {
        var curr_text = $(element).find(".vid-desc").find(".name").text().toLowerCase();
        if (curr_text.indexOf(search_word) === -1) {
            $(element).addClass("hide");
        } else {
            $(element).removeClass("hide");
        }
    });
});

$( ".chat-dey" ).change(function() {
    var dey = $( this ).val();
    updateuser(dey);
});