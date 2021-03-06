<?php include_once '../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title>Untitled Document</title>
    <meta charset="UTF-8">
	<link href="style.css" rel="stylesheet" />
</head>
<body>
    <h1>Manage Authors</h1>
    <p><a href="?add">Add new author</a></p>
    <p><a href=?emailall>Email all authors</a></p>
    <table border="1px">
    <?php foreach ($authors as $author): ?>
        <form action="" method="post">
        <tr>
            <td> <?php html($author["name"]); ?></td>
            <input type="hidden" name="id" value="<?php echo $author['id']; ?>">
            <td> <input type="submit" name="action" value="Edit"></td>
            <td> <input type="submit" name="action" value="Delete"></td>
            <td> <input type="submit" name="action" value="Email"></td>
        </tr>
        </form>
        <?php endforeach; ?>
    </table>
    <p><a href="../index.html">Return to CMS home</a></p>
    <?php include '../includes/footer.inc.html.php'; ?>
</body>
</html>
