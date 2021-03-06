<?php include_once '../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title>Untitled Document</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
	
	<link href="mainstyle.css" rel="stylesheet" />
</head>
<body>
    <h1><?php html($pageTitle); ?></h1>
    <form action="?<?php html($action); ?>" method="post">
        <label for="name"> Name: <input type="text" name="name" id="name" value="<?php html($name); ?>"></label> <br>
        <input type="hidden" name="id" value="<?php html($id); ?>">
        <input type="submit" value="<?php html($button); ?>">
            
    </form>
</body>
</html>
