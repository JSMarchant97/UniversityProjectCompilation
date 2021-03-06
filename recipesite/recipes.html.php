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
        <button id="searchbtn" onclick="showhide()">Toggle Search</button>
        <div id="searchcont">
    <form action="" method="get">
    <p>View recipes satisfying the following criteria:</p>
    <div>
    <label for="author">By author:</label>
    <select name="author" id="author">
        <option value="">Any author</option>
        <?php foreach($authors as $author): ?>
        <option value="<?php html($author['id']); ?>"><?php html($author['name']); ?></option>
        <?php endforeach; ?>
        </select>
    </div>
    <div>
    <label for="category">By category:</label>
        <select name="category" id="category">
        <option value="">Any category</option>
            <?php foreach($categories as $category): ?>
            <option value="<?php html($category['id']); ?>"><?php html($category['name']); ?></option>
            <?php endforeach;?>
        </select>
    </div>
    <div>
    <label for="text">Containing text:</label>
    <input type="text" name="text" id="text">
    </div>
    <div>
    <input type="hidden" name="action" value="search">
    <input type="submit" value="Search">
    </div>
    </form>
    </div>
            <script>
    var search = document.getElementById("searchcont");
        
        function showhide()
        {
            if (search.style.display === "none")
            {
               search.style.display = "block";
            
            }
            else
            {
                search.style.display = "none";
            }
        }
    </script>
        <table>
            <br>
        <form action="" method="get">
        <tr id="tblcell"><th></th><th>Recipe name</th><th>Description</th></tr>
            <?php foreach ($recipes as $recipe): ?>
            <td id="imgcell"><img id="recipeimg" src="images/<?php echo $recipe["image"]; ?>"</td>
            <td> <?php echo $recipe["name"]; ?></td>
            <td> <?php echo $recipe["description"]; ?></td>
            <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
            <td> <input type="submit" name="action" value="More"></td>
        </tr>
        </form>
        <?php endforeach; ?>
    </table>
        </div>
    </div>
    <?php include 'includes/footer.inc.html.php'; ?>
</body>
</html>
