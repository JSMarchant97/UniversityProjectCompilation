<?php include_once '../includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <title>Untitled Document</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>search results</h1>
    <?php if(isset($recipes)): ?>
    <table>
    <tr><th>Recipe name</th><th>Options</th></tr>
        <?php foreach ($recipes as $recipe): ?>
        <tr>
        <td><?php html($recipe['text']); ?></td>
            <td>
            <form action="?" method="post">
                <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
                <input type="submit" name="action" value="Edit">
                <input type="submit" name="action" value="Delete">
            </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    <p><a href="?">New search</a></p>
    <p><a href="..">Return to CMS home</a></p>
</body>
</html>
