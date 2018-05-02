
font("inicia");
(function($) {
    $.contraste = {
        on: function() {
            $("link[rel*=alt][rel*=style]").each(function() {
                this.disabled = true;
                if ($(this).attr("title") == 'contraste') {
                    this.disabled = false;
                }
            });
        },
        off: function() {
            $("link[rel*=alt][rel*=style]").each(function() {
                this.disabled = true;
            });
        }
    }
})(jQuery);

if (Cookies.get('contraste') == 'ok')
    $.contraste.on();

$(document).ready(function(e) {
    $("#bt_contraste_alto").click(function() {

        if (Cookies.get('contraste') == 'ok') {
            $.contraste.off();
            Cookies.set('contraste', null, {path: '/'});
            return false;
        } else {
            $.contraste.on();
            Cookies.set('contraste', 'ok', {expires: 7, path: '/'});
            return false;
        }
    });

    if (Cookies.get('contraste') == 'ok')
        $.contraste.on();

/// FONTE
    font("inicia");
    $("#font-aum").click(function() {
        font("aum");

    });
    $("#font-dim").click(function() {
        font("dim");

    });
    $("#font-nor").click(function() {
        font("nor");

    });
});

if (!Cookies.get('font')) {
    Cookies.set('font', 14, {expires: 7, path: '/'});
    font("inicia");
}




function font(tamanho) {

    var size = $("body").css('font-size');
    //size = size.replace('px', '');

    var sizeTamanho;

    if (tamanho == "aum") {
        size = (parseInt(Cookies.get('font')) + 1) > 21 ? 21 : (parseInt(Cookies.get('font')) + 1);
    } else if (tamanho == "dim") {
        size = (parseInt(Cookies.get('font')) - 1) < 10 ? 10 : (parseInt(Cookies.get('font')) - 1);
    } else if (tamanho == "nor") {
        size = 14;
    } else if ("inicia") {
        size = parseInt(Cookies.get('font'));
    }
    $("body").animate({'font-size': size + 'px'});
    Cookies.set('font', size, {expires: 7, path: '/'});
}