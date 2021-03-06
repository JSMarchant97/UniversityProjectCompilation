<?php include_once '../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title><?php html($pageTitle); ?></title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
	
	<link href="mainstyle.css" rel="stylesheet" />
</head>
<body>
    <h1><?php html($pageTitle); ?></h1>
    <form action="index.php" method="post">
                    <label for="subjectall"> Subject: </label> <br>
                    <input type="text" name="subjectall" id="subjectall"> <br>
                    <label for="messageall"> Message: </label> <br>
                    <textarea name="messageall" id="messageall" rows="5" cols="40"></textarea> <br>
        <input type="submit" value="<?php html($button); ?>">
    </form>
</body>
</html>
