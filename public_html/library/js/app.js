(function($) {
	$.get('/counts/getcounts/30/latest', function(data) {
		dataLoaded(data);
	}, 'json');

	var jsonData,
		chartLabels,
		chartData,
		chartOptions;

	extractData = function(data) {
		chartLabels = [];
		chartData = [];
		for(var i = 0; i < jsonData.length; i++) {
			chartLabels.push(jsonData[i].date);
			chartData.push(jsonData[i].count);
		}
		console.log(chartLabels, chartData);
	}

    function genChartOptions(labels, points) {
    	chartOptions = {
			labels : labels,
			datasets : [
				{
					// scaleOverride : true,

					//** Required if scaleOverride is true **
					//Number - The number of steps in a hard coded scale
					// scaleSteps : 1,
					//Number - The value jump in the hard coded scale
					// scaleStepWidth : 1,
					//Number - The scale starting value
					// scaleStartValue : 0,
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : points
				}
			]
	    }
    };

	function dataLoaded(data) {
		jsonData = data;

		extractData(jsonData.reverse());
		genChartOptions(chartLabels, chartData);
		makeChart('chart', chartOptions);
	}

    function makeChart(el, data) {
	    return new Chart(document.getElementById(el).getContext("2d")).Line(data);
    }
})(jQuery)