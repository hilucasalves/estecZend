
function mascara_data_onkeypress(campo)
{
	tecla = new String(event.keyCode);
	// Verificando se o cara digitou n�mero
	if (tecla.search(/^(4[89]|5[0-7])$/)>-1)
	{
		valor = new String(campo.value);
		if ((valor.length==2) || (valor.length==5))
		    campo.value += "/";
	}
	else
	    event.returnValue = false;
}

/* Serve para verificar se a data foi digitada corretamente
   OBS.: Deve colocar no ONBLUR */
function mascara_data_onblur(campo, erro1, erro2)
{
	valor = new String(campo.value);
	if (valor.length>0)
	{
		// Verificando se a data est� completa
		if (valor.length==10)
		{
		    // Verificando se a data foi digitada corretamente
			if (valor.search(/^[0-3][0-9]\/[0-1][0-9]\/[0-9][0-9][0-9][0-9]$/)>-1)
			    return true;
			else
			{
			    alert(erro1);
				campo.focus();
				return false;
			}
		}
		else
		{
			// Erro informando sobre a data n�o estar completa
		    alert(erro2);
			campo.focus();
			return false;
		}
	}
}

/* Serve para se evitar BUG�s na hora do erro
   OBS.: Deve colocar no ONFOCUS */
function mascara_data_onfocus(campo)
{
	valor = new String(campo.value);
    if ((valor.length!=2) && (valor.length!=5))
	{
	    campo.select(); 
	}
}

//-----------------------------------------------------------------------------

/* Verificar se o campo � inteiro
   OBS.: Deve se colocar no ONBLUR */
function campo_inteiro(campo, erro) 
{
	valor = new String(campo.value);
    if (valor.length!=0)
	{
		// Express�o Regular para aceitar s� n�mero
		if (valor.search(/^[0-9]+$/)>-1)
			return true;
		else
		{
			alert(erro);
			campo.focus();
			return false;
		}		
	}
}

//-----------------------------------------------------------------------------
function mvalor(v){  
        	v=v.replace(/\D/g,"");//Remove tudo o que não é dígito  
                v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões  
                v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares  
												  	
                v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos  
                	return v;  
          }
//-----------------------------------------------------------------------------

/* M�scara de dinheiro
   OBS.: Deve se colocar no ONKEYPRESS */
function mascara_dinheiro_onkeypress(campo)
{	
	tecla = new String(event.keyCode);
	
	valor = new String(campo.value);
	
	// Verificando se o cara digitou n�mero
	if ((tecla.search(/^(4[89]|5[0-7])$/)>-1) && (valor.length<12))
	{
		// Tirando a pontua��o
		valor = valor.replace(",", "");
		valor = valor.replace(/\./, "");
		
		if (valor.length==2)
			campo.value = valor.substr(0, 1)+","+valor.substr(1, 2);
		else if (valor.length>2)
		{
			// Pegando os reais e centavos
			reais    = new String(valor.substr(0, valor.length-1));
			centavos = valor.substr(valor.length-1, 1);
			
			if (reais.length>2)
			{
				divisao = reais.length%3;
				if (divisao>0)
				{
					primeira = reais.substr(0, divisao);
					segunda  = new String(reais.substr(divisao));
					
					tmp = "";
					for(i=0;i<segunda.length;i+=3)
						tmp = tmp+"."+segunda.substr(i, 3);
					
					campo.value = primeira+tmp+","+centavos;
				}
				else
				{
					tmp = "";
					for(i=0;i<reais.length;i+=3)
						tmp = tmp+reais.substr(i, 3)+".";
					
					tmp = new String(tmp);
					reais = tmp.replace(/\.$/, "");
					
					campo.value = reais+","+centavos;
				}			
			}
			else
			    campo.value = reais+","+centavos;
		}
	}
	else
	    event.returnValue = false;
}

//-----------------------------------------------------------------------------

//-----------------------------------------------------------------------------

/* M�scara de CPF
   OBS.: Deve colocar no ONKEYPRESS */
function mascara_cpf_onkeypress(campo)
{
    // Verificando se o digitou um n�mero
	tecla = new String(event.keyCode);
	if (tecla.search(/^(4[89]|5[0-7])$/)>-1)
	{
	    // Adicionando caracteres especiais
		valor = new String(campo.value);
		switch(valor.length)
		{
			case 3:
		    case 7:			
			             campo.value += ".";
						 break;
			case   11:
			             campo.value += "-";
						 break;
		}
	}
	else
	    event.returnValue = false;    
}

