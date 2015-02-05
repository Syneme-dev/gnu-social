var url = "/app/event/create-event.php";

$(document).ready(function() {

	$(function() {
		$("#broadcast-enddate").datepicker({ dateFormat: "yy-mm-dd" });
		$("#broadcast-startdate").datepicker({ dateFormat: "yy-mm-dd" });
	});
	
	var moment_date = moment();
	var cur_date = moment_date.format("YYYY-MM-DD");

	$('#broadcast-starttime option, #broadcast-endtime option').each(function() {
		var time = $(this).html();
		var cur_datetime = cur_date + " " + time;

		var moment_cur_datetime = moment(cur_datetime, "YYYY-MM-DD hh:mma");
		//console.log($(this).html());

		$(this).attr('value',moment_cur_datetime.format("HH:mm:ss.sZ"));
	});

	/**
	$('#input_form_broadcast').submit(function(e) {
		$.ajax({
           		type: "POST",
           		url: url,
           		data: $("#idForm").serialize(), // serializes the form's elements.
           		success: function(data)
           		{
               			alert(data); // show response from the php script.
           		}
         	});			

		e.preventDefault();
	});
	**/
});
