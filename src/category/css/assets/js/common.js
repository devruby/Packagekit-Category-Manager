$(document).ready(function(){
    $('.checked-all').click(function(event) {
        if (this.checked) {
            $(':checkbox').prop('checked', true);
        } else {
            $(':checkbox').prop('checked', false);
        }
        var check_del = $("input[name='check_del']:checked").length;

        if(check_del === 0){
            $('#hidden-all-hai').addClass('hidden');
        }else{
            $('#hidden-all-hai').removeClass('hidden');
        }
    });

    $('a.td-delete').click(function(){
        if(!confirm('Bạn có chắc muốn xóa ?')){
            e.preventDefault();
            return false;
        }else{
            var table   = $(this).data('table');
            var id      = $(this).data('id');
            var url     = '/ajax/delete-column';
            var data    = {};
            data.id     = id;
            data.table  = table;
            data._token = $('input[name="_token"]').val();
            $.post(url, data, function(response){
                location.reload();
            });
        }
    });

    $('input.del-all').click(function(){
        var arr = [];
        var id  = "";
        $( "input[name='check_del']" ).each(function() {
            id = $( this ).data('id');
            if ($( this ).is(':checked')){
                arr.push(id);
            }
        });

        if (confirm("Bạn có chắc chắn muốn xóa tất cả?")) {
            $.ajax({
                url: '/ajax/delete-column',
                type: 'POST',
                data: {
                    id: arr,
                    table: $(this).data('table'),
                    _token: $('input[name="_token"]').val(),
                }
            }).done(function(data) {
                location.reload();
            });
        }
        return false;
    });

    $('#translate').submit(function(){
        var mess        = $('.message_error').text();
        var pages       = $('select[name="pages"]').val();
        var in_code     = $('input[name="in_code"]').val();
        var check       = false;
        var topElement  = $('#translate').offset().top;
        if(pages == ''){
            $('span.error_pages').css('display', 'block').html(mess);
            check = true;
        }else{
            $('span.error_pages').css('display', 'none');
        }
        if(in_code == ''){
            $('span.error_code').css('display', 'block').html(mess);
            check = true;
        }else{
            $('span.error_code').css('display', 'none')
        }
        if(check){
            $('html,body').animate({scrollTop : topElement-50},300);
            return false;
        }   
    });

});

