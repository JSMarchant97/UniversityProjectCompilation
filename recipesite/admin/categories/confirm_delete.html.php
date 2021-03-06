<?php include_once '../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title>Untitled Document</title>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
	
	<link href="style.css" rel="stylesheet" />
</head>
<body>
    <h1>Confirm Delete?</h1>
    <form action="" method="post">
        <div>
        Do you really want to delete:<b> <?php html($name); ?></b> and all of the jokes in this category?
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="submit" name="action" value="Yes">
        <input type="submit" name="action" value="No">
        </div>
    </form>
</body>
</html>
