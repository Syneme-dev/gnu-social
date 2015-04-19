<?php 
    $video_id = $_GET['id'];
?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>ArtsMesh YouTube Events Manager</title>
  <meta name="description" content="ArtsMesh YouTube Events Manager">
  <meta name="author" content="ArtsMesh">

  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />

  <link rel="stylesheet" href="/theme/dark/css/display.css?version=1.1.1-alpha">
  <link rel="stylesheet" href="css/styles.css?v=1.0">


  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body class="success page">
  <div id="wrap">

  <div id="core">
  	<div id="aside_primary_wrapper">
		<div id="content_wrapper">
			
			<div id="content">
				<div id="content_inner">
				<!-- <h1>Sucess!</h1> -->
				<?php if ( !is_null($video_id) ): ?>
					<?php $youtube_id = $_GET['id']; ?>
					<iframe class="event-title entry-title summary" frameborder="0" allowfullscreen="" border="0" src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>"></iframe>
				<?php endif; ?>
				<?php if ( !is_null($video_id) ): ?>
				<?php $video_url = 'https://www.youtube.com/embed/' . $video_id ?>
				<div class="content-info">
					<form>
					<ul>
						<li>
							<input id="video-url" value="<?php echo $video_url ?>">
						</li>
						<li>
							<label for="video-url">YouTube URL</label>
						</li>
					</ul>
					</form>
				</div>
				<?php endif; ?>
				<div class="content-nav">
					<a class="link-btn" href="/app/event">Create New Broadcast</a>
				</div>
				</div> <!-- close content_inner -->
			</div>
		</div>
	</div>
  </div>
  </div> <!-- close wrap div -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="/app/event/js/moment-with-locales.js"></script>
  <script src="/app/event/js/jstz-1.0.4.min.js"></script>
  <script src="/app/event/js/scripts.js"></script>
</body>
</html>

