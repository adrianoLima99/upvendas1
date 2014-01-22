function verificaSenha() {
	if (document.getElementById('senha').value == document.getElementById(confsenha).value) {
		alert("Senha!!")
		return true;
	} else {
		alert("Senha não são Iguais!!");
		return false;
	}
}

function camposVazios() {
	if (document.getElementByid('fisica').value == '') {
		alert("Campo CPF não pode ser vazio!!");
		return false;
	}
	if (document.getElementByid('juridica').value == '') {
		alert("Campo CNPJ não pode ser vazio!!");
		return false;
	}
	return true;
}

function val() {
	var escreva

	if (document.getElementById('escolha').value == 'cpf') {

		document.getElementById('painel').innerHTML = "<td>CPF:</td><td><input type='text' name='CPF' id='fisica' placeholder='Numero CPF' title='Digite o numero do CPF' required  onkeypress='return valCPF(event,this);return false;'" + "onblur='if(consistenciaCPF(this.value)) this.select();'" + "maxlength='14'/></td>" + "</tr><tr><td><input type='submit' name='busca' value='pesquisar'  class='botao'/></td>";

	} else if (document.getElementById('escolha').value == 'cnpj') {

		escreva = document.getElementById('painel').innerHTML = "<tr>" + "<td>CNPJ:</td><td><input type='text' id='juridica' name='cnpj'  onkeypress='return valCNPJ(event,this);return false;'  placeholder='Numero CNPJ' maxlength='18' required /></td>" + "</tr><tr><td><input type='submit' name='busca' value='pesquisar'  class='botao'/></td>" + "</tr> ";
		return escreva;
	} else if (document.getElementById('escolha').value == 'telefone') {

		escreva = document.getElementById('painel').innerHTML = "<tr>" + "<td>Telefone:</td><td><input type='text' name='telefone'  onkeypress='return valPHONE(event,this);return false;'  maxlength='13' placeholder='Numero Telefone'required/></td>" + "</tr></tr><tr><td><input type='submit' name='busca' value='pesquisar' class='botao'/></td>" + "</tr> ";
		return escreva;
	}
}

function inputs() {
	var campos;
	if (document.getElementById('pessoa').value == 'f') {
		/*    campos=document.getElementById('area').innerHTML=

		 "<span >CPF:<br/><input type='text' name='cpf'   id='fisica' onkeypress='return valCPF(event,this);return false;' placeholder='Numero CPF' maxlength='14'  /></span>"+
		 "<span>Data Nascimento:<br/><input type='text'    name='nasc'  id='nasc'   placeholder='Data de Nascimento'  /></span>" ;
		 */

		document.getElementById('fisico1').style.display = "block";
		document.getElementById('fisico2').style.display = "block";
		document.getElementById('fisico3').style.display = "block";
		document.getElementById('juridico1').style.display = "none";
		document.getElementById('juridico2').style.display = "none";
		document.getElementById('juridico3').style.display = "none"

	} else if (document.getElementById('pessoa').value == 'j') {
		/* campos=document.getElementById('area').innerHTML="Cnpj:"+
		 "<input type='text' name='cnpj' id='juridica'  onkeypress='return valCNPJ(event,this);return false;'  placeholder='Numero CNPJ' maxlength='18' />"+

		 "Razão Social:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='social' /><br/>" +
		 "Responsavel:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='resp' /><br/>";
		 */
		document.getElementById('juridico1').style.display = "block";
		document.getElementById('juridico2').style.display = "block";
		document.getElementById('juridico3').style.display = "block"
		document.getElementById('fisico1').style.display = "none";
		document.getElementById('fisico2').style.display = "none";
		document.getElementById('fisico3').style.display = "none";

	}

}

function formatamoney(c) {
	var t = this;
	if (c == undefined)
		c = 2;
	var p, d = (t=t.split("."))[1].substr(0, c);
	for ( p = ( t = t[0]).length; (p -= 3) >= 1; ) {
		t = t.substr(0, p) + "." + t.substr(p);
	}
	return t + "." + d + Array(c + 1 - d.length).join(0);
}

String.prototype.formatCurrency = formatamoney

