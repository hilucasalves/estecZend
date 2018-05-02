
$().ready(function() {
    // validate signup form on keyup and submit
    $("#albumForm").validate({
        rules: {
            'album[nome]': "required",
        },
        messages: {
            'album[nome]': "O valor é obrigatório e não pode estar vazio",
        }
    });

});
	