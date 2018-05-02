
//$("link")[1] -> Contraste
//$("link")[0] -> padrao
function folha(modo) {
    if (modo == "inicia") {
        if (Cookies.get("style")) {

            if (Cookies.get("style") == 1) {
                $("link")[1].disabled = false;
                $("link")[0].disabled = true;
            }else{
                $("link")[1].disabled = true;
                $("link")[0].disabled = false;
            }

            //$("link")[Cookies.get("style")].disabled = false;
        }
    } else if (modo == "troca") {

        if (Cookies.get("style") == 0) {
            $("link")[1].disabled = false;
            $("link")[0].disabled = true;
            Cookies.set("style", 1)
        } else if (Cookies.get("style") == 1) {
            $("link")[1].disabled = true;
            $("link")[0].disabled = false;
            Cookies.set("style", 0)
        }
        else {
            Cookies.set("style", 0);
        }
    }
}
