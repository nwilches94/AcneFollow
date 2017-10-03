$(document).ready(function(){
	var fechaI = jQuery.parseJSON($('#periodo-fechai').val());
	var fechaF = jQuery.parseJSON($('#periodo-fechafc').val());
	var fechaA = jQuery.parseJSON($('#periodo-fechaa').val());
	var events = [];
	
	if(fechaI.length)
	{
		var j=0;
		for (var i=0; i < fechaI.length; i++) {
		  	events[j] = 
			  	{
			  		title: 'Ciclo Menstrual',
					start: fechaI[i],
					end: fechaF[i]
				};
			
			j++;		
			events[j] = 	
				{
			  		title: 'Fecha Aproximada de Periodo',
					start: fechaA[i],
					color: '#FF0000'
				};
			j++;
		};
	}
	
	var initialLocaleCode = 'es';
	$('#calendar').fullCalendar({
		header:{
			left: 'prev,next today',
			center: 'title',
			right: 'month,listMonth'
		},
		locale: initialLocaleCode,
		buttonIcons: false, // show the prev/next text
		weekNumbers: true,
		navLinks: true, // can click day/week names to navigate views
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		events: events
	});
	// build the locale selector's options
	$.each($.fullCalendar.locales, function(localeCode){
		$('#locale-selector').append(
			$('<option/>')
				.attr('value', localeCode)
				.prop('selected', localeCode == initialLocaleCode)
				.text(localeCode)
		);
	});
	// when the selected option changes, dynamically change the calendar option
	$('#locale-selector').on('change', function(){
		if(this.value){
			$('#calendar').fullCalendar('option', 'locale', this.value);
		}
	});
});