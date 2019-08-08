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

setInterval(function(){ 
	var url = $('body').data('check_activity');
	$.ajax({
		url: url,
		type: 'get',
		dataType: 'json',
		success: function(result){
			if(!result.redirect_url){
				if(result.start_timer === true){
					var oneMin = 60*1;
					var display = document.querySelector('#timers');
					$("#inactivity_logout").css('display', 'block');
					startTimer(oneMin, display);
				}
			}else{
				window.location.href = result.redirect_url;
			}			
		}
	});
	//$("#inactivity_logout").css('display', 'block');
}, 15000);

function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}