<?php

if (isset($_GET['add']))
{
    $pageTitle = 'New Category';
    $action = 'addform';
    $name = '';
    $email = '';
    $id = '';
    $button = 'Add Category';
    
    include 'form.html.php';
    exit();
}

if (isset($_GET['addform']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'INSERT INTO dishcategory SET name = :name';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $output = 'Error adding author'; 
        include 'error.html.php';
        exit();
    }
    header('Location: .');
    exit();
}

if(isset($_POST['action']) and $_POST['action'] == 'Edit')
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'SELECT id, name FROM dishcategory WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $output = 'Error fetching category details' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    $row = $s->fetch();
    
    $pageTitle = 'Edit Category';
    $action = 'editform';
    $name = $row['name'];
    $id = $row['id'];
    $button = 'Update Category';
    
    include 'form.html.php';
    exit();
}

if(isset($_GET['editform']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'UPDATE dishcategory SET name = :name WHERE id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->bindValue(':name', $_POST['name']);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $output = 'Error updating category details' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    header('Location: .');
    exit();
}

if(isset($_POST['action']) and $_POST['action'] == 'Delete')
{
    include '../includes/db.inc.php';
try
{
    $sql = 'SELECT id, name FROM dishcategory WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindvalue(':id', $_POST['id']);
    $s->execute();
}
catch (PDOException $e)
{
    $output = 'Error fetching category';
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
    $sql = 'DELETE FROM dishcategory WHERE id = :id';
    $s = $pdo->prepare($sql);
    $s->bindvalue(':id', $_POST['id']);
    $s->execute();
}
catch (PDOException $e)
{
    $output = 'Error deleting category';
    include 'error.html.php';
    exit();
}
    header('Location: .');
    exit();
}

include '../includes/db.inc.php';
try
{
    $result = $pdo->query('SELECT id, name FROM dishcategory');
}
catch(PDOException $e)
{
    $output = 'Error fetching categories:' . $e->getMessage();
    //$output = 'Error fetching jokes:';
    include 'error.html.php';
    exit();
}

foreach ($result as $row)
{
    $categories[] = array('id' => $row['id'], 'name' => $row['name']);
}
include 'category.html.php';
?>