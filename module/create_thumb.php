<?php

// <img src="create_thumb.php?file=Tux.png">

function resizePicture($file, $max_width, $max_height)
{

    if(!file_exists($file))
        return false;
    
    header('Content-type: image/jpeg');

    $info = getimagesize($file);

    if($info[2] == 1)
    {
        $image = imagecreatefromgif($file);
    }
    elseif($info[2] == 2)
    {
        $image = imagecreatefromjpeg($file);
    }
    elseif($info[2] == 3)
    {
        $image = imagecreatefrompng($file);
    }
    else
    {
            return false;
    }
    
    if ($max_width && ($info[0] < $info[1])) 
    {
        $max_width = ($max_height / $info[1]) * $info[0];
    } 
    else 
    {
        $max_height = ($max_width / $info[0]) * $info[1];
    }

    $imagetc = imagecreatetruecolor($max_width, $max_height);

    imagecopyresampled($imagetc, $image, 0, 0, 0, 0, $max_width, $max_height, 
        	 $info[0], $info[1]);

    imagejpeg($imagetc, null, 100);    
    
}

$width = 112;
$height = 112;


resizePicture($_GET['file'], $width, $height);


?>