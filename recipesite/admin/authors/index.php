<?php

if (isset($_GET['add']))
{
    $pageTitle = 'New Author';
    $action = 'addform';
    $name = '';
    $email = '';
    $id = '';
    $button = 'Add Author';
    
    include 'form.html.php';
    exit();
}

if (isset($_GET['addform']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'INSERT INTO recipeauthors SET name = :name, email = :email';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':email', $_POST['email']);
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
        $sql = 'SELECT author_id, name, email FROM recipeauthors WHERE author_id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $output = 'Error fetching author details' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    $row = $s->fetch();
    
    $pageTitle = 'Edit Author';
    $action = 'editform';
    $name = $row['name'];
    $email = $row['email'];
    $id = $row['author_id'];
    $button = 'Update Author';
    
    include 'form.html.php';
    exit();
}

if(isset($_GET['editform']))
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'UPDATE recipeauthors SET name = :name, email = :email WHERE author_id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':email', $_POST['email']);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $output = 'Error updating author details' . $e->getMessage();
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
    $sql = 'SELECT author_id, name FROM recipeauthors WHERE author_id = :id';
    $s = $pdo->prepare($sql);
    $s->bindvalue(':id', $_POST['id']);
    $s->execute();
}
catch (PDOException $e)
{
    $output = 'Error fetching author';
    include 'error.html.php';
    exit();
}
    $row = $s->fetch();
    
    $name = $row['name'];
    $id = $row['author_id'];
    
include 'confirm_delete.html.php';
exit();
}

if(isset($_POST['action']) and $_POST['action'] == 'Email')
{
    include '../includes/db.inc.php';
    try
    {
        $sql = 'SELECT email FROM recipeauthors WHERE author_id = :id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e)
    {
        $output = 'Error fetching author details' . $e->getMessage();
        include 'error.html.php';
        exit();
    }
    
    $row = $s->fetch();
    
    $pageTitle = 'Email Author';
    $action = 'mailform';
    $email = $row['email'];
    $button = 'Email Author';
    
    include 'mailform.html.php';
    exit();
}
if(isset($_POST['email']))
{
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    ini_set("sendmail_from", "jm1727g@gre.ac.uk");
    mail($email, $subject, $message);
        
    header('Location: .');
    exit();
}

if (isset($_GET['emailall']))
{
    $pageTitle = 'Email All Authors';
    $action = 'emailallform';
    $button = 'Email All';
    
    include 'mailallform.html.php';
    exit();
}

if(isset($_POST['messageall']))
{
    include '../includes/db.inc.php';
    
    try
    {
        $result = $pdo->query('SELECT * FROM recipeauthors');
    }
    catch (PDOException $e)
    {
        $output = 'Error fetching author details';
        include 'error.html.php';
        exit();
    }
    foreach ($result as $row)
    {
        $authors[] = array('id' => $row['author_id'],
                          'name' => $row['name'],
                          'email' => $row['email']);
    }
    
    ini_set("sendmail_from", "jm1727g@gre.ac.uk");
    foreach ($authors as $author)
    {
    mail($author['email'], $_POST['subjectall'], $_POST['messageall']);
    }
    header('Location: .');
    exit();
}

if(isset($_POST['action']) and ($_POST['action']) == 'Yes')
{
    include '../includes/db.inc.php';
try
{
    $sql = 'DELETE FROM recipeauthors WHERE author_id = :id';
    $s = $pdo->prepare($sql);
    $s->bindvalue(':id', $_POST['id']);
    $s->execute();
}
catch (PDOException $e)
{
    $output = 'Error deleting author';
    include 'error.html.php';
    exit();
}
    header('Location: .');
    exit();
}

include '../includes/db.inc.php';
try
{
    $result = $pdo->query('SELECT author_id, name FROM recipeauthors');
}
catch(PDOException $e)
{
    $output = 'Error fetching authors:' . $e->getMessage();
    //$output = 'Error fetching jokes:';
    include 'error.html.php';
    exit();
}

foreach ($result as $row)
{
    $authors[] = array('id' => $row['author_id'], 'name' => $row['name']);
}
include 'authors.html.php';
?>