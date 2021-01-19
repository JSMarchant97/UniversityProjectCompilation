<?php
session_start();
    try
    {
        $pdo = new PDO('mysql:host=localhost; dbname=jsmarcha_SVGProject', 'jsmarchant97', '1Ysfqxtqw2');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('SET NAMES "utf8"');
    }
    catch(PDOException $e)
    {
        $output = 'Unable to connect to the database:' . $e->getMessage();
        include 'error.php';
        exit();
    }

    function loadImagesHome() //function loads the images on the home page
    {
        if (isset($_GET['page']))
        {
            $pagecount = $_GET['page'] * 12;
        }
        else
        {
            $pagecount = 12;
        }
        
        try //server attempts to run query
        {
            $result = $GLOBALS['pdo']->query
            ('SELECT i.imageID, a.username, i.albumID, i.imageCode, i.imageName, i.imageDesc, i.altTag, i.postDate, i.ageFilter, i.creativeLicense, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) END) AS Likes, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) END) AS Dislikes,
            (CASE WHEN (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) IS NULL THEN "0" ELSE (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) END) AS commentCount
            FROM image i
            LEFT JOIN Account a ON i.accID = a.accID
            LEFT JOIN Rating r ON i.imageID = r.imageID
            LEFT JOIN Comment c ON i.imageID = c.imageID
            GROUP BY i.imageID
            ORDER BY i.imageID DESC
            LIMIT ' . $pagecount . '
            ');
            
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach($result as $row) //system loops through query results and stores data in an array
        {
            $images[] = array('id' => $row['imageID'], 'user' => $row['username'], 'title' => $row['imageName'], 'code' => $row['imageCode'], 'alt' => $row['altTag'], 'age' => $row['ageFilter']);
        }
        if ($result->rowCount() < $pagecount)
        {
            $_POST['limit'] = true;
        }
        return $images; //system returns the array for use on the home page.
    }

    if (isset($_POST['action']) and $_POST['action'] == "next") //when the next button is clicked on the home page, fire this
    {
        $emailcheck = 0; //variable to keep track of whether the password section should be loaded
        $useremail = $_POST["email"]; //user inputted email to check when they log in
        $result = $pdo->query('SELECT accID, email, username, password FROM Account');
        foreach ($result as $row)
        {
            $emails[] = array('id' => $row['accID'], 'email' => $row['email'], 'user' => $row['username'], 'password' => $row['password']);
        }
        foreach ($emails as $email)
        {
            if (password_verify($useremail, $email['email']) == 1)
            {
                $emailcheck = 1;
                $accuser = $email['user'];
                $_SESSION['username'] = $email['user'];
                $showpassword = '<script> showpassword(); </script>';
            break;
            }
            else
            {
                if(!isset($_SESSION['username']))
                {
                    $errormsg = 'This email is not registered yet';
                }
                
            }
        }
    }

    if (isset($_POST['action']) and $_POST['action'] == "login")
    {
        $userpassword = $_POST["password"];
        $result = $pdo->query('SELECT accID, username, password FROM Account WHERE username = "' . $_SESSION['username'] . '"');
        foreach ($result as $row)
        {
            $pwchecks[] = array('id' => $row['accID'], 'user' => $row['username'], 'password' => $row['password']);
        }
        foreach ($pwchecks as $pwcheck)
        {
            if (password_verify($userpassword, $pwcheck['password']) == 1)
            {
                setcookie('userid' , $pwcheck['id'], time() + (86400 * 30), "/");
                header('Location: http://voltafy.co.uk/jakevolt/');
            break;
            }
            else
            {
                $errormsg = 'password is wrong';
                $emailcheck = 1;
                $accuser = $email['user'];
                $showpassword = '<script> showpassword(); </script>';
            }
        }
    }

    if (isset($_POST['action']) and $_POST['action'] == 'signup')
    {
        $signemail = $_POST['signemail'];
        $signuser = $_POST['user'];
        $signcheck = 0;

        $result = $pdo->query('SELECT email, username FROM Account');
        foreach ($result as $row)
        {
            $suchecks[] = array( 'email' => $row['email'], 'user' => $row['username']);
        }

        $count = count($suchecks);
        $i = 0;

        foreach ($suchecks as $sucheck)
        {
            if ($signuser == $sucheck['user'])
            {
                $errormsg = 'This username is taken';
                $signup = '<script> showsignup(); </script>';
                $signcheck = 1;
            break;
            }
            else if (password_verify($signemail, $sucheck['email']) == 1)
            {
                $errormsg = 'This Email is already in use';
                $signup = '<script> showsignup(); </script>';
                $signcheck = 1;
            break;
            }
            else if($i == $count - 1)
            {
                $signupsuccess = 'account successfully created';
                createUser();
            break;
            }
            $i++;
        }
    }

    function createUser()
    {
        try
        {
            $sql = 'INSERT INTO Account SET
            email = :email,
            username = :username,
            password = :password,
            description = "empty",
            joinDate = NOW()
            ';

            $s = $GLOBALS['pdo']->prepare($sql);
            $s->bindValue(':email', password_hash($_POST['signemail'], PASSWORD_DEFAULT));
            $s->bindValue(':username', $_POST['user']);
            $s->bindValue(':password', password_hash($_POST['pass'], PASSWORD_DEFAULT));
            $s->execute();
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
        $accountid = $GLOBALS['pdo']->lastInsertId();
        try
        {
            $sql = 'INSERT INTO Album SET
            accID = :accid,
            albumName = "Uploads",
            albumDesc = "Default image collection.",
            createdDate = NOW()
            ';

            $s = $GLOBALS['pdo']->prepare($sql);
            $s->bindValue(':accid', $accountid);
            $s->execute();
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
    }

    function loadAlbums()
    {
        try
        {
            $result = $GLOBALS['pdo']->query
            (
                'SELECT albumID, albumName FROM Album WHERE accID = ' . $_COOKIE['userid']
            );
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach ($result as $row)
        {
            $albums[] = array('id' => $row['albumID'], 'name' => $row['albumName']);
        }

        return $albums;
    }

    if (isset($_POST['action']) and $_POST['action'] == 'submitimage')
    {
        $tagarray = json_decode($_POST['tagarray']);
        foreach ($tagarray as $tag)
        {
            $result = $pdo->query('SELECT tagID, tagName FROM Tag WHERE tagName = "' . $tag . '"');
            if ($result->rowCount() == 0)
            {
                try
                {
                $newtag = 'INSERT INTO Tag SET tagName = :tagname';

                $stag = $pdo->prepare($newtag);
                $stag->bindValue(':tagname', $tag);
                $stag->execute();
                }
                catch(PDOException $e) //loads error page if something goes wrong
                {
                    $output = 'Unable to add tag:' . $e->getMessage();
                    include 'error.php';
                    exit();
                }
            }
        }

        $check;

            if ($_POST['inappropriatecheck'] == 1)
            {
                $check = 1;
            }
            else
            {
                $check = 0;
            }
        try //adds image to database
        {
            $sql = 'INSERT INTO image SET
            accID = :id,
            albumID = :album,
            imageCode = :code,
            imageName = :title,
            imageDesc = :desc,
            altTag = :alt,
            postDate = NOW(),
            ageFilter = :age,
            creativeLicense = :cl
            ';

            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_COOKIE['userid']);
            $s->bindValue(':album', $_POST['album']);
            $s->bindValue(':code', $_POST['imgcode']);
            $s->bindValue(':title', $_POST['titletxt']);
            $s->bindValue(':desc', $_POST['imagedesc']);
            $s->bindValue(':alt', $_POST['alttxt']);
            $s->bindValue(':age', $check);
            $s->bindValue(':cl', $_POST['cl']);
            $s->execute();
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        $imageid = $pdo->lastInsertId();

        foreach ($tagarray as $tag)
        {
            $gettagid = $pdo->query('SELECT tagID, tagName FROM Tag WHERE tagName = "' . $tag . '"'); //gets the id of the tag to use on the imagetag insert
            foreach ($gettagid as $tags)
            {
                $imagetagsql = 'INSERT INTO imageTag SET tagID = :tagid, imageID = :imgid';
                
                $simg = $pdo->prepare($imagetagsql);
                $simg->bindValue(':tagid', $tags['tagID']);
                $simg->bindValue(':imgid', $imageid);
                $simg->execute();
            }
        }
        header('Location: http://voltafy.co.uk/jakevolt/viewImage/');
    }

    function loadImage()
    {
        try
        {
            $result = $GLOBALS['pdo']->query('
            SELECT i.imageID, i.accID, a.username, i.albumID, al.albumName, i.imageCode, i.imageName, i.imageDesc, i.altTag, i.postDate, i.creativeLicense, i.ageFilter,
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) END) AS Likes, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) END) AS Dislikes,
            (CASE WHEN (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) IS NULL THEN "0" ELSE (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) END) AS commentCount
            FROM image i
            LEFT JOIN Account a ON i.accID = a.accID
            LEFT JOIN Rating r ON i.imageID = r.imageID
            LEFT JOIN Comment c ON i.imageID = c.imageID
            LEFT JOIN Album al ON i.albumID = al.albumID
            WHERE i.imageID = ' . $_GET['image'] . '
            GROUP BY i.imageID');
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach ($result as $row)
        {
            $imagedata[] = array('id' => $row['imageID'], 'user' => $row['username'], 'accid' => $row['accID'], 'albumID' => $row['albumID'], 'album' => $row['albumName'], 'code' => $row['imageCode'], 'name' => $row['imageName'], 'desc' => $row['imageDesc'], 'alt' => $row['altTag'], 'post' => $row['postDate'], 'cl' => $row['creativeLicense'], 'likes' => $row['Likes'], 'dislikes' => $row['Dislikes'], 'commentcount' => $row['commentCount'], 'age' => $row['ageFilter']);
        }

        return $imagedata;
    }
    
    function checklikes()
    {
        $likecheck = $GLOBALS['pdo']->query('SELECT rID, imageID, accID, Rating FROM Rating WHERE accID = ' . $_COOKIE['userid'] . ' AND imageID = ' . $_GET['image'] . ' AND Rating = 1');
        if($likecheck->rowCount() >= 1)
        {
            $likes = 1;
        }
        else
        {
            $likes = 0;
        }

        return $likes;
    }

    function checkdislikes()
    {
        $likecheck = $GLOBALS['pdo']->query('SELECT rID, imageID, accID, Rating FROM Rating WHERE accID = ' . $_COOKIE['userid'] . ' AND imageID = ' . $_GET['image'] . ' AND Rating = 0');
        if($likecheck->rowCount() >= 1)
        {
            $dislikes = 1;
        }
        else
        {
            $dislikes = 0;
        }

        return $dislikes;
    }

    function likeid()
    {
        $likecheck = $GLOBALS['pdo']->query('SELECT rID, imageID, accID, Rating FROM Rating WHERE accID = ' . $_COOKIE['userid'] . ' AND imageID = ' . $_GET['image'] . ' AND Rating = 1');
        if($likecheck->rowCount() >= 1)
        {
            foreach ($likecheck as $like)
            {
                $likeid[] = array('id' => $like['rID'], 'imageid' => $like['imageID'], 'accid' => $like['accID'], 'rating' => $like['Rating']);
            }

            return $likeid;
        }
        else
        {
            return 'false';
        }
    }

    function dislikeid()
    {
        $dislikecheck = $GLOBALS['pdo']->query('SELECT rID, imageID, accID, Rating FROM Rating WHERE accID = ' . $_COOKIE['userid'] . ' AND imageID = ' . $_GET['image'] . ' AND Rating = 0');
        if($dislikecheck->rowCount() >= 1)
        {
            foreach ($dislikecheck as $dislike)
            {
                $dislikeid[] = array('id' => $dislike['rID'], 'imageid' => $dislike['imageID'], 'accid' => $dislike['accID'], 'rating' => $dislike['Rating']);
            }

            return $dislikeid;
        }
        else
        {
            return 'false';
        }
    }




    if (isset($_POST['action']) and $_POST['action'] == 'like')
    {
        if ($_POST['dislikecheck'] == 'true')
        {
            $sql = 'DELETE FROM Rating WHERE rID = ' . $_POST['dislikeID'];
            $s = $GLOBALS['pdo']->prepare($sql);
            $s->execute();
        }
        try
        {
            $sql = 'INSERT INTO Rating SET
            imageID = :iid,
            accID = :aid,
            Rating = 1
            ';

            $s = $GLOBALS['pdo']->prepare($sql);
            $s->bindValue(':iid', $_GET['image']);
            $s->bindValue(':aid', $_COOKIE['userid']);
            $s->execute();
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
        header('Refresh: 1');
    }

    if (isset($_POST['action']) and $_POST['action'] == 'dislike')
    {
        if ($_POST['likecheck'] == 'true')
        {
            $sql = 'DELETE FROM Rating WHERE rID = ' . $_POST['likeID'];
            $s = $GLOBALS['pdo']->prepare($sql);
            $s->execute();
        }
        try
        {
            $sql = 'INSERT INTO Rating SET
            imageID = :iid,
            accID = :aid,
            Rating = 0
            ';

            $s = $GLOBALS['pdo']->prepare($sql);
            $s->bindValue(':iid', $_GET['image']);
            $s->bindValue(':aid', $_COOKIE['userid']);
            $s->execute();
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
        header('Refresh: 1');
    }

    if (isset($_POST['action']) and $_POST['action'] == 'removelike')
    {
            $sql = 'DELETE FROM Rating WHERE rID = ' . $_POST['likeID'];
            $s = $GLOBALS['pdo']->prepare($sql);
            $s->execute();

            header('Refresh: 1');
    }

    if (isset($_POST['action']) and $_POST['action'] == 'removedislike')
    {
            $sql = 'DELETE FROM Rating WHERE rID = ' . $_POST['dislikeID'];
            $s = $GLOBALS['pdo']->prepare($sql);
            $s->execute();

            header('Refresh: 1');
    }

    function viewcomments()
    {
        try
        {
            $result= $GLOBALS['pdo']->query('SELECT c.cID, c.imageID, c.accID, a.username, c.comment FROM Comment c JOIN Account a on a.accID = c.accID WHERE imageID = ' . $_GET['image']);
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach ($result as $row)
        {
            $comments[] = array('id' => $row['cID'], 'imageID' => $row['imageID'], 'accid' => $row['accID'], 'username' => $row['username'], 'comment' => $row['comment']);
        }
        return $comments;
    }


    if(isset($_POST['action']) and $_POST['action'] == 'subcomment')
    {
        $sql = 'INSERT INTO Comment SET
        imageID = :image,
        accID = :aid,
        comment = :comment
        ';

        $s = $GLOBALS['pdo']->prepare($sql);
        $s->bindValue(':image', $_GET['image']);
        $s->bindValue(':aid', $_COOKIE['userid']);
        $s->bindValue(':comment', $_POST['commenttxt']);
        $s->execute();

        header('Refresh: 1');
    }

    if (isset($_POST['action']) and $_POST['action'] == 'deletecomment')
    {
            $sql = 'DELETE FROM Comment WHERE cID = ' . $_POST['cid'];
            $s = $GLOBALS['pdo']->prepare($sql);
            $s->execute();

            header('Refresh: 1');
    }

    function AlbumInfo()
    {
        try
        {
            $result = $GLOBALS['pdo']->query('SELECT albumID, accID, albumName, albumDesc FROM Album WHERE albumID = ' . $_GET['name'] . '
            ');
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach($result as $row) //system loops through query results and stores data in an array
        {
            $albuminfo[] = array('id' => $row['albumID'], 'name' => $row['albumName'], 'desc' => $row['albumDesc']);
        }
        return $albuminfo;
    }
    
    function LoadAlbumData()
    {
        try
        {
            $result = $GLOBALS['pdo']->query('SELECT i.imageID, a.username, i.albumID, i.imageCode, i.imageName, i.imageDesc, i.altTag, i.postDate, i.ageFilter, i.creativeLicense, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) END) AS Likes, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) END) AS Dislikes,
            (CASE WHEN (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) IS NULL THEN "0" ELSE (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) END) AS commentCount
            FROM image i
            LEFT JOIN Account a ON i.accID = a.accID
            LEFT JOIN Rating r ON i.imageID = r.imageID
            LEFT JOIN Comment c ON i.imageID = c.imageID
            WHERE i.albumID = ' . $_GET['name'] . '
            GROUP BY i.imageID
            ');
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
        if ($result->rowCount() != 0)
        {
            foreach($result as $row) //system loops through query results and stores data in an array
            {
                $albumdata[] = array('id' => $row['imageID'], 'user' => $row['username'], 'title' => $row['imageName'], 'code' => $row['imageCode'], 'alt' => $row['altTag'], 'age' => $row['ageFilter']);
            }
        }
        else
        {
            $albumdata = 0;
        }
        
        return $albumdata;
    }

    function searchResults()
    {
        try //searches through the image names for a match if there are no tags that match
        {
            $imagesearch = $GLOBALS['pdo']->query('SELECT i.imageID, a.username, i.albumID, i.imageCode, i.imageName, i.imageDesc, i.altTag, i.postDate, i.ageFilter, i.creativeLicense, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) END) AS Likes, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) END) AS Dislikes,
            (CASE WHEN (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) IS NULL THEN "0" ELSE (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) END) AS commentCount
            FROM image i
            LEFT JOIN Account a ON i.accID = a.accID
            LEFT JOIN Rating r ON i.imageID = r.imageID
            LEFT JOIN Comment c ON i.imageID = c.imageID
            LEFT JOIN imageTag it ON i.imageID = it.imageID
            LEFT JOIN Tag t ON it.tagID = t.tagID
            WHERE i.imageName LIKE "' . $_GET['term'] . '"
            OR t.tagName LIKE "' . $_GET['term'] . '"
            GROUP BY i.imageID
            ORDER BY postDate ASC
            ');
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach ($imagesearch as $image)
        {
            $result[] = array('id' => $image['imageID'], 'user' => $image['username'], 'title' => $image['imageName'], 'code' => $image['imageCode'], 'alt' => $image['altTag'], 'age' => $image['ageFilter']);
        }
        return $result;
    }

    function searchResultsDesc()
    {
        try //searches through the image names for a match if there are no tags that match
        {
            $imagesearch = $GLOBALS['pdo']->query('SELECT i.imageID, a.username, i.albumID, i.imageCode, i.imageName, i.imageDesc, i.altTag, i.postDate, i.ageFilter, i.creativeLicense, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) END) AS Likes, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) END) AS Dislikes,
            (CASE WHEN (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) IS NULL THEN "0" ELSE (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) END) AS commentCount
            FROM image i
            LEFT JOIN Account a ON i.accID = a.accID
            LEFT JOIN Rating r ON i.imageID = r.imageID
            LEFT JOIN Comment c ON i.imageID = c.imageID
            LEFT JOIN imageTag it ON i.imageID = it.imageID
            LEFT JOIN Tag t ON it.tagID = t.tagID
            WHERE i.imageName LIKE "' . $_GET['term'] . '"
            OR t.tagName LIKE "' . $_GET['term'] . '"
            GROUP BY i.imageID
            ORDER BY postDate DESC
            ');
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach ($imagesearch as $image)
        {
            $result[] = array('id' => $image['imageID'], 'user' => $image['username'], 'title' => $image['imageName'], 'code' => $image['imageCode'], 'alt' => $image['altTag'], 'age' => $image['ageFilter']);
        }
        return $result;
    }

    function searchResultsMP()
    {
        try //searches through the image names for a match if there are no tags that match
        {
            $imagesearch = $GLOBALS['pdo']->query('SELECT i.imageID, a.username, i.albumID, i.imageCode, i.imageName, i.imageDesc, i.altTag, i.postDate, i.ageFilter, i.creativeLicense, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) END) AS Likes, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) END) AS Dislikes,
            (CASE WHEN (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) IS NULL THEN "0" ELSE (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) END) AS commentCount
            FROM image i
            LEFT JOIN Account a ON i.accID = a.accID
            LEFT JOIN Rating r ON i.imageID = r.imageID
            LEFT JOIN Comment c ON i.imageID = c.imageID
            LEFT JOIN imageTag it ON i.imageID = it.imageID
            LEFT JOIN Tag t ON it.tagID = t.tagID
            WHERE i.imageName LIKE "' . $_GET['term'] . '"
            OR t.tagName LIKE "' . $_GET['term'] . '"
            GROUP BY i.imageID
            ORDER BY (Likes - Dislikes)  DESC
            ');
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach ($imagesearch as $image)
        {
            $result[] = array('id' => $image['imageID'], 'user' => $image['username'], 'title' => $image['imageName'], 'code' => $image['imageCode'], 'alt' => $image['altTag'], 'age' => $image['ageFilter']);
        }
        return $result;
    }

    function searchResultsLP()
    {
        try //searches through the image names for a match if there are no tags that match
        {
            $imagesearch = $GLOBALS['pdo']->query('SELECT i.imageID, a.username, i.albumID, i.imageCode, i.imageName, i.imageDesc, i.altTag, i.postDate, i.ageFilter, i.creativeLicense, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 1) END) AS Likes, 
            (CASE WHEN (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) IS NULL THEN "0" ELSE (SELECT COUNT(ra.Rating) FROM Rating ra WHERE ra.imageID = r.imageID AND ra.Rating = 0) END) AS Dislikes,
            (CASE WHEN (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) IS NULL THEN "0" ELSE (SELECT COUNT(co.cID) FROM Comment co WHERE co.imageID = c.imageID) END) AS commentCount
            FROM image i
            LEFT JOIN Account a ON i.accID = a.accID
            LEFT JOIN Rating r ON i.imageID = r.imageID
            LEFT JOIN Comment c ON i.imageID = c.imageID
            LEFT JOIN imageTag it ON i.imageID = it.imageID
            LEFT JOIN Tag t ON it.tagID = t.tagID
            WHERE i.imageName LIKE "' . $_GET['term'] . '"
            OR t.tagName LIKE "' . $_GET['term'] . '"
            GROUP BY i.imageID
            ORDER BY (Likes - Dislikes)  ASC
            ');
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach ($imagesearch as $image)
        {
            $result[] = array('id' => $image['imageID'], 'user' => $image['username'], 'title' => $image['imageName'], 'code' => $image['imageCode'], 'alt' => $image['altTag'], 'age' => $image['ageFilter']);
        }
        return $result;
    }

    function loadYourAccount()
    {
        try
        {
            $result = $GLOBALS['pdo']->query('SELECT a.accID, a.username, a.email, a.password, a.description, a.joinDate,
            (CASE WHEN (SELECT COUNT(ar.followingAccID) FROM AccRel ar WHERE ar.followerAccID = r.followerAccID) IS NULL THEN "0" ELSE (SELECT COUNT(ar.followingAccID) FROM AccRel ar WHERE ar.followerAccID = r.followerAccID) END) AS Followers,
            (CASE WHEN (SELECT COUNT(ar.followingAccID) FROM AccRel ar WHERE ar.followingAccID = rf.followingAccID) IS NULL THEN "0" ELSE (SELECT COUNT(ar.followingAccID) FROM AccRel ar WHERE ar.followingAccID = rf.followingAccID) END) AS Following
            FROM Account a
            LEFT JOIN AccRel r ON a.accID = r.followerAccID
            LEFT JOIN AccRel rf ON a.accID = rf.followingAccID
            WHERE a.accID = ' . $_COOKIE['userid'] . '
            GROUP BY a.accID
            ');
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach($result as $row)
        {
            $accountinfo[] = array('id' => $row['accID'], 'username' => $row['username'], 'desc' => $row['description'], 'joindate' => $row['joinDate'], 'followers' => $row['Followers'], 'following' => $row['Following']);
        }

        return $accountinfo;
    }

    function loadYourAlbums()
    {
        try
        {
            $result = $GLOBALS['pdo']->query('SELECT albumID, albumName, albumDesc, createdDate FROM Album WHERE accID = ' . $_COOKIE['userid'] . '
            ');
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach($result as $row)
        {
            $albuminfo[] = array('id' => $row['albumID'], 'name' => $row['albumName'], 'desc' => $row['albumDesc'], 'date' => $row['createdDate']);
        }

        return $albuminfo;
    }

    if (isset($_POST['action']) and $_POST['action'] == 'updateuser')
    {
        try
        {
            $sql = 'UPDATE Account SET
            username = :username,
            description = :description
            WHERE accID = ' . $_COOKIE['userid'] . '
            ';

            $s = $GLOBALS['pdo']->prepare($sql);
            $s->bindValue(':username', $_POST['username']);
            $s->bindValue(':description', $_POST['description']);
            $s->execute();

        
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
        header('Refresh: 1');
    }

    if (isset($_POST['action']) and $_POST['action'] == 'logout')
    {
        setcookie('userid', '', time() - 3600, '/');
        session_destroy();
        
    }

    if (isset($_POST['action']) and $_POST['action'] == 'deleteuser')
    {
        setcookie('userid', '', time() - 3600, '/');
        session_destroy();
        try
        {
            $sql = 'DELETE FROM Account WHERE accID = ' . $_COOKIE['userid'];
            $s = $GLOBALS['pdo']->prepare($sql);
            $s->execute();
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
        header("Location: http://voltafy.co.uk/jakevolt/");
    }

    if (isset($_POST['action']) and $_POST['action'] == 'addalbum')
    {
        try
        {
            $sql = 'INSERT INTO Album SET
            albumName = :name,
            albumDesc = :desc,
            accID = :accid,
            createdDate = NOW()
            ';

            $s = $GLOBALS['pdo']->prepare($sql);
            $s->bindValue(':name', $_POST['albumname']);
            $s->bindValue(':desc', $_POST['albumdesc']);
            $s->bindValue(':accid', $_COOKIE['userid']);
            $s->execute();

        
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
        header('Refresh: 1');
    }

    if (isset($_POST['action']) and $_POST['action'] == 'deletealbum')
    {
        try
        {
            $sql = 'DELETE FROM Album WHERE albumID = ' . $_POST['albumid'];
            $s = $GLOBALS['pdo']->prepare($sql);
            $s->execute();

        
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
        header('Refresh: 1');
    }

    function loadAccountDetails()
    {
        try
        {
            $result = $GLOBALS['pdo']->query('SELECT a.accID, a.username, a.description, a.joinDate,
            (CASE WHEN (SELECT COUNT(ar.followingAccID) FROM AccRel ar WHERE ar.followerAccID = r.followerAccID) IS NULL THEN "0" ELSE (SELECT COUNT(ar.followingAccID) FROM AccRel ar WHERE ar.followerAccID = r.followerAccID) END) AS Followers,
            (CASE WHEN (SELECT COUNT(ar.followingAccID) FROM AccRel ar WHERE ar.followingAccID = rf.followingAccID) IS NULL THEN "0" ELSE (SELECT COUNT(ar.followingAccID) FROM AccRel ar WHERE ar.followingAccID = rf.followingAccID) END) AS Following
            FROM Account a
            LEFT JOIN AccRel r ON a.accID = r.followerAccID
            LEFT JOIN AccRel rf ON a.accID = rf.followingAccID
            WHERE a.accID = ' . $_GET['id'] . '
            GROUP BY a.accID
            ');
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach($result as $row)
        {
            $accountinfo[] = array('id' => $row['accID'], 'username' => $row['username'], 'desc' => $row['description'], 'joindate' => $row['joinDate'], 'followers' => $row['Followers'], 'following' => $row['Following']);
        }

        return $accountinfo;
    }

    function loadAccountAlbums()
    {
        try
        {
            $result = $GLOBALS['pdo']->query('SELECT albumID, albumName, albumDesc, createdDate FROM Album WHERE accID = ' . $_GET['id'] . '
            ');
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        foreach($result as $row)
        {
            $albuminfo[] = array('id' => $row['albumID'], 'name' => $row['albumName'], 'desc' => $row['albumDesc'], 'date' => $row['createdDate']);
        }

        return $albuminfo;
    }

    function checkFollow()
    {
        $result = $GLOBALS['pdo']->query('SELECT followingAccID, followerAccID 
        FROM AccRel
        WHERE followingAccID = ' . $_COOKIE['userid'] . ' AND followerAccID = ' . $_GET['id']);

        if ($result->rowCount() >= 1)
        {
            $return = 1;
        }
        else
        {
            $return = 0;
        }

        return $return;
    }

    if (isset($_POST['action']) and $_POST['action'] == 'followuser')
    {
        try
        {
            $sql = 'INSERT INTO AccRel SET 
            followingAccID = ' . $_COOKIE['userid'] . ',
            followerAccID = ' . $_GET['id'];
            $s = $GLOBALS['pdo']->prepare($sql);
            $s->execute();
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
        header('Refresh: 1');
    }

    if (isset($_POST['action']) and $_POST['action'] == 'unfollowuser')
    {
        try
        {
            $sql = 'DELETE FROM AccRel WHERE followingAccID = ' . $_COOKIE['userid'] . ' AND followerAccID = ' . $_GET['id'];
            $s = $GLOBALS['pdo']->prepare($sql);
            $s->execute();
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
        header('Refresh: 1');
    }

    if (isset($_POST['action']) and $_POST['action'] == 'editimage')
    {
        header('Location: http://voltafy.co.uk/jakevolt/EditImage/?image=' . $_POST['imageid']);
    }

    function loadTags()
    {
        try
        {
            $result = $GLOBALS['pdo']->query('SELECT t.tagID, tagName FROM Tag t JOIN imageTag it ON t.tagID = it.tagID WHERE it.imageID = ' . $_GET['image']);
        }
        catch(PDOException $e)
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }
        if ($result->rowCount() != 0)
        {
            foreach ($result as $row)
            {
                $tagname[] = array('id' => $row['tagID'], 'tagname' => $row['tagName']);
            }
        }
        else
        {
            $tagname = 0;
        }
        return $tagname;
    }

    if (isset($_POST['action']) and $_POST['action'] == 'updateimage')
    {
    $tagarray = json_decode($_POST['tagarray']);
        if (!empty($tagarray))
        {
            foreach ($tagarray as $tag)
            {
                $result = $pdo->query('SELECT tagID, tagName FROM Tag WHERE tagName = "' . $tag . '"');
                if ($result->rowCount() == 0)
                {
                    try
                    {
                    $newtag = 'INSERT INTO Tag SET tagName = :tagname';

                    $stag = $pdo->prepare($newtag);
                    $stag->bindValue(':tagname', $tag);
                    $stag->execute();
                    }
                    catch(PDOException $e) //loads error page if something goes wrong
                    {
                        $output = 'Unable to add tag:' . $e->getMessage();
                        include 'error.php';
                        exit();
                    }
                }
            }
        }

        $check;

            if ($_POST['inappropriatecheck'] == 1)
            {
                $check = 1;
            }
            else
            {
                $check = 0;
            }
        try //adds image to database
        {
            $sql = 'UPDATE image SET
            accID = :id,
            albumID = :album,
            imageName = :title,
            imageDesc = :desc,
            altTag = :alt,
            postDate = NOW(),
            ageFilter = :age,
            creativeLicense = :cl
            WHERE imageID = ' . $_GET['image'];

            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_COOKIE['userid']);
            $s->bindValue(':album', $_POST['album']);
            $s->bindValue(':title', $_POST['titletxt']);
            $s->bindValue(':desc', $_POST['imagedesc']);
            $s->bindValue(':alt', $_POST['alttxt']);
            $s->bindValue(':age', $check);
            $s->bindValue(':cl', $_POST['cl']);
            $s->execute();
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        $imageid = $_GET['image'];

        if (!empty($tagarray))
        {
            foreach ($tagarray as $tag)
            {
                $gettagid = $pdo->query('SELECT tagID, tagName FROM Tag WHERE tagName = "' . $tag . '"'); //gets the id of the tag to use on the imagetag insert
                foreach ($gettagid as $tags)
                {
                    $imagetagsql = 'INSERT INTO imageTag SET tagID = :tagid, imageID = :imgid';
                    
                    $simg = $pdo->prepare($imagetagsql);
                    $simg->bindValue(':tagid', $tags['tagID']);
                    $simg->bindValue(':imgid', $imageid);
                    $simg->execute();
                }
            }   
        }
        header('Location: http://voltafy.co.uk/jakevolt/viewImage/?image=' . $_GET['image']);
    }

    if (isset($_POST['action']) and $_POST['action'] == 'deleteimage')
    {
        try
        {
            $sql = 'DELETE FROM image WHERE imageID = ' . $_GET['image'];
            $s = $GLOBALS['pdo']->prepare($sql);
            $s->execute();
        }
        catch(PDOException $e) //loads error page if something goes wrong
        {
            $output = 'Unable to load data:' . $e->getMessage();
            include 'error.php';
            exit();
        }

        header('Location: http://voltafy.co.uk/jakevolt/');
    }
?>
