$(document).ready(function() {

    $("input[name='cpf']").mask("999.999.999-99");
    $("input[name='usuario[telefoneResidencial]']").mask("(99)9999-9999");
    $("input[name='usuario[telefoneCelular]']").mask("(99)9999-9999?9");
    $("input[name='usuario[endereco][cep]']").mask("99999-999");
    $("input[name='unidade[telefone]']").mask("(99)9999-9999");
    //$("input[name='unidade[dataInauguracao]']").mask("99/99/9999");
    $("input[name='unidade[endereco][cep]']").mask("99999-999");


    // alert(window.navigator.userAgent);
    var nAgt = navigator.userAgent;



// In Chrome, the true version is after "Chrome" 
    if ((nAgt.indexOf("Chrome")) != -1) {
    } else {
        $("input[type='date']").mask("99/99/9999");
    }





});