/*price range*/
$('#sl2').slider();
$('.sl2').slider();

var RGBChange = function() {
  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
};

$(document).ready(function(){
	lang = $('input[name=lang]').val();

	/*scroll to top*/
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});

	width_height(160);
    setTimeout(function(){
        width_height(160);
    }, 1000);

	checkboxColors();
	$('.category_checks label').click(function(){
		checkboxColors();
	});

	$('.addtowishlist').click(function(){
		$.post(lang + '/addtowishlist', { id : $(this).parent().parent().parent().parent().find('input[type="hidden"]').val() }, function(response){
			response = $.parseJSON(response);
			if(response.status == '1'){
				bootbox.alert('<span style="font-size: 18px;">' + response.message +'</span>');
			} else if(response.status == '2'){
				bootbox.alert('<span style="color: #ff0000;font-size: 18px;">' + response.message +'</span>');
			}
		});
	});

	$('.buy').click(function(){
		buy($(this).parent().parent().parent().parent().find('input[type="hidden"]').val());
	});

	$('.buy_work').click(function(){
		buy($(this).parent().find('input[type="hidden"]').val());
	});

	$('.work_form').submit(function(){
		return false;
	});

	$('.change_work').click(function(){

		$work_original = $(this).parent().parent().parent().parent().parent();

		$id = $(this).parent().parent().find('.modal-body').find('input[name="id"]');
		$title = $(this).parent().parent().find('.modal-body').find('input[name="title"]');
		$description = $(this).parent().parent().find('.modal-body').find('textarea[name="description"]');
		$price = $(this).parent().parent().find('.modal-body').find('input[name="price"]');
		$errors = {};

		successColor($title);
		successColor($price);

		if(validate($id.val(), 'undefined') && validate($title.val(), 'undefined') && validate($description.val(), 'undefined') && validate($price.val(), 'undefined')){

			if(!validate($id.val(), 'empty') || !validate($id.val(), 'length')){
				errorColor($id);
				$errors.id = '';
			}

			if(!validate($title.val(), 'empty') || !validate($title.val(), 'length')){
				errorColor($title);
				$errors.title = '';
			}

			if(!validate($price.val(), 'empty') && !validate($price.val(), 'price')){
				errorColor($price);
				$errors.price = '';
			}

			if($.isEmptyObject($errors)){
				$.post(lang + '/edit', { id : $id.val(), title : $title.val(), description : $description.val(), price : $price.val() }, function(response){
					response = $.parseJSON(response);
					if(response.status == '1'){
						$work_original.find('.work_id_' + response.content.id).find('.work_title').text(response.content.title);
						$work_original.find('.work_id_' + response.content.id).find('.work_description').text(response.content.description);
						$work_original.find('.work_id_' + response.content.id).find('.work_price').text(response.content.price);

						bootbox.alert(response.message);
					}
				});
			}

		}

	});

	$('.cart_quantity_delete').click(function(){
		$this_tr = $(this).parent().parent();
		bootbox.dialog({
			message: $('input[name="sure_text"]').val(),
			closable: false,
			buttons: [
				{
					label: $('input[name="cancel_text"]').val(),
					callback: function() {}
				},
				{
					label: $('input[name="ok_text"]').val(),
					cssClass: 'btn-primary',
					callback: function() {
						$.post(lang + '/delete', { id : $this_tr.find('input[name="id"]').val() }, function(response){
							response = $.parseJSON(response);
							if(response.status == '1'){
								$this_tr.remove();
								bootbox.alert(response.message);
							} else if(response.status == '2'){
								bootbox.alert(response.message);
							}
						});
					}
				}
			]
		});
	});

	$('.search_form').submit(function(){
		$search = $('input[name=search]').val();
		if(validate($search, 'undefined') && validate($search, 'empty') && validate($search, 'length')){
			window.location.href = lang + '/search/' + $.trim($search.replace('/', ''));
		}

		return false;
	});

	$('.add_message').click(function(){

		$message = $(this).prev().prev().prev();
		$errors = {};

		if(validate($message.val(), 'undefined')){

			if(!validate($message.val(), 'empty') || !validate($message.val(), 'length')){
				$errors.message = '';
			}

			if($.isEmptyObject($errors)){
				add_message($message);
			}
		}
	});

	$('.lang').click(function(){
		$.post('/changelang', { name : $(this).children().text() }, function(response){ });
	});

    $('.transfer_bottom label [type="checkbox"]').click(function(){
        if($(this).is(':checked')){
            $('[name="transfers[paypal_email]"]').val($(this).val());
        }
    });

    $('.transfer_form').submit(function(){

        $paypal_email =  $('[name="transfers[paypal_email]"]');
        $money        =  $('[name="transfers[money]"]');
        $errors = {};

        successColor($paypal_email);
        successColor($money);

        if(validate($paypal_email.val(), 'undefined') && validate($money.val(), 'undefined')){

            if(!validate($paypal_email.val(), 'empty') || !validate($paypal_email.val(), 'length')){
                errorColor($paypal_email);
                $errors.paypal_email = '';
            }

            if(!validate($money.val(), 'empty') || !validate($money.val(), 'length')){
                errorColor($money);
                $errors.money = '';
            }

            if($.isEmptyObject($errors)){
                transfer($paypal_email.val(), $money.val());
            }

        }

        return false;
    });

});

