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
        <h1>search results</h1>
        <p><a href="?recipes">New search</a></p>
    <?php if(isset($recipes)): ?>
    <table>
    <tr><th></th><th>Recipe name</th><th>Description</th></tr>
        <?php foreach ($recipes as $recipe): ?>
        <tr id="tblcell">
        <td id="imgcell"><img id="recipeimg" src="images/<?php html($recipe['image']); ?>"</td>
        <td><?php html($recipe['text']); ?></td>
        <td><?php html($recipe['description']); ?></td>
            <td>
            <form action="?" method="get">
                <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
                <input type="submit" name="action" value="More">
            </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
        </div>
    </div>
    <?php include 'includes/footer.inc.html.php'; ?>
</body>
</html>
