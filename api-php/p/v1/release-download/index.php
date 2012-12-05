<?php

//uncomment to double-check request variables
//print_r($_REQUEST);

$url = 'http://' . $_SERVER['SERVER_NAME'] . '/ti/files/app-update/win-x86/' . $_REQUEST['version'] . '/appupdate.zip';
header("Location: $url");