function width_height(x){
	$('.width_height').each(function(){
        $(this).height(x);
	});
}

function checkboxColors(){
	$('.category_checks [type="checkbox"]').each(function(){
		if($(this).is(':checked')){
			$(this).next().css('color', '#FE980F');
		} else {
			$(this).next().css('color', '#333333');
		}
	});
}

function buy($work_id){
	$('.loading').css('display', 'inline-block');
	$('.loading').next().css('display', 'none');
	$.post(lang + '/buy', { id : $work_id }, function(response){
		response = $.parseJSON(response);
		if(response.status == '1'){
			bootbox.alert('<span style="font-size: 18px;">' + response.message +'</span>');
			window.location.href = '/download/' + $work_id;
		} else if(response.status == '2'){
			bootbox.alert('<span style="color: #ff0000;font-size: 18px;">' + response.message +'</span>');
		}
		$('.loading').css('display', 'none');
		$('.loading').next().css('display', 'inline-block');
	}).done(function() {
        getBalance();
	});
}

function transfer($paypal_email, $money){
    $('.loading').css('display', 'inline-block');
    $('.loading').next().css('display', 'none');
    $.post(lang + '/balance/transfer', { paypal_email : $paypal_email, money : $money }, function(response){
        response = $.parseJSON(response);
        if(response.status == '1'){
            $('.transfer_form').parent().html('<span class="no_work" style="margin-top: 40px;display: block">' + response.message + '</span>');
        } else {
            bootbox.alert('<span style="color: #ff0000;font-size: 18px;">' + response.message +'</span>');
        }
        $('.loading').css('display', 'none');
        $('.loading').next().css('display', 'inline-block');
    }).done(function() {
        getBalance();
    });
}

function getBalance(){
    $.post('/getbalance', function (response) {
        response = $.parseJSON(response);
        if (response.status == '1') {
            $('.balance').text(response.balance);
        }
    });
}

function validate(data, type){
	switch (type){
		case 'undefined':
			if(typeof data == 'undefined'){
				return false;
			}
			break;
		case 'empty':
			if($.trim(data) == '' || $.trim(data) == null){
				return false;
			}
			break;
		case 'email':
			var atpos = data.indexOf("@");
			var dotpos = data.lastIndexOf(".");
			if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= data.length) {
				return false;
			}
			break;
		case 'price':
			if(parseInt(data) < $('.minPrice').val() || parseInt(data) > $('.maxPrice').val()){
				return false;
			}
			break;
		case 'length':
			if($.trim(data).length > 1000){
				return false;
			}
			break;
	}

	return true;
}

function successColor(element){
	element.css('border', '1px solid #cccccc');
}

function errorColor(element){
	element.css('border', '1px solid #a94442');
}

function add_message(e){
	$('.loading').css('display', 'inline-block');
	$.post(lang + '/adddiscussions', { message : e.val() }, function(response){
		response = $.parseJSON(response);
		if(response.status == '1'){
			bootbox.alert('<span style="font-size: 18px;">' + response.message +'</span>');
			e.val('');
		} else if(response.status == '2'){
			bootbox.alert('<span style="color: #ff0000;font-size: 18px;">' + response.message +'</span>');
		}
		$('.loading').css('display', 'none');
	});
}