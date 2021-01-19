<?php
include '../includes/db.php';
include '../includes/navbar.php';
?>
<script>
    function showData(y)
    {
        y.classList.toggle("update");
    }
</script>
<section class="mainbody">
<form action="?" method="get">
<?php
    $albuminfo = AlbumInfo();
    $images = LoadAlbumData();
    foreach ($albuminfo as $info)
    {
        echo '<h1 class="albumtitle">' . $info['name'] . '</h1>';
        echo '<p class="albumdesc">' . $info['desc'] . '</p>';
    }
    if ($images != 0)
    {
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
    <script>
        var svg = document.getElementsByTagName("SVG");
    </script>
    <?php }
    }
    else
    {
        echo '<h1 class="albumtitle">There are no images in this album</h1>';
    }
    ?>
    </form>
</section>
<?php include '../includes/footer.php'; ?>