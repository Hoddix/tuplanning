	//Pintamos en el html el div con la clase bagro(background) antes del div con la class panel.
	BG = $('.bagro');
	if(BG.length == 0) {
		BG = $('<div class="bagro"/>').insertBefore('.panel');
	}
	//Cuando se hace click en un elemento con el class flop, este cerrara el div que este abierto con el class panel
	$(".flop").live("click",function(){
		var abierto = $('.panel:visible').attr('id');
		//alert(abierto)
		$("#"+abierto).slideUp("slow");
		BG.fadeOut("slow");
	});
	//Cuando se hace click en un elemento con el id flip, este abrira el div que este abrira con el id pulsado
	$("a[flip]").live("click",function(){
		var dato = $(this).attr('flip');
		//alert(dato)
		BG.fadeIn("slow");
		$("#"+dato).slideDown("slow");
	});
	//Cuando se hace click en el background blanco que hemos creado, este cerrara el div que este abierto con el class panel
	$(".bagro").live("click",function(){
		abierto = $('.panel:visible').attr('id');
		//alert(abierto)
		$("#"+abierto).slideUp("slow") 
		BG.fadeOut("slow");
	});
	//Cuando se pulse escape, este cerrara el div que este abierto con el class panel
	$('body').keyup(function() {
		abierto = $('.panel:visible').attr('id');
		//alert(abierto)
		if(e.which===27){ 
			$("#"+abierto).slideUp("slow"); 
			BG.fadeOut("slow"); 
		} 
	});