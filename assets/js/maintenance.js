Date.prototype.formatDate = function (format = 'DD/MM/YYYY'){
	var dd = this.getDate();

	var mm = this.getMonth()+1; 
	var yyyy = this.getFullYear();
	if(dd<10) 
	{
	    dd='0'+dd;
	} 

	if(mm<10) 
	{
	    mm='0'+mm;
	}

	if(format == 'MM-DD-YYYY'){
		return strDate = mm+'-'+dd+'-'+yyyy;
	}else if(format == 'MM/DD/YYYY'){
		return strDate = mm+'/'+dd+'/'+yyyy;
	}else if(format == 'DD-MM-YYYY'){
		return strDate = dd+'-'+mm+'-'+yyyy;
	}else if(format == 'YYYY-MM-DD'){
		return strDate = yyyy+'-'+mm+'-'+dd;
	}else if(format == 'YYYY/MM/DD'){
		return strDate = yyyy+'/'+mm+'/'+dd;
	}else{
		return dd+'/'+mm+'/'+yyyy;
	}
};

/*
	To add active the sidebar
	Milan Soni
*/

$.fn.activeSidebar = function(el_class){
	//console.log($(el_class).closest("ul"));
	if($(el_class).closest('.nav .nav-list').is("ul")){
		$(el_class).addClass('active');
	}else{
		$(el_class).addClass('active').parents('li').addClass('active open');
	}
}