<?PHP
//write variables from TiDe
$currentversion = $_POST['version'];
$name = $_POST['name'];
$mid = $_POST['mid'];
$limit = $_POST['limit'];
$guid = $_POST['guid'];
$os = $_POST['os'];
$ostype = $_POST['ostype'];

//set path to software-directory
$path = $guid.'/'.$os.'/';

//check os-directory
$newestversion = scandir($path,1);

//the first request seems to come without version number :( so we 'lie', that the currentversion is the newest
($currentversion == '')? $currentversion = $newestversion : $currentversion = $currentversion;

//read manifest
$manifest .= '"manifest":"';

//save manifest in array
$manifestfile=file($path.$newestversion[0].'/manifest');
        {
        unset($lines,$content);
        for ($i=0;$i<count($manifestfile)+1;$i++)
                {
                $lines .="$manifestfile[$i]";
                }
        $content=explode("\n",$lines);
        }
        for ($i=0;$i<count($content);$i++)
                {
                if($content[$i]!= '')
                        {
                        $manifest .= $content[$i].'\n';
                        }
                }

//complete manifest
$manifest .='#version:'.$newestversion[0].'"';

//set json
$update_json = '{"success":true,"releases":[{"version":"'. $newestversion[0].'",'.$manifest.',"release_notes":"app:\/\/ CHANGELOG.txt","update_url":"http:\/\/'.$_SERVER['SERVER_NAME'].'\/tiupdate\/'.$guid.'\/'.$os.'\/'.$newestversion[0].'\/ appupdate.zip"}]}';

//write json
echo $update_json;
?> 