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
            <div style="margin-left: 10%;">
            <table>
                <tr>
                    <td style="width: 70%;">
    <h1>Email Us!</h1>
    <form action="index.php" method="post">
                    <label for="subject"> Subject: </label> <br>
                    <input type="text" name="subject" id="subject"> <br>
                    <label for="message"> Message: </label> <br>
                    <textarea name="message" id="message" rows="10" cols="80"></textarea> <br>
        <input type="submit" value="Send">
    </form>
                    </td>
                    <td id="contact">
                    <h1>Contact Information:</h1><br>
                    <h2>Address:<h2></h2><br>
                        Old Royal Naval College<br>
                        Park Row<br>
                        Greenwich<br>
                        London SE10 9LS<br><br>
                        Tel: 020 8331 9000<br>
                    </td>
                </tr>
            </table>
                </div>
        </div>
    </div>
</body>
</html>
