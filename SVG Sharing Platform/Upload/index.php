<?php
include '../includes/db.php';
include '../includes/navbar.php';
?>
<section class="uploadarea">
<form action="" method="post">
    <h1 class="uploadhead">Upload an SVG</h1>
    <output class="imageoutput" id="list"></output>
    <input type="hidden" id="imgcode" name="imgcode">
    <h2 class="imagehead">Select an image</h2>
    <p class="imagehead">Please ensure your image is optimised for use on this site, <a href="https://jakearchibald.github.io/svgomg/" target="_blank">Click here to optimise your image</a></p>
    <input type="file" class="fileupload" id="files" accept=".svg" required>
    <label for="files" class="file">Choose an Image</label>
    <p class="imgerror" id="imgerror">Image is not compatible with the website</p>
    <h2 class="imagehead">Image Title</h2>
    <input type="text" name="titletxt" placeholder="Enter a title for your image" class="titletxt" required>
    <h2 class="imagehead">Image Description</h2>
    <textarea placeholder="Enter a description of your image" class="desctxt" name="imagedesc" required></textarea>
    <h2 class="imagehead">Alternate Text <a href="https://webaim.org/techniques/alttext/" target="_blank"><i class="fas fa-question-circle"></i></a></h2>
    <input type="text" name="alttxt" placeholder="Enter alternative text for your image" class="alttxt" required>
    <h2 class="imagehead">Inappropriate Content</h2>
    <p class="inapcont">Mark if your content is not appropriate for all audiences:  </p><input type="checkbox" name="inappropriatecheck" value="1" class="inappropriatecheck">
    <h2 class="clhead">Creative Licensing <a href="https://creativecommons.org/licenses/" target="_blank"><i class="fas fa-question-circle"></i></a></h2>
    <select class="cl" id="creativelicensing" name="cl">
        <option value="Attribution">Attribution</option>
        <option value="Attribution-ShareAlike">Attribution-ShareAlike</option>
        <option value="Attribution-NoDerivs">Attribution-NoDerivs</option>
        <option value="Attribution-NonCommercial">Attribution-NonCommercial</option>
        <option value="Attribution-NonCommercial-ShareAlike">Attribution-NonCommercial-ShareAlike</option>
        <option value="Attribution-NonCommercial-NoDerivs">Attribution-NonCommercial-NoDerivs</option>
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
    </div>
    <button name="action" value="submitimage" class="imagesubmitbtn">Submit</button>
</form>
</section>
<script src="../js/jsfunctions.js"></script>
<?php include '../includes/footer.php'; ?>