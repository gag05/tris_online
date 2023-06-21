<?php
    
    $json_post = json_encode($_POST);

    /*echo $json_post;*/

    $output=null;
    $retval=null;
    $shell = exec("/usr/local/bin/python3 /Applications/XAMPP/xamppfiles/htdocs/tris/alg_tris_bot.py '".$json_post."'", $output, $retval);
    /*echo "Returned with status $retval and output:\n";*/
    echo $output[0];

?>