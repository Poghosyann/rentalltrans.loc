$(document).ready(function() {

        $('.insurance input[type=radio]').change(function() {

            if (this.value == 0) {
                var price = $(this).data('deposite');
                $("#item-deposit").val(price);

                $("#item-deposit").prop('disabled', true);
            }
            else if (this.value == 1) {

                $("#item-deposit").prop('disabled', false);
                $("#item-deposit").val('');
            }
        });

});

