<?php
$tagarray = json_decode(stripslashes($_POST['data']));

    foreach ($tagarray as $tag)
    {
        echo $tag;
    }
?>