<?php 
	function truncate($string, $length, $dots = "...") {
    		return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
	}

	function url_base(){
  		return sprintf(
    			"%s://%s",
    			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'http' : 'http',
    		$_SERVER['SERVER_NAME']
    		//$_SERVER['REQUEST_URI']
  		);
	}

	function show_navigation($cur_page, $results_per_page, $total_results) {
		$nav_html = "";
		
		$total_pages = floor($total_results / $results_per_page) + 1;

		$nav_html .= '<ul id="pagination" class="nav">';
		if ($cur_page <= $total_pages && $cur_page > 1):
			$nav_html .= '<li class="nav_prev">
           		<a rel="prev" href="/app/archive-events.php?page='. ($cur_page -1).'">After</a>
          		</li>';
		endif;
		if ($cur_page < $total_pages):
			$nav_html .= '<li class="nav_next">
          	 	<a rel="next" href="/app/archive-events.php?page='.($cur_page +1).'">Before</a>
          		</li>';
		endif;
         		'</ul>"';
		return $nav_html;
	}

	$url = url_base() . "/api/allevent.json";

	$page = htmlspecialchars($_GET["page"]);
	if ( !isset($page) || $page <= 1) { $page = 1; }
	$num_results = 9;
	$offset = ($page - 1) * $num_results;
	$result_start = $offset;
	$result_end = $offset + $num_results;

        $content = file_get_contents($url);
	$content = preg_replace('/\\\u([0-9a-z]{4})/', '&#x$1;', $content);	

        $json = json_decode($content, true);

        $events_html = "";
?>

<html>
	<head>
		<title>Archive Events List</title>
		<link rel="shortcut icon" href="/favicon.ico"/>
  		<link rel="stylesheet" type="text/css" href="/theme/base/css/display.css?version=1.1.1-alpha" media="screen, projection, tv, print"/>
  		<link rel="stylesheet" type="text/css" href="/theme/dark/css/display.css?version=1.1.1-alpha" media="screen, projection, tv, print"/>
		<link rel="stylesheet" type="text/css" href="/app/css/style.css" media="screen, projection, tv, print"/>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" ></script>
		<script src="/app/js/grids.min.js"></script>
		<script src="/app/js/scripts.js"></script>
	</head>
	<body>
		<div class="main">
	<?php
		$events_html = "";	
	
		$i = 0;
		foreach($json as $event) {
			if($i < $result_end && $i >= $result_start) {
				$event_url = $event["url"];
                                $event_title = $event["title"];
                                $event_start = strtotime($event["start_time"]);
				$event_end = strtotime($event["end_time"]);
				$event_desc = $event["description"];
                                $event_html = '<ul class="event">';
                                        $event_html .= '<li class="title" data-youtube="'. $event_url .'"><h3 class="event-title">' . $event_title . '</h3></li>';
					$event_html .= '<li class="youtube"><iframe width="560" height="315" src="' . $event_url . '" frameborder="0" allowfullscreen></iframe></li>';
                                        $event_html .= '<li class="start-time"><span class="field">Start</span><span class="value">' . date("D, F j Y g:ia",$event_start) . '</span></li>';
					$event_html .= '<li class="start-time"><span class="field">End</span><span class="value">' . date("D, F j Y g:ia",$event_end) . '</span></li>';
					$event_html .= '<li class="location"><span class="field">Location</span><span class="value">' . $event["location"] .'</span></li>';
					$event_html .= '<li class="description">' .  truncate($event_desc, 150) . '</li>';
				$event_html .= '</ul>';	
	
				$events_html .= $event_html;
			}
			$i++;	
		}
		print($events_html);

		print(show_navigation($page, $num_results, count($json)));
	?>
		</div> <!-- close main -->	
	</body>
</html>
