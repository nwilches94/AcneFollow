$(document).ready(function(){
	
	var fechaI = $('#periodo-fechai').val();
	var fechaF = $('#periodo-fechafc').val();
	var fechaA= $('#periodo-fechaa').val();

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
		events: [
			{
				title: 'Ciclo Menstrual',
				start: fechaI,
				end: fechaF
			},
			{
				title: 'Fecha Aproximada de Periodo',
				start: fechaA,
				color: '#FF0000'
			}
		]
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