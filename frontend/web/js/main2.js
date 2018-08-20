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

	// Scroll Events
	$(window).scroll(function(){

		var wScroll = $(this).scrollTop();

		// Activate menu
		if (wScroll > 250) {
			$('#main-nav').addClass('active');
			$('#slide-out-menu').addClass('scrolled');
		}
		else {
			$('#main-nav').removeClass('active');
			$('#slide-out-menu').removeClass('scrolled');
		}


		//Scroll Effects

	});


	// Navigation
	$('#navigation').on('click', function(e){
		e.preventDefault();
		$(this).addClass('open');
		$('#slide-out-menu').toggleClass('open');

		if ($('#slide-out-menu').hasClass('open')) {

			$('.menu-close').on('click', function(e){
				e.preventDefault();
				$('#slide-out-menu').removeClass('open');
			});
		}
	});

	// Wow Animations
    wow = new WOW(
      {
      boxClass:     'wow',      // default
      animateClass: 'animated', // default
      offset:       0,          // default
      mobile:       true,       // default
      live:         true        // default
    }
    );
    wow.init();


    // Menu For Xs Mobile Screens
    if ($(window).height() < 450) {
    	$('#slide-out-menu').addClass('xs-screen');
    }

    $(window).on('resize', function(){
	    if ($(window).height() < 450) {
	    	$('#slide-out-menu').addClass('xs-screen');
	    } else{
	    	$('#slide-out-menu').removeClass('xs-screen');
	    }
    });

    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    // Header Select 2 activation
    $.fn.select2.defaults.set("theme", "bootstrap");
    $(".js-states").select2({
        showSearchBox: false,
        width: 'resolve',
        theme: "bootstrap",
        minimumResultsForSearch: -1
    });

    function formatState (state) {

        if (!state.id) { return state.text; }
        var $state;
        if(state.element.id ){
            $state = $(
                '<span><img width="50" src="/uploads/users/115-115/' + state.element.id + '" class="img-flag" /> ' + state.text + '</span>'
            );
        }else {
            $state = $(
                '<span><img width="50" src="/images/default.jpg" class="img-flag" /> ' + state.text + '</span>'
            );
        }


        return $state;
    }

    $(".js-chat-select").select2({
        templateResult: formatState
    });

    // Header Select 2 activation
    $.fn.select2.defaults.set("theme", "bootstrap");
    $(".js-states-contact").select2({
        placeholder: "Select Contact",
        allowClear: true,
        showSearchBox: true,
        width: 'resolve',
        theme: "bootstrap",
        templateResult: formatState
    });

    /*Item Page Product corusel*/
    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });

    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slider-for',
        dots: false,
        centerMode: $('.thumbnail-images').data('cock') > 4 ? true : false,
        focusOnSelect: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow:4,
                    arrows: false
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 4,
                    arrows: false
                }
            },
            {

                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    arrows: false
                }
            }
        ]
    });

    $('.similar-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: false,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow:3,
                    arrows: false
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 2,
                    arrows: false
                }
            },
            {

                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    arrows: false
                }
            }
        ]
    });


    // Header carousel
    $('#main-carousel').slick({
        accessibility: true,
        adaptiveHeight: true,
        autoplay: true,
        autoplaySpeed: 4000,
        arrows: true,
        centerMode: true,
        centerPadding: '30px',
        cssEase: 'ease',
        customPaging: null,
        easing: 'linear',
        respondTo: 'slider',
        speed: 1500,
        variableWidth: true,
        vertical: false,
        rtl: false,
        responsive: [
            {
                breakpoint: 769,
                settings: {
                    arrows: false
                }
            },
            {
                breakpoint: 480,
                settings: {
                    arrows: false
                }
            }
        ]
    });

    /*upload image additem page*/
    $('.fileinput').fileinput();

    /*tool tip usage*/
    $('[data-toggle="tooltip"]').tooltip();

    /*Item Page show more/ show less*/
    $(document).ready(function() {
        // Configure/customize these variables.
        var showChar = 295;  // How many characters are shown by default
        var moretext = "<i class='fa fa-plus'></i> Read more";
        var lesstext = "<i class='fa fa-minus'></i> Read less";

        $('.description').each(function() {
            var content = $(this).html();

            if(content.length > showChar) {

                var c = content.substr(0, showChar);
                var h = content.substr(showChar, content.length - showChar);

                var html = c + '<span class="morecontent"><span>' + h + '</span><a href="" class="morelink">' + moretext + '</a></span>';

                $(this).html(html);
            }

        });

        $(".morelink").click(function(){
            if($(this).hasClass("less")) {
                $(this).removeClass("less").show( "slow" );
                $(this).html(moretext).show( "slow" );
            } else {
                $(this).addClass("less");
                $(this).html(lesstext);
            }
            $(this).parent().prev().slideToggle();
            $(this).prev().slideToggle();
            return false;
        });
    });
    
    /*Item datepiker*/

    /*$('.input-daterange').each(function() {

        var date = new Date();
        var day = date.getDate()+1;
        var month = date.getMonth();
        var year = date.getFullYear();
        var startData = new Date(month + 1 + '/' + day + '/' + year);

        $(this).datepicker({
            todayHighlight: true,
            startDate: startData,
            // endDate: endDate,
        });
    }).on('changeDate', function(ev){
        $('.datepicker-dropdown').hide();

        var start = $('#start').val();
        var m_start = $('.m-start').val();
        var date = start ? new Date(start) : new Date(m_start);
        var day = date.getDate()+1;
        var month = date.getMonth();

        var year = date.getFullYear();
        var endDate = month+1 + '/' + day + '/' + year;

        if ($(this).find('#end').val() <= $(this).find('#start').val()) {
            $('.end').val(endDate);
        }

    });*/

    var start = new Date();
    var end = new Date(new Date().setYear(start.getFullYear()+1));
    start.setDate(start.getDate() + 1);

    $('#start, .m-start').datepicker({
        todayHighlight:true,
        startDate : start,
        endDate   : end
    }).on('changeDate', function(){
        $('.datepicker-dropdown').hide();
        $('.datepicker-dropdown').removeClass("right-date");
        $('.datepicker-dropdown').addClass("left-date");

        var date1 = new Date();
        date1.setDate(date1.getDate() + 1);

        var endDate = new Date($(this).val());
        endDate.setDate(endDate.getDate() + 1);

        endDate = moment(endDate).format('MM/DD/YYYY');

        var startDate = new Date($(this).val());
        startDate.setDate(startDate.getDate() + 10);

        $('#end, .end').datepicker('setStartDate', new Date($(this).val()));
        $('#end, .end').datepicker('setEndDate', startDate );
        $('#end, .end').datepicker('setStartDate', endDate );
        $('#end, .end').datepicker({setEndDate: endDate} );
        $('.end').val(endDate);

        $('#end, .end').focus();

        //$('td.day').next().addClass('active');

        /*if(date1.getDate() === date2.getDate()){
            $(".field-rentdate-from_location:first-child #rentdate-from_h option").each(function (index) {
                if(index <= 18){
                   $(this).prop("disabled", true);
                   $(this).prop("selected", false);
                }
            }).select2("refresh");
        }
        else {
            $(".field-rentdate-from_location:first-child #rentdate-from_h option").each(function (index) {
                $(this).prop("disabled", false);
            }).select2("refresh");

        }*/
    });

    $('#end, .end').datepicker({
        todayHighlight:true,
        startDate : start,
        endDate   : end
    }).on('changeDate', function(){
        $('.datepicker-dropdown').hide();
        $('#start, .m-start').datepicker('setEndDate', new Date($(this).val()));
    });


    $('#end, .end').on("focus", function () {
        var i = 0;
        //$('.datepicker-dropdown.right-date:not(.left-date) td.day').removeClass('active');
        $('.datepicker-dropdown:not(.left-date) td.day').each(function () {
            if ($(this).hasClass('disabled')) {
            } else {
                if (i < 1) {
                    $(this).prev().addClass('active');
                    i++;
                }
            }
        });
    });

    /*Chat Page Scroll*/
    $('.inner-content-chat').slimScroll({
        height: '100%',
        color: '#333',
        railVisible: true,
        railColor: '#7f7f7f',
        railOpacity: 0.5,
        wheelStep: 50,
        alwaysVisible: true,
        start: 'bottom'
    });

    /*Chat Page Scroll*/
    $('.inner-content-chat1').slimScroll({
        height: '100%',
        color: '#333',
        railVisible: true,
        railColor: '#7f7f7f',
        railOpacity: 0.5,
        wheelStep: 50,
        alwaysVisible: true,
    });

    var $form = $('#item-category_id');
    $form.on('change', function () {
        var form = $(this);

        $.ajax({
            type: "POST",
            url: "/item/ajax-filter",
            data: {cat_id: form.val()},
            success: function (data) {
                if(form.val()){
                    $('#itemhasfilter-filter_id label').remove();
                    $.each(JSON.parse(data), function(key, val){
                        $('#itemhasfilter-filter_id').append('' +
                            '<label class="ckbox ckbox-primary col-md-6">' +
                                '<input type="checkbox" id="filter_' + key + '" name="ItemHasFilter[filter_id][]" value="' + key + '"> ' +
                                '<label for="filter_' + key + '">' + val + '</label>' +
                            '</label>');
                    });
                }else{
                    $('#itemhasfilter-filter_id label').remove();
                }
            }
        });
        return false;
    });

    var $form_model = $('#item-mark_id');
    $form_model.on('change', function () {
        var form = $(this);
        $.ajax({
            type: "POST",
            url: "/item/ajax-model",
            data: {mark_id: form.val()},
            success: function (data) {
                if(form.val()){
                    $('#item-model_id option').remove();
                    $('select#item-model_id').append('<option value="">-Choose a Course-</option>');
                    $.each(JSON.parse(data), function(key, val){
                        $('select#item-model_id').append('<option value="' + key + '">' + val + '</option>');
                    });
                }else{
                    $('select#item-model_id option').remove();
                    $('select#item-model_id').append('<option value="">-Choose a Course-</option>');
                }
            }
        });
        return false;
    });

    var priceInsurance = 0;
    // Navigation
    $("#additional-insurance input[type='checkbox']").on('click', function(e){

        if ($(this).is(":checked"))
        {
            priceInsurance +=  parseInt($(this).val());
            $(this).parent('.checkbox').parent('.form-group').parent('.col-md-5').parent('.my-checkbox').addClass('active');
        }else {
            priceInsurance -= parseInt($(this).val());
            $(this).parent('.checkbox').parent('.form-group').parent('.col-md-5').parent('.my-checkbox').removeClass('active');
        }
        var deys = $('.price-information').data('rent');
        var servicePrice = $('#price-for-additional-services').html();
        var totalPrice = (parseInt($('#price-for-transport').html()) + parseInt(servicePrice))+ (deys*priceInsurance);

        $('#price-for-additional-insurance').html(deys*priceInsurance);
        $('#total-price').html(totalPrice);
    });

    var priceServices = 0;
    // Navigation
    $("#additional-services input[type='checkbox']").on('click', function(e){

        if ($(this).is(":checked"))
        {
            priceServices +=  parseInt($(this).val());
            $(this).parent('.checkbox').parent('.form-group').parent('.col-md-5').parent('.my-checkbox').addClass('active');
        }else {
            priceServices -= parseInt($(this).val());
            $(this).parent('.checkbox').parent('.form-group').parent('.col-md-5').parent('.my-checkbox').removeClass('active');
        }
        var deys = $('.price-information').data('rent');
        var insurancePrice = $('#price-for-additional-insurance').html();
        var totalPrice = (parseInt($('#price-for-transport').html()) + parseInt(insurancePrice)) + (deys*priceServices);

        $('#price-for-additional-services').html(deys*priceServices);
        $('#total-price').html(totalPrice);
    });

    var priceDelivery = 0;
    $("#transport-delivery input[type='checkbox']").on('click', function(e){

        if ($(this).is(":checked"))
        {
            priceDelivery +=  parseInt($(this).val());
            $(this).parent('.checkbox').parent('.form-group').parent('.col-md-5').parent('.my-checkbox').addClass('active');
        }else {
            priceDelivery -= parseInt($(this).val());
            $(this).parent('.checkbox').parent('.form-group').parent('.col-md-5').parent('.my-checkbox').removeClass('active');
        }

        var insurancePrice = $('#price-for-additional-insurance').html();
        var servicesPrice = $('#price-for-additional-services').html();

        var totalPrice = (parseInt($('#price-for-transport').html()) + parseInt(insurancePrice)) + parseInt(servicesPrice)  + parseInt(priceDelivery);

        $('#prices-for-transport-delivery').html(priceDelivery);
        $('#total-price').html(totalPrice);
    });

    // Optimalisation: Store the references outside the event handler:
    var $window = $(window);

    function checkWidth() {
        var windowsize = $window.width();
        if (windowsize < 991) {
            //if the window is greater than 440px wide then turn on jScrollPane..
            $('.nav-item-info').removeClass('position-fix');
        }else{
            $('.nav-item-info').addClass('position-fix');
        }

        if (windowsize < 1199) {
            $('.position-fix').css('width', '47%');
        }else if(windowsize < 1007) {
            $('.position-fix').css('width', '87%');
        }else {
            $('.position-fix').css('width', '');
        }
    }
    // Execute on load
    // checkWidth();
    // Bind event listener
    // $(window).resize(checkWidth);

});
//for date time picker
$(function () {

    $(document).scroll(function () {
        var $footer = $('#footer');
        var y = $(document).scrollTop();
        var x = $footer.offset().top - window.innerHeight + $footer.height();
        if(y >= x){
            $('.toTheTop').addClass('active');
        }else {
            $('.toTheTop').removeClass('active');
        }
    });
    $(function(){
        // $('.selectpicker').select2({
        //     language: "es"
        // });
    });
});

