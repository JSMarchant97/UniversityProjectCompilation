<?php

    //establish database connection
    $con = mysqli_connect("localhost","jsmarchant97","1Ysfqxtqw2","jsmarcha_SVGProject");

    //return error if connection fails
    if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
    }

    if ($result = mysqli_query($con, 'SELECT word FROM words')) //query pulls all of the dictionary words stored in the database
    {
        while($row = $result->fetch_array() )
        {
            define('SALT','ThisIs-A-Salt123'); //each word is hashed and salted
            $test = md5($row['word'] . SALT);
            if ($result2 = mysqli_query($con, 'SELECT user_id FROM not_so_smart_users WHERE password = "' . $test . '"')) //each of the hashed and salted dictionary words is run against the not smart users database table
            {
                while($row2 = $result2->fetch_array() ) // if there is a match it is echoed to the web page
                {
                    echo $row2['user_id'];
                    echo "<br />";
                }
            }
        }
    }

mysqli_close($con);

?>