function demaskvalue(valor, currency) {
	/*
	 * Se currency é false, retorna o valor sem apenas com os números. Se é true, os dois últimos caracteres são considerados as
	 * casas decimais
	 */
	var val2 = '';
	var strCheck = '0123456789';
	var len = valor.length;
	if (len == 0) {
		return 0.00;
	}

	if (currency == true) {
		/* Elimina os zeros à esquerda
		 * a variável  <i> passa a ser a localização do primeiro caractere após os zeros e
		 * val2 contém os caracteres (descontando os zeros à esquerda)
		 */

		for (var i = 0; i < len; i++)
			if ((valor.charAt(i) != '0') && (valor.charAt(i) != ','))
				break;

		for (; i < len; i++) {
			if (strCheck.indexOf(valor.charAt(i)) != -1)
				val2 += valor.charAt(i);
		}

		if (val2.length == 0)
			return "0.00";
		if (val2.length == 1)
			return "0.0" + val2;
		if (val2.length == 2)
			return "0." + val2;

		var parte1 = val2.substring(0, val2.length - 2);
		var parte2 = val2.substring(val2.length - 2);
		var returnvalue = parte1 + "." + parte2;
		return returnvalue;

	} else {
		/* currency é false: retornamos os valores COM os zeros à esquerda,
		 * sem considerar os últimos 2 algarismos como casas decimais
		 */
		val3 = "";
		for (var k = 0; k < len; k++) {
			if (strCheck.indexOf(valor.charAt(k)) != -1)
				val3 += valor.charAt(k);
		}
		return val3;
	}
}

function reais(obj, event) {

	var whichCode = (window.Event) ? event.which : event.keyCode;
	/*
	 Executa a formatação após o backspace nos navegadores !document.all
	 */
	if (whichCode == 8 && !documentall) {
		/*
		 Previne a ação padrão nos navegadores
		 */
		if (event.preventDefault) {//standart browsers
			event.preventDefault();
		} else {// internet explorer
			event.returnValue = false;
		}
		var valor = obj.value;
		var x = valor.substring(0, valor.length - 1);
		obj.value = demaskvalue(x, true).formatCurrency();
		return false;
	}
	/*
	 Executa o Formata Reais e faz o format currency novamente após o backspace
	 */
	FormataReais(obj, '.', ',', event);
}// end reais

function backspace(obj, event) {
	/*
	 Essa função basicamente altera o  backspace nos input com máscara reais para os navegadores IE e opera.
	 O IE não detecta o keycode 8 no evento keypress, por isso, tratamos no keydown.
	 Como o opera suporta o infame document.all, tratamos dele na mesma parte do código.
	 */

	var whichCode = (window.Event) ? event.which : event.keyCode;
	if (whichCode == 8 && documentall) {
		var valor = obj.value;
		var x = valor.substring(0, valor.length - 1);
		var y = demaskvalue(x, true).formatCurrency();

		obj.value = "";
		//necessário para o opera
		obj.value += y;

		if (event.preventDefault) {//standart browsers
			event.preventDefault();
		} else {// internet explorer
			event.returnValue = false;
		}
		return false;

	}// end if
}// end backspace

function FormataReais(fld, milSep, decSep, e) {
	var sep = 0;
	var key = '';
	var i = j = 0;
	var len = len2 = 0;
	var strCheck = '0123456789';
	var aux = aux2 = '';
	var whichCode = (window.Event) ? e.which : e.keyCode;

	//if (whichCode == 8 ) return true; //backspace - estamos tratando disso em outra função no keydown
	if (whichCode == 0)
		return true;
	if (whichCode == 9)
		return true;
	//tecla tab
	if (whichCode == 13)
		return true;
	//tecla enter
	if (whichCode == 16)
		return true;
	//shift internet explorer
	if (whichCode == 17)
		return true;
	//control no internet explorer
	if (whichCode == 27)
		return true;
	//tecla esc
	if (whichCode == 34)
		return true;
	//tecla end
	if (whichCode == 35)
		return true;
	//tecla end
	if (whichCode == 36)
		return true;
	//tecla home

	/*
	 O trecho abaixo previne a ação padrão nos navegadores. Não estamos inserindo o caractere normalmente, mas via script
	 */

	if (e.preventDefault) {//standart browsers
		e.preventDefault()
	} else {// internet explorer
		e.returnValue = false
	}

	var key = String.fromCharCode(whichCode);
	// Valor para o código da Chave
	if (strCheck.indexOf(key) == -1)
		return false;
	// Chave inválida

	/*
	 Concatenamos ao value o keycode de key, se esse for um número
	 */
	fld.value += key;

	var len = fld.value.length;
	var bodeaux = demaskvalue(fld.value, true).formatCurrency();
	fld.value = bodeaux;

	/*
	 Essa parte da função tão somente move o cursor para o final no opera. Atualmente não existe como movê-lo no konqueror.
	 */
	if (fld.createTextRange) {
		var range = fld.createTextRange();
		range.collapse(false);
		range.select();
	} else if (fld.setSelectionRange) {
		fld.focus();
		var length = fld.value.length;
		fld.setSelectionRange(length, length);
	}
	return false;

}

