<?php

if(isset($_POST['message']))
{
$subject = $_POST['subject'];
    $message = $_POST['message'];
    ini_set("sendmail_from", "jm1727g@gre.ac.uk");
    mail('jm1727g@gre.ac.uk', $subject, $message);
        
    header('Location: .');
    exit();
}
if (isset($_GET['add']))
{
    $pageTitle = 'New Recipe';
    $name = '';
    $authorid = '';
    $description ='';
    $detailedDescription = '';
    $id = '';
    $button = 'Add Recipe';
    
    include 'includes/db.inc.php';
    
    try
    {
        $result = $pdo->query('SELECT author_id, name FROM recipeauthors');
    }
    catch (PDOException $e)
    {
        $output = 'error fetching list of authors';
        include 'error.html.php';
        exit();
    }
    foreach ($result as $row)
    {
        $authors[] = array('id' => $row['author_id'], 'name' => $row['name']); 
    }
    
    try
    {
        $result = $pdo->query('SELECT id, name FROM dishcategory');
    }
    catch (PDOException $e)
    {
        $output = 'error fetching list of categories';
        include 'error.html.php';
        exit();
    }
    foreach ($result as $row)
    {
        $categories[] = array('id' => $row['id'], 'name' => $row['name'], 'selected' => FALSE); 
    }
    
    include 'addrecipe.html.php';
    exit();
}

if (isset($_GET['addform']))
{
    include 'includes/db.inc.php';
    
    if ($_POST['author'] == '')
    {
        $output = 'you must choose an author for the recipe, try again.';
        include 'error.html.php';
        exit();
    }
    
    try 
    {
        $sql = 'INSERT INTO recipe SET
            name = :name,
            description = :description,
            detailedDescription = :detailedDescription,
            recipedate = CURDATE(),
            authorid = :authorid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':description', $_POST['description']);
        $s->bindValue(':detailedDescription', $_POST['detailedDescription']);
        $s->bindValue(':authorid', $_POST['author']);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $output = 'Error adding recipe' . $e;
        include 'error.html.php';
        exit();
    }
    
    $recipeid = $pdo->lastInsertId();

     if (isset($_POST['categories']))
    {
        
        try
        {
            $sql = 'INSERT INTO recipecategory SET
            recipeid = :recipeid,
            categoryid = :categoryid';
            $s = $pdo->prepare($sql);
            foreach ($_POST['categories'] as $categoryid)
            {
                $s->bindValue(':recipeid', $recipeid);
                $s->bindValue(':categoryid', $categoryid);
                $s->execute();
            }
        }
    catch (PDOException $e)
    {
        $output = 'Error adding recipe into selected categories' . $e;
        include 'error.html.php';
        exit();
    }
}
    header('Location: .');
    exit();
}

if(isset($_GET['recipes']))
{

include 'includes/db.inc.php';
try
{
    $result = $pdo->query('SELECT id, name, description, image FROM recipe ORDER BY RAND () LIMIT 5');
}
catch(PDOException $e)
{
    $output = 'Error fetching recipes:' . $e->getMessage();
    include 'error.html.php';
    exit();
}

foreach ($result as $row)
{
    $recipes[] = array('id' => $row['id'], 'name' => $row['name'], 'description' => $row['description'], 'image' => $row['image']);
}
    
 
    include 'includes/db.inc.php';
//building the authors array
try
{
    $result = $pdo->query('SELECT author_id, name FROM recipeauthors');
}

catch(PDOException $e)
{
    $error = 'Error fetching authors from the database!';
    include 'error.html.php';
    exit();
}

foreach($result as $row)
{
    $authors[] = array ('id' => $row['author_id'], 'name' => $row['name'] );
}

try
{
    $result = $pdo->query('SELECT id, name FROM dishcategory');
}

catch(PDOException $e)
{
    $error = 'Error fetching categories from the database!';
    include 'error.html.php';
    exit();
}

foreach($result as $row)
{
    $categories[] = array ('id' => $row['id'], 'name' => $row['name'] );
}

    include 'recipes.html.php';
exit();
}

if(isset($_GET['action']) and $_GET['action'] == 'More')
{
    include 'includes/db.inc.php';
    
    try
    {
        $sql = 'SELECT id, name, description, detailedDescription, image FROM recipe WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_GET['id']);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $output = 'Error fetching recipe details';
        include 'error.html.php';
        exit();
    }
    
     $row = $s->fetch();
    
    $pageTitle = $row['name'];
    $name = $row['name'];
    $image = $row['image'];
    $description = $row['description'];
    $detailedDescription = $row['detailedDescription'];
    
    include 'seemore.html.php';
    exit();
}

if(isset($_GET['action']) and $_GET['action'] == 'search')
{
    include 'includes/db.inc.php';

$select = 'SELECT id, name, description, image';
$from = ' FROM recipe';
$where = ' WHERE TRUE';
$placeholders = array();


if ($_GET['author'] != '') //An author is selected 
{
    $where .= " AND authorid = :authorid";
    $placeholders[':authorid'] = $_GET['author'];
}

if ($_GET['category'] != '') //A category is selected
{
    $from .= ' INNER JOIN recipecategory ON id = recipeid';
    $where .= " AND categoryid = :categoryid";
    $placeholders[':categoryid'] = $_GET['category'];
}

if ($_GET['text'] != '') //some search text was specified
{
    $where .= " AND name LIKE :name";
    $placeholders[':name'] = '%' . $_GET['text'] . '%';
}
    
try
{
    $sql = $select . $from . $where;
    $s = $pdo->prepare($sql);
    $s ->execute($placeholders);
}
catch(PDOException $e)
{
    $error = 'Error fetching recipes.' . $e;
    include 'error.html.php';
    exit();
}

foreach ($s as $row)
{
    $recipes[] = array('id' =>$row['id'], 'text' =>$row['name'], 'description' =>$row['description'], 'image' =>$row['image']);
}
    //shows search results
    include 'result.html.php';
    exit();
}
    
if(isset($_GET['add']))
{
    include 'addrecipe.html.php';
    exit();
}

if(isset($_GET['contact']))
{
    include 'contact.html.php';
    exit();
}

include 'home.html.php';
?>