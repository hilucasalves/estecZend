function add_campos() {
    var currentCount = $('form > div > fieldset').length;
    currentCount += 20;
    var template = $('form > fieldset > span').data('template');
    template = template.replace(/__index__/g, currentCount);

    $('#campos').append(template);

    return false;
}


function add_restricao() {
    var currentCount = $('form > div > fieldset > fieldset').length;
    var template = $('form > div > fieldset > span').data('template');
    template = template.replace(/__index__/g, currentCount);

    $('#restricao').append(template);

    return false;
}

function add_imagem() {
    var currentCount = $('tbody > tr').length;
    currentCount += 1;
    var template = $('form > span').data('template');
    
    // alert(template);
    
    template = template.replace(/__index__/g, currentCount);

    $('tbody').append(template);

    return false;
}

