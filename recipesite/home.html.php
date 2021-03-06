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
        <img src="images/homebg.jpg" id="bgimg">
        <img src="images/recipecentral.png" id="logo">
        <h2 class="title">Welcome to Recipe Central!</h2>
        <h2 class="subtitle">Here you will find a wide range of recipes from our amazing active users.<br>During your visit, expect many different types of dishes from all over the world!</h2>
    </div>
  <?php include 'includes/footer.inc.html.php'; ?>
</body>
</html>
