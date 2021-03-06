<?php
#Include Decision function that checks if user is still logged in and dericts him to log in form, registration or main
include_once "nav_bar.php";
?>


<!DOCTYPE html>
<html>
<head>
<title>Forum Discussion</title>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <!--To allow MS Edge and IE -->  
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
    <!-- ADD ICON LIBRARY -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="styles2.css">   
    <style>
    
        .display-4 {
            
            font-size: 50px;
        }
    </style>
</head>

<body>
   
    <br>
    
    <!--PAGE TITLE/HEADER--> 
    <h1> Tea point upgrade discussion</h1>
    <p style="text-align: center"><a href="ideasubmission.html">Go back</a></p> <!-- href redirect to previous page -->
    <br>
    
    
    
     <form> <!-- form action="" method="post" -->                
    <div class="Jumbotroncentral">
        
    <div class="jumbotron">
    <h3 class="display-9">Tea point upgrade discussion</h3>
    <p class="display-9"> Jacques</p>    
    <p class="lead">Un soir, un petit villageois alla puiser de l’eau dans un vieux puits au cœur de la ville basse. En remontant le seau de bois, il vit quelque chose briller au fond. C’étaient des pièces d'or.</p>

         
  <button style="font-size:14px"> 15 <i class="fa fa-thumbs-up"></i></button>
  <button style="font-size:14px"> 5 <i class="fa fa-thumbs-down"></i></button>    
  <button style="font-size:14px"> <i class="fa fa-commenting-o"></i></button> 
  <button style="font-size:14px"> Example paper <i class="fa fa-download"></i></button>  
     
        
    <!-- COMMENT SECTION -->        
   <hr class="my-4"> 
   <h5>StaffName</h5>          
   <p>Elle court, elle court La maladie d'amour. Elle court, elle court La maladie d'amour. Elle court, elle court La maladie d'amour.</p>
        
    <hr class="my-4"> 
   <h5>StaffName</h5>          
   <p>Elle court, elle court La maladie d'amour. Elle court, elle court La maladie d'amour. Elle court, elle court La maladie d'amour.</p>


    <!-- ADD A COMMENT -->
    <hr class="my-4">
    <div class="row">
    <div class="col-sm-9">
    <div class="form-group">
  
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="Type here..."></textarea>
    </div>           
              
    </div>
    <div class="col-3">
    <button type="button" class="btn btn-light">Submit Comment</button>
    </div>        
  </div>
       
</div>
</div>  

    </form>


<?php
?>

