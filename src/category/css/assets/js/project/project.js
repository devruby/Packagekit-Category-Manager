$('#form').validate({
    rules: {
        project_type: 'required',
    },
    messages: {
        project_type: 'Không được để trống'
    }
});