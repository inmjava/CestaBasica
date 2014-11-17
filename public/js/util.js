function tiraAcento(text) {
	text = text.replace(new RegExp('[ÃÃ€Ã‚Ãƒ]','gi'), 'A');
	text = text.replace(new RegExp('[Ã‰ÃˆÃŠ]','gi'), 'E');
	text = text.replace(new RegExp('[ÃÃŒÃŽ]','gi'), 'I');
	text = text.replace(new RegExp('[Ã“Ã’Ã”Ã•]','gi'), 'O');
	text = text.replace(new RegExp('[ÃšÃ™Ã›]','gi'), 'U');
	text = text.replace(new RegExp('[Ã‡]','gi'), 'C');
	text = text.replace(new RegExp('[,]','gi'), '');
	return text;
}

function tiraEspaco(text) {
	text = text.replace(new RegExp(' ','gi'), '');
	return text;
}

function tiraAcentoEspaco(text){
	return tiraAcento(tiraEspaco(text));
}

function tiraAcentoEspacoLower(text){
	return tiraAcentoEspaco(text).toLowerCase();
}

function getNowYYYYMMDD(){
	var mydate=new Date();
    var year=mydate.getYear();
    
    if (year < 1000)
        year+=1900;
    
    var day=mydate.getDay();
    var month=mydate.getMonth() + 1;
    var daym=mydate.getDate();
    var hours=mydate.getHours();
    var minutes=mydate.getMinutes();
    
    return year + "-" + month + "-" + daym + "-" + minutes + "-";
}

function excluirUpload(who, fullPath, aparecer){
	if(aparecer){
		$(aparecer).show();
	}
	$(who).remove();
	$.get("/uploadify/delete.php?file=.." + fullPath);
}

function submit(who){
	// inicializando
	who = !who ? 'form': who;
	$.Watermark.HideAll();
	$(who).submit();
}

function submit2(who){
	submit(who);
}

function gerarArray(src, dest){
	$(src).each(function(){
		$(dest).val($(dest).val() + $(this).val() + ";");
	});
}

function gerarLinhaUploadCompleto(divFonte, destinoImagem, nomeArquivo, inputName, desaparecer){
	strParametro = "";
	if(desaparecer){
		$(desaparecer).hide();
		strParametro = '", "' + desaparecer;
	}
	$(divFonte).append("<div class='" + nomeArquivo.split('\.')[0] + "'><a href='/" + destinoImagem + "/" + nomeArquivo + "' target='_blank'>" + nomeArquivo + "</a> - <a href='javascript:excluirUpload(\"." + nomeArquivo.split('\.')[0] + "\", \"/" + destinoImagem + "/" + nomeArquivo + strParametro + "\")'><img src='/uploadify/cancel.png' /> <input type='hidden' name='" + inputName + "' value='" + nomeArquivo + "'/></a><br><br></div>");
}

function msg(msg){
	$('.msg').html(msg);
	$(".msg").corner("5px");
	$('.msg').fadeIn('slow');
	setTimeout(function(){
		$('.msg').fadeOut('slow');
	}, 5000);
}

function erro(msg){
	$('.erro').html(msg);
	$(".erro").corner("5px");
	$('.erro').fadeIn('slow');
	setTimeout(function(){
		$('.erro').fadeOut('slow');
	}, 5000);
}

function abrirPopup(url){
	window.open(url);
}

function validaData(digData){

	var bissexto = 0;
	var data = digData; 
	var tam = data.length;
	
	if (tam == 10) {
		
	        var dia = data.substr(0,2)
	        var mes = data.substr(3,2)
	        var ano = data.substr(6,4)
	        
	        if ((ano > 1900) && (ano < 2100)) {
	                switch (mes) {
	                        case '01': case '03': case '05': case '07': case '08': case '10': case '12':
	                                if  (dia <= 31) {
	                                        return true;
	                                }
	                                break
	                        case '04': case '06': case '09': case '11':
	                                if  (dia <= 30) {
	                                        return true;
	                                }
	                                break
	                        case '02':
	                                /* Validando ano Bissexto / fevereiro / dia */ 
	                                if ((ano % 4 == 0) || (ano % 100 == 0) || (ano % 400 == 0)) { 
	                                        bissexto = 1; 
	                                } 
	                                if ((bissexto == 1) && (dia <= 29)) { 
	                                        return true;                             
	                                } 
	                                if ((bissexto != 1) && (dia <= 28)) { 
	                                        return true; 
	                                }                       
	                                break                                           
	                }
	        }
	}
	return false;
}

function playAudio(filename, id){
	var so = new SWFObject('/tv2/player.swf','mpl','423','0','9');
	
	so.addParam('allowscriptaccess','never');
    so.addParam('allowfullscreen','false');
    so.addVariable('file', '/conteudo-audio/' + filename);
    
    so.addVariable('backcolor', 'f7f7f7');
    so.addVariable('frontcolor', '413d25');
    so.addVariable('lightcolor', '0000');
    so.addVariable('screencolor', '000');
    so.addVariable('autostart', 'true');
    so.addVariable('skin', '/tv2/snel.swf');
	
    so.write(id);
}