/*permite somente valores numericos*/
function valCPF(e, campo) {

	var tecla = (window.event) ? event.keyCode : e.which;
	if ((tecla > 47 && tecla < 58 )) {
		mascara(campo, '###.###.###-##');
		return true;
	} else {
		if (tecla != 8)
			return false;
		else
			return true;
	}
}

/*permite somente valores numericos*/

function valPHONE(e, campo) {
	var tecla = (window.event) ? event.keyCode : e.which;
	if ((tecla > 47 && tecla < 58 )) {
		mascara(campo, '(##)####-####');
		return true;
	} else {
		if (tecla != 8)
			return false;
		else
			return true;
	}
}

/*permite somente valores numericos*/
function valCEP(e, campo) {
	var tecla = (window.event) ? event.keyCode : e.which;
	if ((tecla > 47 && tecla < 58 )) {
		mascara(campo, '#####-###');
		return true;
	} else {
		if (tecla != 8)
			return false;
		else
			return true;
	}
}

function valCNPJ(e, campo) {

	var tecla = (window.event) ? event.keyCode : e.which;
	if ((tecla > 47 && tecla < 58 )) {
		mascara(campo, '##.###.###/####-##');
		return true;
	} else {
		if (tecla != 8)
			return false;
		else
			return true;
	}
}

function valCNPJ(e, campo) {

	var tecla = (window.event) ? event.keyCode : e.which;
	if ((tecla > 47 && tecla < 58 )) {
		mascara(campo, '##.###.###/####-##');
		return true;
	} else {
		if (tecla != 8)
			return false;
		else
			return true;
	}
}

function valHora(e, campo) {

	var tecla = (window.event) ? event.keyCode : e.which;
	if ((tecla > 47 && tecla < 58 )) {
		mascara(campo, '##:##:##');
		return true;
	} else {
		if (tecla != 8)
			return false;
		else
			return true;
	}
}

/*cria a mascara*/
function mascara(src, mask) {
	var i = src.value.length;
	var saida = mask.substring(1, 2);
	var texto = mask.substring(i);
	if (texto.substring(0, 1) != saida) {
		src.value += texto.substring(0, 1);
	}
}

/*consistencia se o valor do CPF e um valor valido
 seguindo os criterios da Receita Federal do territorio nacional*/
function consistenciaCPF(campo) {

	cpf = campo.replace(/\./g, '').replace(/\-/g, '');
	erro = new String;
	if (cpf.length < 11)
		erro += "Sao necessarios 11 digitos para verificacao do CPF! \n\n";
	var nonNumbers = /\D/;
	if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999") {
		erro += "Numero de CPF invalido!"
	}
	var a = [];
	var b = new Number;
	var c = 11;
	for ( i = 0; i < 11; i++) {
		a[i] = cpf.charAt(i);
		if (i < 9)
			b += (a[i] * --c);
	}
	if (( x = b % 11) < 2) {
		a[9] = 0
	} else {
		a[9] = 11 - x
	}
	b = 0;
	c = 11;
	for ( y = 0; y < 10; y++)
		b += (a[y] * c--);
	if (( x = b % 11) < 2) {
		a[10] = 0;
	} else {
		a[10] = 11 - x;
	}
	if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10])) {
		erro += "Digito verificador com problema!";
	}
	if (erro.length > 0) {
		alert(erro);
		return true;
	}
	return false;
}

//FUNCAO EXIBIR MENSAGEM ANTES DE EXCLUIR O REGISTRO
function exclua(id, opcao) {
	var resposta = confirm('Deseja realmente excluir esse registro?')
	if (resposta) {
		location.href = '?pg=' + opcao + '&registro=' + id;
	} else {
		alert('A ação foi abortada!')
	}
}

function escondeAparece(opcao) {
	if (opcao == "dia") {
		document.getElementById('dataDia').style.display = "block";
		document.getElementById('dataMes').style.display = "none";
		document.getElementById('dataAno').style.display = "none";
	} else if (opcao == "mes") {
		document.getElementById('dataMes').style.display = "block";
		document.getElementById('dataDia').style.display = "none";
		document.getElementById('dataAno').style.display = "none";
	} else if (opcao == "ano") {
		document.getElementById('dataAno').style.display = "block";
		document.getElementById('dataDia').style.display = "none";
		document.getElementById('dataMes').style.display = "none";
	}

}