/* Verifica se o CPF foi digitado corretamente
   OBS.: Deve colocar no ONBLUR */
function mascara_cpf_onblur(campo, erro1, erro2) 
{

	// Verificando se o programador informo os erros
	if (erro1==undefined)
	    erro1 = "Informe o CPF corretamente.";
	if (erro2==undefined)
	    erro2 = "CPF inv�lido! Por favor, digite-o novamente.";
	
	// Transformando o CPF digitado somente em n�meros
	cpf = new String(campo.value);	

	if (cpf.length>0)
	{
	    // Tirando a pontua��o
		cpf = cpf.replace(".", "");
		cpf = cpf.replace(".", "");
		cpf = cpf.replace("-", "");				
		if (cpf.length==11) 
		{
			if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999")
			{
				// CPF inv�lido
				alert(erro2);
				campo.focus();
				return false;
			}
			else
			{		     
				var a = [];
				var b = new Number;
				var c = 11;
				for (i=0; i<11; i++)
				{
					a[i] = cpf.charAt(i);
					if (i < 9)
						b += (a[i] * --c);
				}
				
				if ((x = b % 11) < 2) 
					a[9] = 0;
				else 
					a[9] = 11-x;
				
				b = 0;
				c = 11;
				for (y=0; y<10; y++)
					b += (a[y] * c--);
					
				if ((x = b % 11) < 2) 
					a[10] = 0;
				else 
					a[10] = 11-x; 
					
				if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]))
				{
					alert(erro2);
					campo.focus();
					return false;
				}
				else
					return true;
			}
		}
		else
		{
			// Informando que o CPF n�o est� completo
			alert(erro1);
			campo.focus();
			return false;
		}	
	}	
}

/* Serve para selecionar os dados do campo e evitar BUG�s na hora do erro
   OBS.: Deve colocar no ONFOCUS */
function mascara_cpf_onfocus(campo)
{
    valor = new String(campo.value);
	if ((valor.length!=3) && (valor.length!=7) && (valor.length!=11))
	    campo.select();	
}

//-----------------------------------------------------------------------------


//-----------------------------------------------------------------------------

/* Verifica se o cliente s� digitou n�mero
   OBS.: Deve se colocar no ONKEYPRESS */
function campo_inteiro_onkeypress()
{
	tecla = new String(event.keyCode);
	// Verificando se o cara digitou n�mero ou pontua��o float
	if (tecla.search(/^(4[89]|5[0-7])$/)==-1)
		event.returnValue = false;   
}


/* Verificar se o campo � inteiro
   OBS.: Deve se colocar no ONBLUR */
function campo_inteiro_onblur(campo, erro) 
{
	// Verificando se algum erro foi definido
	if (erro==undefined)
	    erro = "Esse campo s� aceita n�meros.";
	
	valor = new String(campo.value);
    if (valor.length!=0)
	{
		// Express�o Regular para aceitar s� n�mero
		if (valor.search(/^[0-9]+$/)>-1)
			return true;
		else
		{
			alert(erro);
			campo.focus();
			return false;
		}		
	}
}

//-----------------------------------------------------------------------------
//-----------------------------------------------------------------------------

/* M�scara de hora
   OBS.: Deve se colocar no ONKEYPRESS */
function mascara_hora_onkeypress(campo)
{
	tecla = new String(event.keyCode);
	// Verificando se o cara digitou n�mero
	if (tecla.search(/^(4[89]|5[0-7])$/)>-1)
	{
		valor = new String(campo.value);
		if (valor.length==2)
		    campo.value += ":";
	}
	else
	    event.returnValue = false;
}

/* Serve para verificar se a hora foi digitada corretamente
   OBS.: Deve colocar no ONBLUR */
function mascara_hora_onblur(campo, erro1, erro2)
{
	valor = new String(campo.value);
	if (valor.length>0)
	{
		// Verificando se a hora est� completa
		if (valor.length==5)
		{
		    // Verificando se a hora foi digitada corretamente
			if (valor.search(/^[0-2][0-9]:[0-5][0-9]$/)>-1)
			    return true;
			else
			{
			    alert(erro1);
				campo.focus();
				return false;
			}
		}
		else
		{
			// Erro informando sobre a hora n�o estar completa
		    alert(erro2);
			campo.focus();
			return false;
		}
	}
}

