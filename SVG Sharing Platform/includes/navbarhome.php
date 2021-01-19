<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta>
    <meta>
    <script src="../js/FileSaver.min.js"></script>
    <script src="../js/domparser.js"></script>
    <link rel="icon" type="image/png" href="/images/VLLogo.png">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/33429a25a2.js" crossorigin="anonymous"></script>
    <script src="../js/jquery.js"></script>
    <script>
        function noScroll() 
        {
            window.scrollTo(0, 0);
        }

        function myFunction(x) 
        {
            var menu = document.getElementById("sidemenu");
            x.classList.toggle("change");

            if(menu.style.display == "")
            {
                menu.style.display = "block";
                preventscroll();
            }
            else
            {
                menu.style.display = "";
                enablescroll();
            }
        }

        function preventscroll()
        {
            window.addEventListener('scroll', noScroll);
        }

        function enablescroll()
        {
            window.removeEventListener('scroll', noScroll);
        }

    </script>
</head>
<body>
    <form action="" method="get"></form>
        <nav>
            <div class="menu" onclick="myFunction(this)">
                <div class="bar1"></div>
                <div class="bar2"></div>
                <div class="bar3"></div>
              </div>
            <a href="http://voltafy.co.uk/jakevolt/"><img src="images/logosmall.png" class="navlogo"></a>
            <input type="search" id="searchtxt" placeholder="search for an image" class="navsearchtxt">
            <button class="navsearchbtn" onclick="search()"><i class="fa fa-search" onclick="search()"></i></button>
            <script>
                function search()
                {
                    window.location.href = "http://voltafy.co.uk/jakevolt/Search/?term=" + document.getElementById("searchtxt").value;
                }
                
            </script>
            <input onclick="redirecthome()" type="button" name="homebtn" value="Home" class="navbtn">
            <input onclick="redirectupload()" type="button" name="uploadbtn" value="Upload" class="navbtn">
            <?php if(isset($_COOKIE['userid']))
            {
                echo '
                <input onclick="redirectaccount()" type="button" name="logbtn" value="Your Account" class="navbtn">
                ';
            }
            else
            {
                echo '
                <input onclick="redirectaccount()" type="button" name="logbtn" value="Account" class="navbtn">
                ';
            }
            ?>
        </nav>
        <div id="sidemenu" class="sidemenubackground">
        <div class="sidemenu">
            <button onclick="redirecthome()" class="sidemenubtn">Home</button>
            <?php if(isset($_COOKIE['userid']))
            {
                echo '
                <button onclick="redirectaccount()" class="sidemenubtn">Your Account</button>
                ';
            }
            else
            {
                echo '
                <button onclick="redirectaccount()" class="sidemenubtn">Account</button>
                ';
            }
            ?>
            <button onclick="redirectupload()" class="sidemenubtn">Upload an Image</button>
        </div>
        </div>
    </form>
    <?php 
    if(isset($_COOKIE['userid']))
    {
        echo '
        <script>
        function redirecthome()
        {
            window.location.href = "http://voltafy.co.uk/jakevolt/";
        }
        function redirectaccount()
        {
            window.location.href = "http://voltafy.co.uk/jakevolt/YourAccount";
        }
        function redirectupload()
        {
            window.location.href = "http://voltafy.co.uk/jakevolt/Upload";
        }
        </script>
        ';
    }
    else
    {
        echo '
        <script>
        function redirecthome()
        {
            window.location.href = "http://voltafy.co.uk/jakevolt/";
        }
        function redirectaccount()
        {
            window.location.href = "http://voltafy.co.uk/jakevolt/Login";
        }
        function redirectupload()
        {
            window.location.href = "http://voltafy.co.uk/jakevolt/Login";
        }
        </script>
        ';
    }
?>