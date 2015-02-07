<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

$redirect_success = FALSE;
$htmlBody = "";

// Call set_include_path() as needed to point to your client library.
//require_once('Google/test.php');
require_once('GoogleClientApi/src/Google/Client.php');
require_once('GoogleClientApi/src/Google/Service/YouTube.php');
session_start();

/* Grab variables from the Event Form */
$broadcast_title;
$broadcast_start;
$broadcast_end;
$broadcast_description;
$broadcast_private;

if (isset($_POST['title'])) {
	$broadcast_title = $_POST['title'];
}
if (isset($_POST['startdate']) && isset($_POST['event-starttime']) ) {
	$broadcast_start = $_POST['startdate'] . 'T' . $_POST['event-starttime'];
}
if (isset($_POST['enddate']) && isset($_POST['broadcast-endtime']) ) {
        $broadcast_end = $_POST['enddate'] . 'T' . $_POST['broadcast-endtime'];
}
if (isset($_POST['description'])) {
	$broadcast_description = $_POST['description'];
	$broadcast_description = filter_var($broadcast_description, FILTER_SANITIZE_STRING);
	$broadcast_description = htmlspecialchars_decode($broadcast_description);
}
if (isset($_POST['private'])) {
	$broadcast_private = 'private';
} else {
	$broadcast_private = 'public';
}
if (isset($_GET['state'])) {
	$params_json = base64_decode($_GET['state']);
	$params = json_decode($params_json, TRUE);

	$broadcast_title = $params['title'];
	$broadcast_start = $params['startdate'];
	$broadcast_end = $params['enddate'];
	$broadcast_description = $params['description'];
	$broadcast_private = $params['private'];
}	


/*
 * You can acquire an OAuth 2.0 client ID and client secret from the
 * Google Developers Console <https://console.developers.google.com/>
 * For more information about using OAuth 2.0 to access Google APIs, please see:
 * <https://developers.google.com/youtube/v3/guides/authentication>
 * Please ensure that you have enabled the YouTube Data API for your project.
 */
$OAUTH2_CLIENT_ID = '511937624102-o9ogpimlece7cha4dclrak3suqnpo7cf.apps.googleusercontent.com';
$OAUTH2_CLIENT_SECRET = 'ch_UPTCgUz-bAfvJehNYdXOZ';

$client = new Google_Client();
$client->setClientId($OAUTH2_CLIENT_ID);
$client->setClientSecret($OAUTH2_CLIENT_SECRET);
$client->setScopes('https://www.googleapis.com/auth/youtube');
$redirect = filter_var('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'],
    FILTER_SANITIZE_URL);
$client->setRedirectUri($redirect);

// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);

if (isset($_GET['code'])) {
  if (strval($_SESSION['state']) !== strval($_GET['state'])) {
    die('The session state did not match.');
  }

  $client->authenticate($_GET['code']);
  $_SESSION['token'] = $client->getAccessToken();
  header('Location: ' . $redirect);
}

if (isset($_SESSION['token'])) {
  $client->setAccessToken($_SESSION['token']);
}