function mascara_fracao_onkeypress(campo)
{
	tecla = new String(event.keyCode);
	// Verificando se o cara digitou n�mero
	if (tecla.search(/^(4[89]|5[0-7])$/)>-1)
	{
		valor = new String(campo.value);
		if (valor.length==1)
		    campo.value += ".";
	}
	else
	    event.returnValue = false;
}

/* Serve para se evitar BUG�s no campo hora quando ocorrer um erro
   OBS.: Deve colocar no ONFOCUS */
function mascara_hora_onfocus(campo)
{
	valor = new String(campo.value);
    if (valor.length!=2)
	    campo.select(); 
}

/* Serve para se evitar BUG�s no campo hora quando ocorrer um erro
   OBS.: Deve colocar no ONFOCUS */

function mascara_fracao_onfocus(campo)
{
	valor = new String(campo.value);
    if (valor.length!=1)
	    campo.select(); 
}

//-----------------------------------------------------------------------------

// OBS.: Deve colocar no  */
function validar_email(email)
	{
		valor = new String(email.value);
		
		var the_at = valor.indexOf("@");
		var the_dot = valor.lastIndexOf(".");
		var a_space = valor.indexOf(" ");

		if (
			 (the_at != -1) &&
			 (the_at != 0) &&
			 (the_dot != -1) &&
			 (the_dot > the_at +1) &&
			 (the_dot < valor.length - 1) &&
			 (a_space == -1)
			 

			)
				{
				return true;
				}
				else
				{
				if(valor == '') {
				 return true; 
				}
				alert ("E-mail inv�lido. Digite-o novamente");
				email.focus();
				return false;
				}
	}

//----------------------------------------------------------------
// M�scara CNPJ
//-----------------------------------------------------------------------------

/* M�scara de CNPJ
   OBS.: Deve colocar no ONKEYPRESS */
function mascara_cnpj_onkeypress(campo)
{
    // Verificando se o digitou um n�mero
	tecla = new String(event.keyCode);
	if (tecla.search(/^(4[89]|5[0-7])$/)>-1)
	{
	    // Adicionando caracteres especiais
		valor = new String(campo.value);
		switch(valor.length)
		{
		    case  2:
			case  6:
			             campo.value += ".";
						 break;
			case 10:
			             campo.value += "/";
						 break;
			case 15:
						 campo.value += "-";
						 break;
		}
	}
	else
	    event.returnValue = false;    
}

/* Verifica se o CPNJ foi digitado corretamente
   OBS.: Deve colocar no ONBLUR */
function mascara_cnpj_onblur(campo, erro1, erro2) 
{
	/* Fun��o escrita por Thiago Prado (pradogeracao@hotmail.com).
	   Modificada por Michel Filipe (michel.filipe@gmail.com) no quesito processamento. */

   	// Configurando os erros se n�o foram informados
	if (erro1==undefined)
	    erro1 = "Informe o CNPJ corretamente.";
	if (erro2==undefined)
	    erro2 = "CNPJ inv�lido! Por favor, digite-o novamente.";
	
	cnpj = new String(campo.value);
    
	if (cnpj.length>0)
	{
		// Substituir os caracteres que n�o s�o n�meros
		cnpj = cnpj.replace(".","");
		cnpj = cnpj.replace(".","");
		cnpj = cnpj.replace("/","");
		cnpj = cnpj.replace("-","");	
		if (cnpj.length==14)
		{	
			if (cnpj=="00000000000000")
			{
				alert(erro2);
				campo.focus();
				return false;			
			}
			
			var a = [];
			var b = new Number;
			var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
			for (i=0; i<12; i++)
			{
				a[i] = cnpj.charAt(i);
				b += a[i] * c[i+1];
			}
			if ((x = b % 11) < 2)
				a[12] = 0;  
			else 
				a[12] = 11-x;
				
			b = 0;
			for (y=0; y<13; y++) 
				b += (a[y] * c[y]);
				
			if ((x = b % 11) < 2) 
				a[13] = 0; 
			else 
				a[13] = 11-x;
			
			if ((cnpj.charAt(12) != a[12]) || (cnpj.charAt(13) != a[13]))
			{
				alert(erro2);
				campo.focus();
				return false;
			}
			else
				return true;
				
		}
		else
		{
			alert(erro1);
			campo.focus();
			return false;
		}
	}	
}

