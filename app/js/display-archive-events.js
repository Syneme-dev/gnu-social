var archive_events = [];
var req_url = "/api/allevent.json";

var display_events = function(events, num) {
	var i = 0;
	console.log(events);
	$.each( events, function(event, event_data) {
		//console.log(event_data[event]["url"]);
		if (i < num) {
				var event_url = event_data[event]["url"];
				var event_title = event_data[event]["title"];
				var event_desc = event_data[event]["description"];
				var event_html = '<ul class="event">';
				event_html += '<li class="title">'+ event_title +'</li>';
				event_html += '<li class="youtube"><iframe width="560" height="315" src="'+event_url+'" frameborder="0" allowfullscreen></iframe></li>';
				event_html += '<li class="description">'+ event_desc +'</li>'
				event_html += '</ul>';
		
				$(".main").append(event_html);
		}
		i++
	});
}

var load_events = function(url) {
	//Get json events data
	$.getJSON(url, function(data) {
		var archive_event = [];
		$.each( data, function(key, val) {
			console.log(val);
			archive_event.push(val);
			archive_events.push(archive_event);
		});
		
		display_events(archive_events, 9);
	});
}

$(document).ready(function() {
	
	load_events(req_url);
});
