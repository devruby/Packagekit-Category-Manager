$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$('body').delegate('.wrap-button-add', 'click', function(){
	var parent = $(this).closest('.parent');
	if($(this).hasClass('active')){
		parent.find('.drop-list-user').css('display', 'none');
		$(this).removeClass('active');
	}else{
		$(this).addClass('active');
		parent.find('.drop-list-user').css('display', 'block');
	}
});

$('body').delegate('.drop-list-user input.input-text', 'keyup', function(){
	var parent			= $(this).closest('.parent');
	var text 			= $(this).val();
	var url 			= '/ajax/list-user';
	var list_id 		= parent.find('.current_user_id').val();
	var user_working	= parent.find('.user_working').val();
	var data 			= {};
	data.list_id 		= list_id;
	data.name 			= text;
	data.user_working 	= user_working;
	parent.find('.ul-lists-user').empty();
	$.post(url, data, function(res){
		parent.find('.ul-lists-user').html(res);
	});
});
	$('body').delegate('.drop-list-user li', 'click', function(){
		var parent 	= $(this).closest('.parent');
		var list_id = parent.find('.list_user_id').val();
		var user_id = $(this).data('id');
		if($(this).hasClass('active')){
			$(this).removeClass('active');
			var list_arr = list_id.split(',');
	        arr = jQuery.grep(list_arr, function( a ) {
	          return (a != user_id && a != ',');
	        });
	        list_id = arr.join(',');
	        parent.find('.list_user_id').val(list_id).trigger('change');
	        parent.find('.user_working').val(list_id).trigger('change');
	        parent.find('.wrap-member .wrap-img.user-'+user_id).remove();
		}else{
			$(this).addClass('active');
			var lastChar = list_id.substr(list_id.length - 1);
	        if(lastChar == ','){
	            list_id += user_id+',';
	        }else{
	            list_id += ','+user_id+',';
	        }
	        parent.find('.list_user_id').val(list_id).trigger('change');
	        parent.find('.user_working').val(list_id).trigger('change');
	        var url 		= '/ajax/add-member';
			var data 		= {};
			data.user_id 	= user_id;

			$.post(url, data, function(res){
				parent.find('.wrap-member').append(res);
			});
		}
		parent.find('.wrap-button-add').removeClass('active');
		// parent.find('.drop-list-user').css('display', 'none');
	});

