var svgData;

function checkFile(evt)
{
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) 
    {
        var reader = new FileReader();

        reader.onload = (function(theFile)
        {
            return function(e)
            {
                var usersvg = document.getElementsByTagName("svg")[0];
                if (usersvg == undefined)
                {
                    var span = document.createElement('span');
                    span.innerHTML = [e.target.result].join('');
                    svgData = [e.target.result].join('');
                    span.id = "preview";
                    document.getElementById('list').insertBefore(span, null);
                }
                
                var style = document.getElementsByTagName("style")[0];
                if (style == undefined)
                {
                    document.getElementById('imgcode').value = svgData;
                    document.getElementById("imgerror").style.display = "none";
                }
                else
                {
                    document.getElementById("imgerror").style.display = "block";
                    document.getElementById("preview").remove();
                }
            };
        })(f);
        reader.readAsText(f);
    }
}
    var el = document.getElementById('files');

    if(el)
    {
        el.addEventListener('change', checkFile, false);
    }