function stopAudio(filename, id){
	var so = new SWFObject('/tv2/player.swf','mpl','423','0','9');
	
	so.addParam('allowscriptaccess','never');
    so.addParam('allowfullscreen','false');
    so.addVariable('file', '/conteudo-audio/' + filename);
    
    so.addVariable('backcolor', 'f7f7f7');
    so.addVariable('frontcolor', '413d25');
    so.addVariable('lightcolor', '0000');
    so.addVariable('screencolor', '000');
    so.addVariable('autostart', 'false');
    so.addVariable('skin', '/tv2/snel.swf');
	
    so.write(id);
}

function replaceAll(string, token, newtoken) {
	while (string.indexOf(token) != -1) {
 		string = string.replace(token, newtoken);
	}
	return string;
}

function verificaCpf(cpf) {
	var CPF = cpf
	
	if (cpf == "00000000000" || 
		cpf == "11111111111" || 
		cpf == "22222222222" || 
		cpf == "33333333333" || 
		cpf == "44444444444" || 
		cpf == "55555555555" || 
		cpf == "66666666666" || 
		cpf == "77777777777" || 
		cpf == "88888888888" || 
		cpf == "99999999999") {
		return false;
	}

	// Aqui comeÃ§a a checagem do CPF
	var POSICAO, I, SOMA, DV, DV_INFORMADO;
	var DIGITO = new Array(10);
	DV_INFORMADO = CPF.substr(9, 2); // Retira os dois Ãºltimos dÃ­gitos do nÃºmero informado

	// Desemembra o nÃºmero do CPF na array DIGITO
	for (I=0; I<=8; I++) {
		DIGITO[I] = CPF.substr( I, 1);
	}

	// Calcula o valor do 10Âº dÃ­gito da verificaÃ§Ã£o
	POSICAO = 10;
	SOMA = 0;
	for (I=0; I<=8; I++) {
		SOMA = SOMA + DIGITO[I] * POSICAO;
		POSICAO = POSICAO - 1;
	}
	DIGITO[9] = SOMA % 11;
	if (DIGITO[9] < 2) {
		DIGITO[9] = 0;
	}
	else{
		DIGITO[9] = 11 - DIGITO[9];
	}

	// Calcula o valor do 11Âº dÃ­gito da verificaÃ§Ã£o
	POSICAO = 11;
	SOMA = 0;
	for (I=0; I<=9; I++) {
		SOMA = SOMA + DIGITO[I] * POSICAO;
		POSICAO = POSICAO - 1;
	}
	DIGITO[10] = SOMA % 11;
	if (DIGITO[10] < 2) {
		DIGITO[10] = 0;
	}
	else {
		DIGITO[10] = 11 - DIGITO[10];
	}

	// Verifica se os valores dos dÃ­gitos verificadores conferem
	DV = DIGITO[9] * 10 + DIGITO[10];
	if (DV != DV_INFORMADO) {
		return false;
	}
	return true;
}

function verificaRg(numero){
	/*
	 ##  Igor Carvalho de Escobar
	 ##    www.webtutoriais.com
	 ##   Java Script Developer
	 */
	var numero = numero.split("");
	tamanho = numero.length;
	vetor = new Array(tamanho);

	if(tamanho>=1)
	{
		vetor[0] = parseInt(numero[0]) * 2; 
	}
	if(tamanho>=2){
		vetor[1] = parseInt(numero[1]) * 3; 
	}
	if(tamanho>=3){
		vetor[2] = parseInt(numero[2]) * 4; 
	}
	if(tamanho>=4){
		vetor[3] = parseInt(numero[3]) * 5; 
	}
	if(tamanho>=5){
		vetor[4] = parseInt(numero[4]) * 6; 
	}
	if(tamanho>=6){
		vetor[5] = parseInt(numero[5]) * 7; 
	}
	if(tamanho>=7){
		vetor[6] = parseInt(numero[6]) * 8; 
	}
	if(tamanho>=8){
		vetor[7] = parseInt(numero[7]) * 9; 
	}
	if(tamanho>=9){
		vetor[8] = parseInt(numero[8]) * 100; 
	}

	total = 0;

	if(tamanho>=1){
		total += vetor[0];
	}
	if(tamanho>=2){
		total += vetor[1]; 
	}
	if(tamanho>=3){
		total += vetor[2]; 
	}
	if(tamanho>=4){
		total += vetor[3]; 
	}
	if(tamanho>=5){
		total += vetor[4]; 
	}
	if(tamanho>=6){
		total += vetor[5]; 
	}
	if(tamanho>=7){
		total += vetor[6];
	}
	if(tamanho>=8){
		total += vetor[7]; 
	}
	if(tamanho>=9){
		total += vetor[8]; 
	}

	resto = total % 11;
	if(resto!=0){
		return false;
	}
	return true;
}

function nu(campo){
	var digits="0123456789";
	var campo_temp 
	for (var i=0;i<campo.value.length;i++){
		campo_temp=campo.value.substring(i,i+1) 
		if (digits.indexOf(campo_temp)==-1){
			campo.value = campo.value.substring(0,i);
			break;
		}
	}
}