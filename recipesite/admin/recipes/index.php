<?php

if (isset($_GET['add']))
{
    $pageTitle = 'New Recipe';
    $action = 'addform';
    $name = '';
    $authorid = '';
    $description ='';
    $detailedDescription = '';
    $id = '';
    $button = 'Add Recipe';
    
    include '../includes/db.inc.php';
    
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
    
    include 'form.html.php';
    exit();
}

if (isset($_GET['addform']))
{
    include '../includes/db.inc.php';
    
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

if(isset($_POST['action']) and $_POST['action'] == 'Edit')
{
    include '../includes/db.inc.php';
    
    try
    {
        $sql = 'SELECT id, name, description, detailedDescription, authorid FROM recipe WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $output = 'Error fetching recipe details';
        include 'error.html.php';
        exit();
    }
    
    $row = $s->fetch();
    
    $pageTitle = 'Edit Recipe';
    $action = 'editform';
    $name = $row['name'];
    $authorid = $row['authorid'];
    $description = $row['description'];
    $detailedDescription = $row['detailedDescription'];
    $id = $row['id'];
    $button = 'Update Recipe';
    
    try 
    {
        $result = $pdo->query('SELECT author_id, name FROM recipeauthors');
    }
    catch (PDOException $e)
    {
        $error = 'Error fetching list of authors.';
        include 'error.html.php';
        exit();
    }
    
    foreach ($result as $row) {
        $authors[] = array('id' => $row['author_id'], 'name' => $row['name'] );
    }
    
    //Get list of categories containing this recipe
    
    try 
    {
        $sql = 'SELECT categoryid FROM recipecategory WHERE recipeid = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $id);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $error = 'Error fetching list of selected categories.';
        include 'error.html.php';
        exit();
    }
    foreach ($s as $row) {
        $selectedCategories[] = $row['categoryid'];
    }
    
    
    
    //build list of categories
    try 
    {
        $result = $pdo->query('SELECT id, name FROM dishcategory');
    }
    catch (PDOException $e)
    {
        $error = 'Error fetching list of categories.';
        include 'error.html.php';
        exit();
    }
    
    foreach ($result as $row) {
        $categories[] = array('id' => $row['id'], 
            'name' => $row['name'],
            'selected' => in_array($row['id'], $selectedCategories));
    }
    
    //show the edit recipe version of the form
    include 'form.html.php';
    exit();

}
    
    if (isset($_GET['editform']))
    {
        include '../includes/db.inc.php';
        if ($_POST['author'] == '')
        {
            $output = 'You must choose an author for this recipe. Click back and try again.';
            include 'error.html.php';
            exit();
        }
        try
        {
            $sql = 'UPDATE recipe SET name = :name, description = :description, detailedDescription = :detailedDescription, authorid = :authorid WHERE id = :id';
            $s = $pdo->prepare($sql);
            $s->bindValue(':id', $_POST['id']);
            $s->bindValue(':name', $_POST['name']);
            $s->bindValue(':description', $_POST['description']);
            $s->bindValue(':detailedDescription', $_POST['detailedDescription']);
            $s->bindValue(':authorid', $_POST['author']);
            $s->execute();
        }
        catch (PDOException $e)
        {
            $output = 'Error updating recipe' . $e;
            include 'error.html.php';
            exit();
        }
        try
        {
            $sql = 'DELETE FROM recipecategory WHERE recipeid = :id';
            $s = $pdo->prepare($sql);
            $s->bindvalue(':id', $_POST['id']);
            $s->execute();
        }
        catch (PDOException $e)
        {
        $output = 'Error deleting recipe category entries';
        include 'error.html.php';
        exit();
        }
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
                $s->bindValue(':recipeid', $_POST['id']);
                $s->bindValue(':categoryid', $categoryid);
                $s->execute();
                }
            }
        catch (PDOException $e)
        {
        $output = 'Error adding recipe into selected categories';
        include 'error.html.php';
        exit();
        }
    }
    header('Location: .');
    exit();
    }

if(isset($_POST['action']) and $_POST['action'] == 'Delete')
{
    include '../includes/db.inc.php';
try
{
    $sql = 'SELECT id, name FROM recipe WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindvalue(':id', $_POST['id']);
    $s->execute();
}
catch (PDOException $e)
{
    $output = 'Error fetching recipe';
    include 'error.html.php';
    exit();
}
    $row = $s->fetch();
    
    $name = $row['name'];
    $id = $row['id'];
    
include 'confirm_delete.html.php';
exit();
}

if(isset($_POST['action']) and ($_POST['action']) == 'Yes')
{
    include '../includes/db.inc.php';
try
{
    $sql = 'DELETE FROM recipe WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindvalue(':id', $_POST['id']);
    $s->execute();
}
catch (PDOException $e)
{
    $output = 'Error deleting recipe';
    include 'error.html.php';
    exit();
}
    header('Location: .');
    exit();
}


if(isset($_GET['action']) and $_GET['action'] == 'search')
{
    include '../includes/db.inc.php';

$select = 'SELECT id, name';
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
    $recipes[] = array('id' =>$row['id'], 'text' =>$row['name']);
}
    //shows search results
    include 'recipe.html.php';
    exit();
}
    
    include '../includes/db.inc.php';
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
    include 'searchform.html.php';