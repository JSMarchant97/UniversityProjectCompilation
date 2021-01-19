<?php
include '../includes/db.php';
include '../includes/navbar.php';
?>
<section class="uploadarea">
    <div class="accountdetails">
    <form action="" method="post">
    <?php 
    $userdata = loadAccountDetails();
    foreach ($userdata as $data): ?>
    
    <h2 class="headingya">Username:</h2>
    <h3 class="headingya"><?php echo $data['username']; ?></h3>
    <div class="followerscont">
    <p class="followers">Followers: </p><h3 class="followerscount"><?php echo $data['followers']; ?></h3>
    </div>
    <div class="followerscont">
    <p class="followers">Following: </p><h3 class="followerscount"><?php echo $data['following']; ?></h3>
    </div>
    <h2 class="desch">Description:</h2>
    <p class="descaccount" name="description"><?php echo $data['desc']; ?></p>
    <?php 
    if (isset($_COOKIE['userid']))
    {
        $followcheck = checkFollow();
    }
    

    if ($followcheck == 0)
    {
        echo '<button class="followbutton" name="action" value="followuser">Follow</button>';
    }
    else if ($followcheck == 1)
    {
        echo '<button class="unfollowbutton" name="action" value="unfollowuser">Unfollow</button>';
    }
    else if (!isset($_COOKIE['userid']))
    {

    }
    ?>
    
    </div>
    <div class="albumcont">
    <h2 class="headingya"><?php echo $data['username'];?>'s Albums</h2>
    <?php endforeach;
    $albumdata = loadAccountAlbums();
    foreach ($albumdata as $adata):?>
    <a href="http://voltafy.co.uk/jakevolt/Album/?name=<?php echo $adata['id']; ?>">
    <div class="albums">
        <h3 class="albuml"><?php echo $adata['name']; ?></h3>
        <p class="adesc"><?php echo $adata['desc']; ?>
    </div>
    </a>
    <?php endforeach; ?>
    </div>
    </form>
</section>

<?php include '../includes/footer.php'; ?>