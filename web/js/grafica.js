var i=0;
$('input[name^=\"myChart[]\"]').each(function()
{
	grafica($('#nameContainer_' + i).val(), $('#myChart_' + i).val(), $('#tipo_' + i).val(), $('#mes_' + i).val(), $('#valorE_' + i).val(), $('#valorR_' + i).val());
	i++;
});
     
function grafica(id, name, tipo, mes, valorExamen, valorReferencia) 
{
	var TGO = ['rgba(75, 192, 192, 0.6)', 'rgba(75, 192, 192, 0.9)'];
	var TGP = ['rgb(255, 99, 10, 0.2)',  'rgb(255, 99, 132, 0.9)'];
	var COL = ['rgba(255, 159, 64, 0.6)', 'rgba(255, 159, 64, 0.9)'];
	var TRI = ['rgba(54, 162, 235, 0.6)', 'rgba(54, 162, 235, 0.9)'];
	
	if(tipo == 'TGO') color = TGO;
	if(tipo == 'TGP') color = TGP;
	if(tipo == 'Colesterol') color = COL;
	if(tipo == 'Triglicéridos') color = TRI;
	
	var valorM = JSON.parse(mes);
	var valorE = JSON.parse(valorExamen);
	var valorR = JSON.parse(valorReferencia);
	var data=[];
	
	if(valorE.length)
	{
		for (var i=0; i < valorE.length; i++) {
			var datas={
	            y: parseInt(valorE[i]),
	            dataLabels: {
	                className: 'highlight',
	                format:  valorE[i] + "-" + valorR[i]
	            }
	        }
			data[i] = datas;      
		};
	}	
	
	Highcharts.chart(id, {
		colors: ['#FFFFFF'],
	    chart: {
	        type: 'line',
	        backgroundColor: {
		       	linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
		       	stops: [
		      		[0, color[1]],
		            [1, '#8d4654']
		    	]
			},
	    },
	    title: {
	        text: name,
	        style: {
            	color: '#FFFFFF'
         	}
	    },
	    xAxis: {
	        categories: valorM,
	        labels: {
	         	style: {
	            	color: '#FFFFFF'
	         	}
	      	}
	    },
	    yAxis: {
	        title: {
	            text: 'Valor del Examen',
		      	style: {
		         	color: '#FFFFFF'
		    	}
	        },
	        labels: {
	      		style: {
	            	color: '#FFFFFF'
	         	}
	      	}
	    },
	    plotOptions: {
	        line: {
	            dataLabels: {
	                enabled: true
	            },
	            enableMouseTracking: true,
	            series: {
		      		shadow: true
		      	},
		      	candlestick: {
		         	lineColor: '#FFFFFF'
		      	},
		      	map: {
		         	shadow: false
		      	}
	        }
	    },
	    legend: {
	      	itemStyle: {
	         	color: '#FFFFFF'
	      	},
	      	itemHoverStyle: {
	         	color: '#FFF'
	      	},
	      	itemHiddenStyle: {
	  			color: '#FFFFFF'
			}
	   	},
	    tooltip: {
			formatter: function() {
				return 'Valor del Examen: ' + this.y;
		    }
		},
		series: [{
	        name: 'Gráfica - ' + tipo,
	        data: data,
	    }],
	});
}

$('#menu_toggle').on('click', function(){
	
	var widht;
	if($('body').hasClass('nav-md'))
        widht = 230;
    else
        widht = 300;

	var i=0; 
	$('input[name^=\"myChart[]\"]').each(function()
	{
		$('#containerR_' + i).css('width', widht + 'px');
		i++;
	});
});
