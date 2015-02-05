<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>ArtsMesh YouTube Events Manager</title>
  <meta name="description" content="ArtsMesh YouTube Events Manager">
  <meta name="author" content="ArtsMesh">

  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
  <link rel="stylesheet" href="/app/event/css/styles.css">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
  <form id="input_form_broadcast" action="/app/event/create-event.php" method="post" class="ajax-form create-broadcast">
  	<fieldset>
		<ul class="form-data">
			<li class="title">
				<input id="broadcast-title" placeholder="Title" type="text" required="required" name="title" autocomplete="off">
			<label for="broadcast-title">Broadcast Title</label>
			</li>
			<li class="start-date">
				<input id="broadcast-startdate" type="text" placeholder="Start Date" required="required" name="startdate" autocomplete="off">
				<label for="broadcast-startdate">Date the Broadcast starts</label>
			</li>
			<li class="broadcast-starttime">
               		<select name="event-starttime" id="broadcast-starttime">
                		<option value="00:00">12:00am</option>
                		<option value="00:30">12:30am</option>
                		<option value="01:00">1:00am</option>
                		<option value="01:30">1:30am</option>
                		<option value="02:00">2:00am</option>
                		<option value="02:30">2:30am</option>
                		<option value="03:00">3:00am</option>
                		<option value="03:30">3:30am</option>
                		<option value="04:00">4:00am</option>
                		<option value="04:30">4:30am</option>
                		<option value="05:00">5:00am</option>
                		<option value="05:30">5:30am</option>
                		<option value="06:00">6:00am</option>
                		<option value="06:30">6:30am</option>
                		<option value="07:00">7:00am</option>
                		<option value="07:30">7:30am</option>
                		<option value="08:00">8:00am</option>
                		<option value="08:30">8:30am</option>
                		<option value="09:00">9:00am</option>
                		<option value="09:30">9:30am</option>
                		<option value="10:00">10:00am</option>
                		<option value="10:30">10:30am</option>
                		<option value="11:00">11:00am</option>
                		<option value="11:30">11:30am</option>
                		<option value="12:00">12:00pm</option>
                		<option value="12:30">12:30pm</option>
                		<option value="13:00">1:00pm</option>
                		<option value="13:30">1:30pm</option>
                		<option value="14:00">2:00pm</option>
                		<option value="14:30">2:30pm</option>
                		<option value="15:00">3:00pm</option>
                		<option value="15:30">3:30pm</option>
                		<option value="16:00">4:00pm</option>
                		<option value="16:30">4:30pm</option>
                		<option value="17:00">5:00pm</option>
                		<option value="17:30">5:30pm</option>
                		<option value="18:00">6:00pm</option>
                		<option value="18:30">6:30pm</option>
                		<option value="19:00">7:00pm</option>
                		<option value="19:30">7:30pm</option>
                		<option value="20:00">8:00pm</option>
                		<option value="20:30">8:30pm</option>
                		<option value="21:00">9:00pm</option>
                		<option value="21:30">9:30pm</option>
                		<option value="22:00">10:00pm</option>
                		<option value="22:30">10:30pm</option>
                		<option value="23:00">11:00pm</option>
               			<option value="23:30">11:30pm</option>
			</select>
              		<label for="broadcast-starttime">Start time</label>
			</li>	
			<li class="end-date">
                                <input id="broadcast-enddate" placeholder="End Date" type="text" required="required" name="enddate" autocomplete="off">
				<label for="broadcast-enddate">Date the Broadcast ends</label>
			</li>
			<li class="end-time">
               		<select name="broadcast-endtime" id="broadcast-endtime">
                		<option value="00:00">12:00am</option>
                                <option value="00:30">12:30am</option>
                                <option value="01:00">1:00am</option>
                                <option value="01:30">1:30am</option>
                                <option value="02:00">2:00am</option>
                                <option value="02:30">2:30am</option>
                                <option value="03:00">3:00am</option>
				<option value="03:30">3:30am</option>
				<option value="04:00">4:00am</option>
                		<option value="04:30">4:30am</option>
                		<option value="05:00">5:00am</option>
                		<option value="05:30">5:30am</option>
                		<option value="06:00">6:00am</option>
                		<option value="06:30">6:30am</option>
                		<option value="07:00">7:00am</option>
                		<option value="07:30">7:30am</option>
                		<option value="08:00">8:00am</option>
                		<option value="08:30">8:30am</option>
                		<option value="09:00">9:00am</option>
                		<option value="09:30">9:30am</option>
                		<option value="10:00">10:00am</option>
                		<option value="10:30">10:30am</option>
                		<option value="11:00">11:00am</option>
                		<option value="11:30">11:30am</option>
                		<option value="12:00">12:00pm</option>
                		<option value="12:30">12:30pm</option>
                		<option value="13:00">1:00pm</option>
                		<option value="13:30">1:30pm</option>
                		<option value="14:00">2:00pm</option>
                		<option value="14:30">2:30pm</option>
                		<option value="15:00">3:00pm</option>
                		<option value="15:30">3:30pm</option>
                		<option value="16:00">4:00pm</option>
                		<option value="16:30">4:30pm</option>
                		<option value="17:00">5:00pm</option>
                		<option value="17:30">5:30pm</option>
                		<option value="18:00">6:00pm</option>
                		<option value="18:30">6:30pm</option>
                		<option value="19:00">7:00pm</option>
                		<option value="19:30">7:30pm</option>
                		<option value="20:00">8:00pm</option>
                		<option value="20:30">8:30pm</option>
                		<option value="21:00">9:00pm</option>
                		<option value="21:30">9:30pm</option>
                		<option value="22:00">10:00pm</option>
                		<option value="22:30">10:30pm</option>
                		<option value="23:00">11:00pm</option>
                		<option value="23:30">11:30pm</option>
               		</select>
              		<label for="broadcast-endtime">End time</label>
			</li>
			<li class="description">
				<textarea id="broadcast-description" rows="2" autocomplete="off" name="description" placeholder="Enter a description..."></textarea>
				<label for="broadcast-description">Broadcast Description</label>
			</li>
			<li class="private">
				<input id="broadcast-private" type="checkbox" name="private" value="TRUE" checked="checked">
				<label for="broadcast-private">Private</label>
			</li>
		</ul>
		<input id="broadcast-submit" class="submit" type="submit" title="" value="Create" name="submit">
	</fieldset>
  </form>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="/app/event/js/moment-with-locales.js"></script>
  <script src="/app/event/js/jstz-1.0.4.min.js"></script>
  <script src="/app/event/js/scripts.js"></script>
</body>
</html>
