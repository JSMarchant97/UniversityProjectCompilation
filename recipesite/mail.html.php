<?php include_once 'includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title>Recipe Central</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
	
	<link href="mainstyle.css" rel="stylesheet" />
</head>
<body>
    <div class="cont">
        <a href="index.php"><button class="navbtn">Home</button></a>
        <a href="?recipes"><button class="navbtn">All Recipes</button></a>
        <a href="?add"><button class="navbtn">Submit A Recipe</button></a>
        <a href="?contact"><button class="navbtn">Contact</button></a>
    </div>
    <div class="container">
        <img src="images/bg.jpg" id="bgimg">
        <div id="results">
            
        </div>
    </div>
    <?php include 'includes/footer.inc.html.php'; ?>
</body>
</html>
