<?php
include 'includes/db.php';
include 'includes/navbarhome.php';
?>
<script>
    function showData(y)
    {
        y.classList.toggle("update");
    }
        var svg = document.getElementsByTagName("SVG");
    </script>
<section class="mainbody">
    <h1 class="vlhead">Welcome to VectorLibrary!</h1>
    <p class="vlp">VectorLibrary is a place for designers and developers to share, download and discuss all things SVG!</p>
<form action="?" method="get">
<?php
    $images = loadImagesHome();
    foreach($images as $image)
    {
?>
    <a onfocus="showData(this)" onfocusout="showData(this)" href="http://voltafy.co.uk/jakevolt/viewImage/?image=<?php echo $image['id']; ?>">
    <div class="imgcontainer" onfocus="showData(this)" onmouseover="showData(this)" onmouseout="showData(this)">
    <?php echo $image['code'];?>
    <?php 
        if ($image['age'] == 1)
        {
            echo '<p class="imgblurtxt">image marked as inappropriate content, proceed with caution</p>';
            echo '<img src="http://voltafy.co.uk/jakevolt/images/blur.png" class="imgblur">';
        }
    ?>
    <div class="imghover">
        <p class="viewmore">Click to view more</p>
        <p class="imgtxt"><?php echo $image['title'];?></p>
        <p class="imgtxt"><?php echo $image['user'];?></p>
    </div>
    </div>
    </a>
    <?php } 
    
    ?>
    <input type="hidden" name="page" value="<?php 
    if(!isset($_GET['page']))
    {
        echo 2;
    }
    else
    {
        echo $_GET['page'] + 1;
    }
    
    ?>">

<?php if (isset($_POST['limit']) and $_POST['limit'] == true)
    {
        echo '<input type="button" class="nomoreimages" value="No more images">';
    }
    else
    {
        echo '<button class="loadmore">Load More</button>';
    }
    ?>
    
    </form>
</section>
<?php include 'includes/footer.php'; ?>