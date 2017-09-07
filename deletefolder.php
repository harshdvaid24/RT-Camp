<?php 
$dir="assets/UserData/";
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
        	if($file!="."&& $file!=".."){
        		$intime=strtotime(str_replace("-", ":",explode("_",$file)[1]));
        		$addminutes_intime=date("h:i",strtotime("+5 minutes",$intime));
        		if($addminutes_intime<=date("h:i")){
        			Delete($dir.$file);
        		}
        	}
        }
        closedir($dh);
    }
}
function Delete($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));
        foreach ($files as $file)
        {
            Delete(realpath($path) . '/' . $file);
        }
        rmdir($path);
    }
    else if (is_file($path) === true)
    {
        unlink($path);
    }
}
?>