/**
 * Created by Artur on 2/27/2017.
 */
$(document).ready(function() {

    $('#form-order-article').on('beforeSubmit', function(e) {
        var form = $(this);
        var formData = form.serialize();
        $(".submitStandard").prop('disabled', true);
        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: formData,
            success: function (data) {
                window.location.href = form.attr("action");
            },
            error: function () {
                window.location.href = form.attr("action");
            }
        });
    }).on('submit', function(e){
        e.preventDefault();
    });

    $('.remove').on('click', function () {

        var id = parseInt($(this).data('id'));
        var url = '/item/image-remove';
        $(this).hide();
        if (id) {
            $.ajax({
                type: "POST",
                url: url,
                data: "id=" + id,
                dataType: 'json',
                async: false,
                success: function (data) {
                    $(this).hide();
                }
            });
        }
    });

    $('#uploads').on('click', function () {
        $('.fileinput-preview').click();
    });

    $('.alert-status').on('switchChange.bootstrapSwitch', function (event, state) {

        console.log(state);

        if(state){
            $('.personal').removeClass('hide');
        }else{
            $('.personal').addClass('hide');
        }

    });

    $('.reset').on('click', function () {

        $('form input[type="text"]').val("");
        $('form textarea').val("");
    });

    $('.mailchimp-email').on('click', function () {

        var emails = $('#mailchimp-email').val();
        var base_url = $('#base-url').val();
        var url = '/mail-chimp';

        $.ajax({
            type: "POST",
            url: url,
            data: "emails=" + emails+'&base_url='+base_url,
            dataType: 'json',
            async: false,
            success: function (data) {
                if(data){
                    $(".help-block-mailchimp").html("<div class='has-error'><div class='help-block'>"+data.error+"</div></div>");
                    console.log(data);
                }
            }
        });
    });

});

