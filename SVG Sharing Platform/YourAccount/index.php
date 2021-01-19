<?php
if (!isset($_COOKIE['userid']))
{
    header('Location: http://voltafy.co.uk/jakevolt/');
}
include '../includes/db.php';
include '../includes/navbar.php';

?>
<section class="uploadarea">
    <div class="accountdetails">
    <h1 class="headingya">Your Account Details</h1>
    <form action="" method="post">
    <?php 
    $userdata = loadYourAccount();
    foreach ($userdata as $data): ?>
    <h2 class="headingya">Username</h2>
    <input class="usertxt" type="text" name="username" value="<?php echo $data['username']; ?>">
    <div class="followerscont">
    <p class="followers">Followers: </p><h3 class="followerscount"><?php echo $data['followers']; ?></h3>
    </div>
    <div class="followerscont">
    <p class="followers">Following: </p><h3 class="followerscount"><?php echo $data['following']; ?></h3>
    </div>
    <h2 class="desch">Description</h2>
    <textarea class="desctxtaccount" name="description"><?php echo $data['desc']; ?></textarea>
    <button class="updatebtn" name="action" value="updateuser">Update Details</button>
    <button class="logoutbtn" name="action" value="logout">Sign Out</button>
    <button class="deletebtn" name="action" value="deleteuser">Delete Account</button>
    
    <?php endforeach; ?>
    </div>
    <div class="albumcont">
    <h3 class="headingya">Add an album</h3>
    <input class="albumtxt" type="text" name="albumname">
    <h3 class="headingya">Album Description</h3>
    <textarea class="descalbum" name="albumdesc"></textarea>
    <button name="action" class="addalbum" value="addalbum">Add</button>
    <h2 class="headingya">Your albums</h2>
    <?php $albumdata = loadYourAlbums();
    foreach ($albumdata as $adata):?>
    <a href="http://voltafy.co.uk/jakevolt/Album/?name=<?php echo $adata['id']; ?>">
    <div class="albums">
        <h3 class="albuml"><?php echo $adata['name']; ?></h3>
        <p class="adesc"><?php echo $adata['desc']; ?>
    </div>
    </a>
    <input type="hidden" name="albumid" value="<?php echo $adata['id']; ?>">
    <button class="deletealbum" name="action" value="deletealbum">Delete Album</button>
    <?php endforeach; ?>
    </div>
    </form>
</section>
<?php include '../includes/footer.php'; ?>