// Check to ensure that the access token was successfully acquired.
if ($client->getAccessToken() && isset($broadcast_title) && isset($broadcast_start) && isset($broadcast_end) && isset($broadcast_private)) {
  try {
    // Create an object for the liveBroadcast resource's snippet. Specify values
    // for the snippet's title, scheduled start time, and scheduled end time.
    $broadcastSnippet = new Google_Service_YouTube_LiveBroadcastSnippet();
    $broadcastSnippet->setTitle($broadcast_title);
    $broadcastSnippet->setScheduledStartTime($broadcast_start);
    $broadcastSnippet->setScheduledEndTime($broadcast_end);
    $broadcastSnippet->setDescription($broadcast_description);

    // Create an object for the liveBroadcast resource's status, and set the
    // broadcast's status to "private".
    $status = new Google_Service_YouTube_LiveBroadcastStatus();
    $status->setPrivacyStatus($broadcast_private);

    // Create the API request that inserts the liveBroadcast resource.
    $broadcastInsert = new Google_Service_YouTube_LiveBroadcast();
    $broadcastInsert->setSnippet($broadcastSnippet);
    $broadcastInsert->setStatus($status);
    $broadcastInsert->setKind('youtube#liveBroadcast');

    // Execute the request and return an object that contains information
    // about the new broadcast.
    $broadcastsResponse = $youtube->liveBroadcasts->insert('snippet,status',
        $broadcastInsert, array());

    // Create an object for the liveStream resource's snippet. Specify a value
    // for the snippet's title.
    $streamSnippet = new Google_Service_YouTube_LiveStreamSnippet();
    $streamSnippet->setTitle('New Stream');

    // Create an object for content distribution network details for the live
    // stream and specify the stream's format and ingestion type.
    $cdn = new Google_Service_YouTube_CdnSettings();
    $cdn->setFormat("1080p");
    $cdn->setIngestionType('rtmp');

    // Create the API request that inserts the liveStream resource.
    $streamInsert = new Google_Service_YouTube_LiveStream();
    $streamInsert->setSnippet($streamSnippet);
    $streamInsert->setCdn($cdn);
    $streamInsert->setKind('youtube#liveStream');

    // Execute the request and return an object that contains information
    // about the new stream.
    $streamsResponse = $youtube->liveStreams->insert('snippet,cdn',
        $streamInsert, array());

    // Bind the broadcast to the live stream.
    $bindBroadcastResponse = $youtube->liveBroadcasts->bind(
        $broadcastsResponse['id'],'id,contentDetails',
        array(
            'streamId' => $streamsResponse['id'],
        ));


    // Redirect to success page (pass variables over, for later use)
    $success_url = 'http://' . $_SERVER['HTTP_HOST'];
    $success_url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $success_url .= '/success.php';
    if ( $streamsResponse['id'] ) {
        $success_url .= "?id=" . $bindBroadcastResponse['id'];
    }

    header('Location: ' . $success_url);


    $htmlBody = "";
    $htmlBody .= "<h3>Added Broadcast</h3><ul>";
    $htmlBody .= sprintf('<li>%s published at %s (%s)</li>',
        $broadcastsResponse['snippet']['title'],
        $broadcastsResponse['snippet']['publishedAt'],
        $broadcastsResponse['id']);
    $htmlBody .= '</ul>';

    $htmlBody .= "<h3>Added Stream</h3><ul>";
    $htmlBody .= sprintf('<li>%s (%s)</li>',
        $streamsResponse['snippet']['title'],
        $streamsResponse['id']);
    $htmlBody .= '</ul>';

    $htmlBody .= "<h3>Bound Broadcast</h3><ul>";
    $htmlBody .= sprintf('<li>Broadcast (%s) was bound to stream (%s).</li>',
        $bindBroadcastResponse['id'],
        $bindBroadcastResponse['contentDetails']['boundStreamId']);
    $htmlBody .= '</ul>';

  } catch (Google_ServiceException $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  } catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
  }

  $_SESSION['token'] = $client->getAccessToken();
} elseif ( $redirect_success ) {
  $success_url = 'http://' . $_SERVER['HTTP_HOST'];
  $success_url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  $success_url .= '/success.php';
  if ( $streamsResponse['id'] ) {
  	$success_url .= "?id=" . $streamsResponse['id'];
  }

  header('Location: ' . $success_url); 
} else {
  // If the user hasn't authorized the app, initiate the OAuth flow
  
  // create an oauth state containing the url variables to retain
  $url_vars_array = array('title' => $broadcast_title, 'startdate' => $broadcast_start, 'enddate' => $broadcast_end, 'description' => $broadcast_description, 'private' => $broadcast_private);
  $url_vars_json = json_encode($url_vars_array);
  $stateString = base64_encode($url_vars_json);

  // $state = mt_rand();
  $client->setState($stateString);
  $_SESSION['state'] = $stateString;

  // Pass URL on to oauth client to authenticate user/account
  $authUrl = $client->createAuthUrl();
  $htmlBody = <<<END
  <h3>Authorization Required</h3>
  <p>You need to authorize access before proceeding.<p>
  <div><a href="$authUrl" class="submit">Authorize</a></div>
END;
}
?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Create a Live YouTube Broadcast</title>
  <meta name="description" content="ArtsMesh YouTube Events Manager">
  <meta name="author" content="ArtsMesh">

  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
  <link rel="stylesheet" href="/app/event/css/styles.css">

  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>

<body>
  <?=$htmlBody?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script src="/app/event/js/moment-with-locales.js"></script>
  <script src="/app/event/js/jstz-1.0.4.min.js"></script>
  <script src="/app/event/js/webshim-1.15.6/js-webshim/minified/polyfiller.js"></script>
  <script src="/app/event/js/scripts.js"></script>
</body>
</html>
