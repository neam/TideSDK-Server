<?PHP

/**
 * Personal update service for your 
 */
//uncomment to double-check request variables
//print_r($_REQUEST);
//write variables from TiDe
$currentversion = $_REQUEST['version'];
$name = $_REQUEST['name'];
//$mid = $_REQUEST['mid'];
//$limit = $_REQUEST['limit'];
//$guid = $_REQUEST['guid'];
//$os = $_REQUEST['os'];
//$ostype = $_REQUEST['ostype'];
//prevent handling obviously invalid requests
if (empty($name))
{
	header('HTTP/1.0 400 Bad Request', true, 400);
	echo "Bad request";
	exit(400);
}

//error handler for easier inspection of errors through TideSDK Developer console
set_error_handler(function( $errno, $errstr, $errfile, $errline, array $errcontext ) {
	    $req = $_REQUEST;
	    print_r(compact("errno", "errstr", "errfile", "errline", "req"));
    });

//set path to software-directory
$path = getcwd() . '/' . $name . '/';
$logpath = getcwd() . '/' . $name . '.log';

function dlog($msg, $logpath)
{
	error_log($msg . "\n", 3, $logpath);
}

dlog("Request", $logpath);

//check os-directory
$newestversion = scandir($path, 1);

//the first request seems to come without version number :( so we 'lie', that the currentversion is the newest
if (empty($currentversion))
{
	$currentversion = $newestversion;
}

//read manifest
$manifestfile = file($path . $newestversion[0] . '/manifest');
$manifest = implode("", $manifestfile);

//set json
$release = array(
	"version" => $newestversion[0],
	"manifest" => $manifest,
	"release_notes" => "app://CHANGELOG.txt",
	"url" => 'http://' . $_SERVER['SERVER_NAME'] . '/update-service/' . $path . '/' . $newestversion[0] . '/appupdate.zip',
);
$response = array(
	"success" => true,
	"releases" =>
	array(
		$release
	)
);
$update_json = json_encode($response);

//write json
echo $update_json;
?> 