<script type="text/javascript">
	$(document).ready(function() {

  		$( "#from" ).datepicker({
		    altField: "#alternate",
		    altFormat: "DD, d MM, yy",
		    minDate: new Date(),
		    maxDate: "+60D",
		    onSelect: function(selected) {
		      $("#to").datepicker("option","minDate", selected);
		      calcDiff();
   			 }
  		});

	  	$( "#to" ).datepicker({

		    altField: "#alternate1",
		    altFormat: "DD, d MM, yy",
		    minDate: new Date( (new Date()).getTime() + 86400000 ),
		    maxDate:"+60D",
		    onSelect: function(selected) {
		      $("#from").datepicker("option","maxDate", selected);
		      calcDiff();
	    	}
	  	});

  		function calcDiff() {

		    var date1 = $('#from').datepicker('getDate');
		    var date2 = $('#to').datepicker('getDate');
		    var diff = 0;
		    if (date1 && date2) {
		      diff = Math.floor((date2.getTime() - date1.getTime()) / 86400000); 
		    }
		    $('#calculated').val(diff);
  		}
	});

</script>