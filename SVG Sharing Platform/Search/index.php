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
<h1 class="searchhead">Search results for: <?php echo $_GET['term']; ?></h1>
<form action="" method="get">
<select name="sort">
    <option value="1">New - Old</option>
    <option value="2">Old - New</option>
    <option value="3">Most Popular</option>
    <option value="4">Least Popular</option>
</select>
<input type="hidden" name="term" value="<?php echo $_GET['term']; ?>">
<button name="action" value="updatesearch">Update</button>
</form>
<form action="?" method="get">
<?php
    if (!isset($_GET['sort']))
    {
        $search = searchResults();
    }
    else if ($_GET['sort'] == 1)
    {
        $search = searchResults();
    }
    else if($_GET['sort'] == 2)
    {
        $search = searchResultsDesc();
    }
    else if($_GET['sort'] == 3)
    {
        $search = searchResultsMP();
    }
    else if($_GET['sort'] == 4)
    {
        $search = searchResultsLP();
    }
    
    if (count($search) != 0)
    {
        foreach($search as $s)
        {
?>
    <a onfocus="showData(this)" onfocusout="showData(this)" href="http://voltafy.co.uk/jakevolt/viewImage/?image=<?php echo $s['id']; ?>">
    <div class="imgcontainer" onfocus="showData(this)" onmouseover="showData(this)" onmouseout="showData(this)">
    <?php echo $s['code'];?>
    <?php 
        if ($s['age'] == 1)
        {
            echo '<p class="imgblurtxt">image marked as inappropriate content, proceed with caution</p>';
            echo '<img src="http://voltafy.co.uk/jakevolt/images/blur.png" class="imgblur">';
        }
    ?>
    <div class="imghover">
        <p class="viewmore">Click to view more</p>
        <p class="imgtxt"><?php echo $s['title'];?></p>
        <p class="imgtxt"><?php echo $s['user'];?></p>
    </div>
    </div>
    </a>
    <?php }
    }
    else
        echo '<h1 class="searchhead">No results matching search term</h1>'
    ?>
    </form>
</section>              
<?php include '../includes/footer.php'; ?>