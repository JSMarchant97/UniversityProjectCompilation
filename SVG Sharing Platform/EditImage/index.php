<?php
if (!isset($_COOKIE['userid']))
{
    header('Location: http://voltafy.co.uk/jakevolt');
}
include '../includes/db.php';
include '../includes/navbar.php';
$data = loadImage();
$tags = loadTags();

?>
<section class="uploadarea">
<form action="" method="post">
<?php foreach ($data as $image): ?>
    <h1 class="uploadhead">Edit your file</h1>
    <output class="imageoutput" id="list"><?php echo $image['code']; ?></output>
    <h2 class="imagehead">Image Title</h2>
    <input type="text" name="titletxt" placeholder="Enter a title for your image" class="titletxt" value="<?php echo $image['name']; ?>">
    <h2 class="imagehead">Image Description</h2>
    <textarea placeholder="Enter a description of your image" class="desctxt" name="imagedesc"><?php echo $image['desc']; ?></textarea>
    <h2 class="imagehead">Alternate Text</h2>
    <input type="text" name="alttxt" placeholder="Enter alternative text for your image" class="alttxt" value="<?php echo $image['alt']; ?>">
    <h2 class="imagehead">Inappropriate Content</h2>
    <p class="inapcont">Mark if your content is not appropriate for all audiences:  </p><input type="checkbox" name="inappropriatecheck" value="1" class="inappropriatecheck" <?php if($image['age'] == 1){ echo 'checked'; } ?>>
    <h2 class="clhead">Creative Licensing</h2>
    <select class="cl" id="creativelicensing" name="cl">
        <option value="attribution">Attribution</option>
        <option value="attributionSAL">Attribution-ShareAlike</option>
        <option value="attributionND">Attribution-NoDerivs</option>
        <option value="attributionNC">Attribution-NonCommercial</option>
        <option value="attributionNCSAL">Attribution-NonCommercial-ShareAlike</option>
        <option value="attributionNCND">Attribution-NonCommercial-NoDerivs</option>
    </select>
    <h2 class="imagehead">Album</h2>
    <select class="cl" id="album" name="album">
    <?php $albums = loadAlbums(); 
    foreach ($albums as $album)
    {
        echo '<option value="' . $album['id'] . '">' . $album['name'] . '</option>';
    }
    ?> 
    </select>
    <h2 class="imagehead">Tags</h2>
    <input type="text" placeholder="Enter a tag" id="tagtxt" class="tagtxt"><input type="button" onclick="addTag()" name="action" value="Add">
    <div class="tagcontainer" id="tagcont">
    <input type="hidden" id="tagarray" name="tagarray">
        <script>
            var i = 0;
            var tagarray = [];
            function counttag()
            {
                i++;
                return i;
            }
            function addTag()
            {
                var tagtxt = document.getElementById("tagtxt");

                if(tagtxt.value == "" || i == 10)
                {
                    
                }
                else
                {
                    var tag = document.createElement("button");
                    tag.innerHTML = tagtxt.value;
                    tag.classList = "tag";
                    tag.id = "tag";
                    document.getElementById("tagcont").appendChild(tag);

                    tagarray.push(tagtxt.value);
                    
                    var jsonstring = JSON.stringify(tagarray);
                    document.getElementById("tagarray").value = jsonstring;
                }
                
            }
        </script>
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
    </div>
    <button name="action" value="updateimage" class="imagesubmitbtn">Update</button>
        <?php endforeach; ?>
</form>
</section>
<script src="../js/jsfunctions.js"></script>
<?php include '../includes/footer.php'; ?>