/* Serve para selecionar os dados do campo e evitar BUG�s na hora do erro
   OBS.: Deve colocar no ONFOCUS */
function mascara_cnpj_onfocus(campo)
{
    valor = new String(campo.value);
	if ((valor.length!=2) && (valor.length!=6) && (valor.length!=10) && (valor.length!=15))
	    campo.select();	
}

//-----------------------------------------------------------------------------

/* Masc�ra para campos onde se pode ter CPF ou CNPJ
   OBS.: Deve colocar no ONKEYPRESS */
function campo_cpf_cnpj_onkeypress()
{
	tecla = new String(event.keyCode);
	
	// Verificando se o cara digitou n�mero ou pontua��o float
	if (tecla.search(/^(4[5-9]|5[0-7])$/)==-1)
		event.returnValue = false;   
}

/* Verifica se o campo � CNPJ ou CPF e faz a valida��o
   OBS.: Deve colocar no ONBLUR */
function campo_cpf_cnpj_onblur(campo, erro)
{
	// Verificando se o programador informo o erro
	if (erro==undefined)
	    erro = "Esse campo deve ser preenchido com um CPF ou CNPJ.";
	
	valor = new String(campo.value);
	
	if (valor.length>0)
	{
		// Verificando se o CPF ou CNPJ est�o preenchidos		
		if (valor.search(/^([0-9]{3}\.){2}[0-9]{3}\-[0-9]{2}$/)>-1)
			mascara_cpf_onblur(campo);
		else if (valor.search(/^[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}$/)>-1)
		    mascara_cnpj_onblur(campo);
		else
		{
			alert(erro);
			campo.focus();
			return false;
		}	
	}
}


/* Serve para selecionar os dados do campo quando ocorrer um erro
   OBS.: Deve colocar no ONFOCUS */
function campo_cpf_cnpj_onfocus(campo)
{
	campo.select();	
}


//-----------------------------------------------------------------------------

/* Verificar se os campos do formul�rio est�o vazios
   OBS.: Deve colocar no ONSUBMIT junto com RETURN(formul�rio)
         Na vari�vel campos, pode se informar um array com o nome dos campos */
function verificar_campo_vazio(formulario, campos, erro,bolMensagem)
{


    if (erro==undefined)
	    erro = 'O(s) seguinte(s) campo(s) deve(m) ser preenchido(s):';
	var erros = "";

	// Verificando se campos � vazio, pois assim ele verifica todos os campos
	if (campos==undefined)
	{
		
	    // Verificando todos os campos do formul�rio est�o preenchidos
		for(i=0; i<formulario.elements.length; i++)
		{
			var erro_tmp = 0;
			with (formulario.elements[i])
			{
				switch(type)
				{
				    case "text":
					case "select-one":					
					case "hidden":
					case "password":
					case "file":
					    if (value=="")
						    erro_tmp = 1;
					    break;
					case "textarea":
					    if (value.length==0)
						    erro_tmp = 1;					
					    break;
					case "checkbox":
					    if (checked==false)
						    erro_tmp = 1;
					    break;

				}
				
				switch(value)
				{
				    case      "00:00":
					case   "00:00:00":
					case "00/00/0000":
					    erro_tmp = 1;
					    break;
				}
				
				if (erro_tmp==1)
				{
				   // Vari�vel que vai guardar o nome do campo configurado
				   if (title!="")
					   tmp = title;
				   else
				   {
				       tmp = id;
					   tmp = tmp.toUpperCase();
				   }
				   tmp = new String(id);
				   tmp = tmp.replace("_", " ");
				   tmp = tmp.replace("_", " ");
				   tmp = tmp.replace("_", " ");
				   tmp = tmp.replace("_", " ");
				   tmp = tmp.toUpperCase();
				   erros += "- "+tmp+"\n";
				}
			}
		}
		
		if (erros!="")
		{
		    alert(erro+"\n\n"+erros);
			return false;
		}
		else
		    return true;
	}    
	else
	{
	    for (i=0;i<campos.length;i++)
		{
			var erro_tmp = 0;
			eval('objCampo = formulario.'+campos[i]+';')
			//alert(campos[i]+"\n"+i+" -> "+ objCampo.type);
			with (objCampo)
			{
				switch(type)
				{
					case "text":
					case "select-one":
					case "hidden":
					case "password":
					case "file":
					    if (value=="")
						    erro_tmp = 1;
					    break;
					case "textarea":
					    if (value.length==0)
						    erro_tmp = 1;					
					    break;
					case "checkbox":
					    if (checked==false)
						    erro_tmp = 1;
					    break;
				}
				
				switch(value)
				{
				    case      "00:00":
					case   "00:00:00":
					case "00/00/0000":
					    erro_tmp = 1;
					    break;
				}
				
				if (erro_tmp==1)
				{
				   // Vari�vel que vai guardar o nome do campo configurado
				   if (title!="")
					   tmp = title;
				   else
				   {
				       tmp = id;
					   tmp = tmp.toUpperCase();
				   }
				   tmp = new String(tmp);
				   tmp = tmp.replace("_", " ");
				   tmp = tmp.replace("_", " ");
				   tmp = tmp.replace("_", " ");
				   tmp = tmp.replace("_", " ");
				   erros += "- "+tmp+"\n";
				}			
			}
		}
		if (erros!="")
		{
	    	alert(erro+"\n\n"+erros);
			return false;
		}
		else
		    return true;		
	}
}///-----------------------------------------------------------------------------

