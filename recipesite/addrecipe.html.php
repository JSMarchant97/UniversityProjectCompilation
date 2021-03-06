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
            <h1><?php echo $pageTitle; ?></h1>
<form action="?addform" method="post">
  <div>
      <label for="text">Recipe Name:</label>
      <textarea id="text" name="name" rows="3" cols="40"></textarea>
    </div><br>
    <div>
      <label for="text">Recipe Brief Description:</label>
      <textarea id="text" name="description" rows="3" cols="40"></textarea>
    </div> <br>
    <div>
      <label for="text">Recipe Detailed Description:</label>
      <textarea id="text" name="detailedDescription" rows="3" cols="40"></textarea>
    </div> <br>
    <div>
    <label for="author">Author:</label>
      <select name="author" id="author">
      <option value="">Select one</option>
          <?php foreach ($authors as $author): ?>
         <option value="<?php echo $author['id']; ?>"<?php
          if ($author['id'] == $authorid)
          {
          echo ' selected';
          }
          ?>><?php echo $author['name']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>  
    <fieldset> 
    <legend>Categories:</legend>
        <?php foreach ($categories as $category): ?>
        <div><label for="category<?php echo $category['id']; ?>">
            <input type="checkbox" name="categories[]"
                   value="<?php echo $category['id']; ?>"<?php
                   if ($category['selected'])
                   {
                       echo ' checked';
                   }
                   ?>><?php echo $category['name']; ?></label></div>
        <?php endforeach; ?>
    </fieldset>
    <div>
    <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" value="<?php echo $button; ?>">
    </div>
    </form>
        </div>
    </div>
    <?php include 'includes/footer.inc.html.php'; ?>
</body>
</html>
