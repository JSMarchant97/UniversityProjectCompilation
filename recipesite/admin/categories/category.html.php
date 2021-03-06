<?php include_once '../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title>Untitled Document</title>
    <meta charset="UTF-8">
	<link href="style.css" rel="stylesheet" />
</head>
<body>
    <h1>Manage Categories</h1>
    <p><a href="?add">Add new category</a></p>
    <table border="1px">
    <?php foreach ($categories as $category): ?>
        <form action="" method="post">
        <tr>
            <td> <?php html($category["name"]); ?></td>
            <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
            <td> <input type="submit" name="action" value="Edit"></td>
            <td> <input type="submit" name="action" value="Delete"></td>
        </tr>
        </form>
        <?php endforeach; ?>
    </table>
    <p><a href="../index.html">Return to CMS home</a></p>
    <?php include '../includes/footer.inc.html.php'; ?>
</body>
</html>