/* Verifica se a data inicial � menor que a data final
   OBS.: Deve se colocar no onclick */
function validar_datas(data_inicial, data_final, erro) 
{
	data_inicial = data_inicial.value;
	data_final   = data_final.value;

	data_inicial_dia = data_inicial.substr(0, 2);
	data_inicial_mes = data_inicial.substr(3, 2);
	data_inicial_ano = data_inicial.substr(6, 4);
	
	data_inicial  = data_inicial_ano;
	data_inicial += "/";
	data_inicial += data_inicial_mes;	
	data_inicial += "/";
	data_inicial += data_inicial_dia;
	
	data_final_dia = data_final.substr(0, 2);
	data_final_mes = data_final.substr(3, 2);
	data_final_ano = data_final.substr(6, 4);
	
	data_final  = data_final_ano;
	data_final += "/";
	data_final += data_final_mes;	
	data_final += "/";
	data_final += data_final_dia;

	data_inicial = Date.parse(data_inicial);
	data_final   = Date.parse(data_final);

	if (data_inicial>data_final)
	{
		alert(erro);
		return false;
	}
	else
	{
		return true;
    }
}

//---------------------------------------------------------------

function validar_cpf_cnpj(cpf_cnpj)
{
valor = new String(cpf_cnpj.value);

    if(valor == "")
	{
    return true;	
    }
	else
	{
       if(valor.length != 14 && valor.length != 11)
	   {
	   alert("CPF ou CNPJ inv�lido. Digite-o novamente.");
	   cpf_cnpj.focus();
	   return false;
	   }
	   else
	   {
	       if(valor.length == 11)
	       {
	 	        mascara_cpf_onblur(cpf_cnpj);
	       }
	       if(valor.length == 14)
	       {
				mascara_cnpj_onblur(cpf_cnpj);
	       }
	    }
	       
	return false;
	}
}

//--------------------------------------------------------------------------------------------
function validarTamanhoSenha(senha)
{
    var valor = senha.value;
	
	if(valor == "")
	{
	    return true;
	}
	
    if(valor.length < 6)
    {
        alert("� necess�rio que informe uma senha de 6 � 12 caracteres!");
        senha.focus();
        return false;
    }
}

//------------------------------------------------------------

function validarSenhas(senha, conf_senha)
{            
	 if(senha.value == conf_senha.value)
	 {
	 return true;
	 }
	 else
	 {
	 document.form.senha.value = "";
	 document.form.conf_senha.value = "";
	 alert("A senha informada n�o confere com a confima��o de senha!");
	 senha.focus();
     return false;
     }

}

function abrirJanela(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

//------------------------------------------------
/*
function desabilitar()
{	
	document.form.cpf_cnpf.disabled = true;
	desativados = "#cccccc";
	document.form.cpf_cnpf.style.background = desativados;
}

function habilitar()
{	
	document.form.cpf_cnpf.disabled = false;
	desativados = "";
	document.form.cpf_cnpf.style.background = desativados;
}*/

