<?php
if (!isset($_GET['image']))
{
    header('Location: http://voltafy.co.uk/jakevolt/');
}
include '../includes/db.php'; 
include '../includes/navbar.php';
$i = 1;
$data = loadImage();
$tags = loadTags();
if (isset($_COOKIE['userid']))
{
    $checklikes = checklikes();
    $checkdislikes = checkdislikes();
    $likeid = likeid();
    $dislikeid = dislikeid();
}

$comments = viewcomments();
foreach ($data as $image):
?>
<form action="" method="post">
<input type="hidden" name="imageid" value="<?php echo $image['id']; ?>">
<section class="mainbody">
    <div class="imginfo">
        <h1 class="imgtitle"><?php echo $image['name']; ?></h1>
        <?php
        if ($image['accid'] == $_COOKIE['userid'])
        {
            echo '
            <div onmouseover="showInfo()" onmouseout="hideInfo()" class="optionsViewImage"><i class="fa fa-ellipsis-v"></i></div>
            <div id="editpopup" onmouseover="showInfo()" onmouseout="hideInfo()" class="editpopup">
                <button class="editimage" name="action" value="editimage">Edit</button>
                <button class="deleteimage" name="action" value="deleteimage">Delete</button>
            </div>
            <script>
                function hideInfo()
                {
                    document.getElementById("editpopup").style.display = "none";
                }
                hideInfo();
                function showInfo()
                {
                    document.getElementById("editpopup").style.display = "block";
                }
            </script>';
        }
        
        ?>
        <a href="http://voltafy.co.uk/jakevolt/Account/?id=<?php echo $image['accid']; ?>"><h1 class="imguser"><?php echo $image['user']; ?></h1></a>
    </div>
    <div id="imagecode" class="imagecont">
        <?php echo $image['code']; ?>
    </div>
    <div class="imagedesc">
        <p class="ratingcounter"><?php echo $image['likes'] - $image['dislikes']; ?></p>
        <?php
            if($checklikes == 1)
            {
                echo '<button name="action" value="removelike" class="likedbtn">Like <i class="fa fa-thumbs-up"></i></button>';
                echo '<input type="hidden" name="likecheck" value="true">';
                foreach ($likeid as $id)
                {
                    echo '<input type="hidden" name="likeID" value="' . $id['id'] . '">';
                }
                
            }
            else if (!isset($_COOKIE['userid']))
            {
                echo '<button href="http://voltafy.co.uk/jakevolt/Login/" class="likebtn">Like <i class="fa fa-thumbs-up"></i></button>';
            }
            else
            {
                echo '<button name="action" value="like" class="likebtn">Like <i class="fa fa-thumbs-up"></i></button>';
                echo '<input type="hidden" name="likecheck" value="false">';
            }

            if($checkdislikes == 1)
            {
                echo '<button name="action" value="removedislike" class="dislikedbtn">Dislike <i class="fa fa-thumbs-down"></i></button>';
                echo '<input type="hidden" name="dislikecheck" value="true">';
                foreach ($dislikeid as $id)
                {
                    echo '<input type="hidden" name="dislikeID" value="' . $id['id'] . '">';
                }
            }
            else if (!isset($_COOKIE['userid']))
            {
                echo '<button href="http://voltafy.co.uk/jakevolt/Login/" class="dislikebtn">Dislike <i class="fa fa-thumbs-down"></i></button>';
            }
            else
            {
                echo '<button name="action" value="dislike" class="dislikebtn">Dislike <i class="fa fa-thumbs-down"></i></button>';
                echo '<input type="hidden" name="dislikecheck" value="false">';
            }
        ?>
        <button class="downloadbtn" onclick="saveDynamicDataToFile()">Download<i class="fa fa-download"></i></button>
        <script>
            function saveDynamicDataToFile() 
            {
                var blob = new Blob([document.getElementById("imagecode").innerHTML], { type: "text/plain;charset=utf-8" });
                saveAs(blob, "image.svg");
            }
        </script>
            <div class="descheadcont">
            <h2 class="deschead">Description:</h2>
            <p class="date">Posted on: 02/04/2020</p>
            </div>
        <p class="desc"> <?php echo $image['desc']; ?> </p>
        <p class="creativeLicense"><a href="https://creativecommons.org/licenses/"><i class="fas fa-question-circle"></i></a> Usage Rights: <?php echo $image['cl'] ?></p>
        <p class="albumlink">From Album: <a href="http://voltafy.co.uk/jakevolt/Album/?name=<?php echo $image['albumID']; ?>"><?php echo $image['album']; ?></a></p>
        <div class="taglist">
        <h3 class="taghead">Tags:</h3>
        <?php 

        if ($tags != 0)
        {
            foreach ($tags as $tagname)
            {
                echo '<button class="tag">' . $tagname['tagname'] . '</button>';
            }
        }
        else
        {
            echo 'No tags added';
        }

        ?>
        <h3 class="commenthead">Comments:</h3>
            <div class="commentsubmit">
                <input type="text" name="commenttxt" placeholder="Submit a comment" class="commentsubtxt">
        <?php
            if (isset($_COOKIE['userid']))
            {
                echo '<button class="commentsubbtn" name="action" value="subcomment">Submit</button>';
            }
            else
            {
                echo '<button class="commentsubbtn">Submit</button>';
            }
        ?>
            </div>
        </form>
        <div class="comments">
            <?php
            if ($image['commentcount'] == 0)
            {
                echo '<h4 class="commentuser">No comments have been made</h4>';
            }
            else
            {
                foreach ($comments as $comment):?>
                <div class="comment">
                    <form action="" method="post">
                    <h4 class="commentuser"><?php echo $comment['username']; ?></h4>
                    <p class="commenttext"><?php echo $comment['comment']; ?></p>
                    <input type="hidden" name="cid" value="<?php echo $comment['id']; ?>">
                    <?php 
                    
                    if ($_COOKIE['userid'] == $comment['accid'])
                    {
                        echo '<div id="commentoptions" onmouseover="showcommentInfo' . $i . '()" onmouseout="hidecommentInfo' . $i . '()"><i class="fa fa-ellipsis-v"></i></div>';
                        echo '<button name="action" value="deletecomment" class="deletecommentbtn" id="deletecommentbtn' . $i . '" onmouseover="showcommentInfo' . $i . '()" onmouseout="hidecommentInfo' . $i . '()">Delete comment</button>';
                        echo '
                        <script>
                        function showcommentInfo' . $i . '()
                        {
                            document.getElementById("deletecommentbtn' . $i . '").style.display = "block";
                        }
                
                        function hidecommentInfo' . $i . '()
                        {
                            document.getElementById("deletecommentbtn' . $i . '").style.display = "none";
                        }
                        </script>
                        ';

                        $i++;
                    }
                    ?>
                    </form>
                </div>
                <?php endforeach;
            } ?>
            </div>
        </div>
        </div>
    </div>
</section>
<?php endforeach; ?>
<?php include '../includes/footer.php'; ?>