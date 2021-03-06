<?php include_once '../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php html($pageTitle); ?></title>
    <meta charset="UTF-8">
</head>
<body>
<h1><?php html($pageTitle); ?></h1>
<form action="?<?php html($action); ?>" method="post">
  <div>
      <label for="text">Recipe Name:</label>
      <textarea id="text" name="name" rows="3" cols="40"><?php html($name); ?></textarea>
    </div><br>
    <div>
      <label for="text">Recipe Brief Description:</label>
      <textarea id="text" name="description" rows="3" cols="40"><?php html($description); ?></textarea>
    </div> <br>
    <div>
      <label for="text">Recipe Detailed Description:</label>
      <textarea id="text" name="detailedDescription" rows="3" cols="40"><?php html($detailedDescription); ?></textarea>
    </div> <br>
    <div>
    <label for="author">Author:</label>
      <select name="author" id="author">
      <option value="">Select one</option>
          <?php foreach ($authors as $author): ?>
         <option value="<?php html($author['id']); ?>"<?php
          if ($author['id'] == $authorid)
          {
          echo ' selected';
          }
          ?>><?php html($author['name']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>  
    <fieldset> 
    <legend>Categories:</legend>
        <?php foreach ($categories as $category): ?>
        <div><label for="category<?php html($category['id']); ?>">
            <input type="checkbox" name="categories[]"
                   value="<?php html($category['id']); ?>"<?php
                   if ($category['selected'])
                   {
                       echo ' checked';
                   }
                   ?>><?php html($category['name']); ?></label></div>
        <?php endforeach; ?>
    </fieldset>
    <div>
    <input type="hidden" name="id" value="<?php html($id); ?>">
        <input type="submit" value="<?php html($button); ?>">
    </div>
    </form>
</body>
</html>
