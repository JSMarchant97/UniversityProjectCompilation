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
            <table>
            <tr>
                <td id="imgcell">
                    <img border="2px" id="recipeimgs" src="images/<?php html($image); ?>"><br><br>
                    <h2><?php html($name); ?></h2>
                </td>
            </tr>
            <tr>
                <td>
                    <br>
                    <h3>Summary:</h3><?php html($description); ?> <br><br><br>
                    <h3>Recipe Information:</h3><?php html($detailedDescription); ?>
                </td>
            </tr>
            </table>
        </div>
    </div>
    <?php include 'includes/footer.inc.html.php'; ?>
</body>
</html>
