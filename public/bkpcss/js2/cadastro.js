
function logradouroTipo(tipo) {
    switch (tipo) {
        case 'Rua':
            return 1;
            break;
        case 'Avenida':
            return 2;
            break;
        case 'Praça':
            return 3;
            break;
        case 'Estrada':
            return 4;
            break;
        case 'Beco':
            return 5;
            break;
        case 'Travessa':
            return 6;
            break;
        case 'Outros':
            return 7;
            break;
    }
}

///Configura Exibição dos campos Necessidade

var necessidade = $("input[name = 'usuario[necessidade]']:checked");
if (necessidade.val() == "S") {

} else {
    $("#necessidadeEspecial").css("display", "none");
}

$("input[name = 'usuario[necessidade]']").click(function() {
    var radioClicado = $(this).val();
    if (radioClicado == "S") {
        $("#necessidadeEspecial").css("display", "inherit");
    } else {
        $("input[name='usuario[necessidadeEspecial]']").removeAttr('checked');
        $("#necessidadeEspecial").css("display", "none");
    }
});
///Configura Exibição dos campos Trabalho
var trabalho = $("input[name = 'usuario[trabalha]']:checked");
if (trabalho.val() == "S") {
    $("#trabalha").css("display", "inherit");
    $("#naotrabalha").css("display", "none");
}
if (trabalho.val() == "N") {
    $("#trabalha").css("display", "none");
    $("#naotrabalha").css("display", "inherit");
} else {
    $("#trabalha").css("display", "none");
    $("#naotrabalha").css("display", "none");
}

$("input[name = 'usuario[trabalha]']").click(function() {
    var radioTrabalha = $(this).val();
    if (radioTrabalha == "S") {
        $("#trabalha").css("display", "inherit");
        $("#naotrabalha").css("display", "none");
    } else if (radioTrabalha == "N") {
        $("#trabalha").css("display", "none");
        $("#naotrabalha").css("display", "inherit");
    } else {
        $("#trabalha").css("display", "none");
        $("#naotrabalha").css("display", "none");
    }
});

///Configura Exibição dos campos Trabalho

var acessoInternet = $("input[name = 'usuario[casaComputadorInternet]']:checked");
if (acessoInternet.val() == "N") {
    $("#acessoInternet").css("display", "inherit");
} else {
    $("#acessoInternet").css("display", "none");
}

$("input[name = 'usuario[casaComputadorInternet]']").click(function() {
    var radioAcessoInternet = $(this).val();
    if (radioAcessoInternet == "N") {
        $("#acessoInternet").css("display", "inherit");
    } else {
        $("input[name='usuario[acessoInternet]']").removeAttr('checked');
        $("#acessoInternet").css("display", "none");
    }
});


///Configura Exibição dos campos Trabalho

var programaSocial = $("input[name = 'usuario[programaSocial]']:checked");
if (programaSocial.val() == "S") {
    $("#programaSocial").css("display", "inherit");
} else {
    $("#programaSocial").css("display", "none");
}

$("input[name = 'usuario[programaSocial]']").click(function() {
    var programaSocial = $(this).val();
    if (programaSocial == "S") {
        $("#programaSocial").css("display", "inherit");
    } else {
        $("input[name='usuario[programaSocialTipo]']").removeAttr('checked');
        $("#programaSocial").css("display", "none");
    }
});

///Configura Exibição dos campos Curso Atual

var cursoAtual = $("input[name = 'usuario[cursoAtual]']:checked");
if (cursoAtual.val() == "S") {
    $("#cursoAtual").css("display", "inherit");
} else {
    $("#cursoAtual").css("display", "none");
}

$("input[name = 'usuario[cursoAtual]']").click(function() {
    var cursoAtual = $(this).val();
    if (cursoAtual == "S") {
        $("#cursoAtual").css("display", "inherit");
    } else {
        $("input[name='usuario[cursoAtualTipo]']").removeAttr('checked');
        $("#cursoAtual").css("display", "none");
    }
});

///Configura Exibição dos campos Gradução

var graduacao = $("input[name = 'usuario[escolaridade]']:checked");
if (graduacao.val() == 7) {
    $("#graduacao").css("display", "inherit");
} else {
    $("#graduacao").css("display", "none");
}

$("input[name = 'usuario[escolaridade]']").click(function() {
    var graduacao = $(this).val();
    if (graduacao == 7) {
        $("#graduacao").css("display", "inherit");
    } else {
        $("input[name='usuario[redeUniversidade]']").removeAttr('checked');
        $("input[name='usuario[areaConhecimento]']").removeAttr('checked');
        $("#graduacao").css("display", "none");
    }
});