function mostraOpcaoGrafico() {
	document.getElementById("opcaoGrafico").style.display = "block";

}

function escondeOpcaoGrafico() {
	document.getElementById("opcaoGrafico").style.display = "none";
	document.getElementById("opcaoGrafico").value = "";
}

//ativa campo de cpf ou cnpj
function ativaCampo(opcao) {

	if (opcao == 'cpf') {
		document.getElementById('passou').value = "cpf";
		document.getElementById('cpf').style.display = 'block';
		document.getElementById('cnpj').style.display = 'none';
	} else if (opcao == 'cnpj') {
		document.getElementById('passou').value = "cnpj";
		document.getElementById('cnpj').style.display = 'block';
		document.getElementById('cpf').style.display = 'none';
	}

}

function verificaStatusVisita(val) {
	var status = "sem valor"
	var z = document.getElementById(val)
	var x
	var AC = document.getElementById("ac")
	var MI = document.getElementById("mi")
	var N = document.getElementById("nao")
	var PP = document.getElementById("pp")
	var RP = document.getElementById("rp")
	var V = document.getElementById("v")
	var porc = document.getElementById("porcentagem")

	if (parseInt(porc.value) > 100) {
		x = parseInt(porc.value) - 25
		document.getElementById("porcentagem").value = x + "%"
	}
	if (porc.value == "" || parseInt(porc.value) >= 0 && parseInt(porc.value) < 101 && V.checked == false) {
		if (z.checked == false) {
			x = parseInt(porc.value) - 15
			document.getElementById("porcentagem").value = x + "%"

		} else if (z.checked == true) {
			if (porc.value == "") {
				document.getElementById("porcentagem").value = 15 + "%"
			} else {
				if (parseInt(porc.value) > 100) {
					x = parseInt(porc.value) - 25
				} else {
					x = parseInt(porc.value) + 15
				}

				document.getElementById("porcentagem").value = x + "%"
			}
		}

		if (V.checked == false && AC.checked == false && MI.checked == false && N.checked == false && PP.checked == false && RP.checked == false) {

			document.getElementById("porcentagem").value = ""
				document.getElementById("verStatus").value = ""
		}

	}

	if (V.checked == true) {

		document.getElementById("porcentagem").value = 100 + "%"
		document.getElementById("verStatus").value = "Fechado"
		v=0
	}
	if (parseInt(porc.value)>=0 && parseInt(porc.value) <= 50) {
		document.getElementById("verStatus").style.color = "red";
		document.getElementById("verStatus").value = "morno"
		v = 2
	} /*else if (parseInt(porc.value) > 30 && parseInt(porc.value) <= 60) {
		document.getElementById("verStatus").style.color = "red";
		document.getElementById("verStatus").value = "morno"
		v = 2
	}*/ else if (parseInt(porc.value) > 50 && parseInt(porc.value) < 98) {
		document.getElementById("verStatus").style.color = "red";
		document.getElementById("verStatus").value = "Quente"
		v = 1
	}

	document.getElementById("status").value = v;
}
function habilitaDesabilita(valor){
        var pessoa
        
        pessoa=document.getElementById("pessoa");
              
        if(pessoa.value=="f"){   
         
          document.getElementById("tbFisica").style.display="block";
          document.getElementById("tbJuridica").style.display="none";

            
        }else if(pessoa.value=="j"){
            
          document.getElementById("tbJuridica").style.display="block";
          document.getElementById("tbFisica").style.display="none";    
        }
   }
function habilitaCampo(){
    if(document.form.dataAdiamento.disabled==false){
       document.form.dataAdiamento.disabled=true 
      // document.getElementById('dataAdiamento').style.background="yellow";
    }
    
    
}
   function desabledEnabled(){
       if(document.getElementById("status").value==="0"){
            document.getElementById("contrato").style.display="block";
       }else{
            document.getElementById("contrato").style.display="none";
       }
       
   }
   function MostraDiv(){
      if(document.getElementById("conteudo").style.display==="block"){
          document.getElementById("conteudo").style.display="none";
          document.getElementById("conteudo2").style.display="block";
      }else{
          document.getElementById("conteudo").style.display="block";
           document.getElementById("conteudo2").style.display="none";
      } 
   }
   
