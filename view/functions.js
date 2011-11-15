/* Javascript */

function getFilename(id)
{
    var fullPath = document.getElementById(id).value;
    if (fullPath) {
            var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
            var filename = fullPath.substring(startIndex);
            if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                    filename = filename.substring(1);
            }
			
			//console.log("Filename:"+ filename);
			return(filename);
    }
}

function changeUploadText(newtext)
{
    document.getElementById("uploadText").innerHTML = "<span class='filename'>" + newtext + "</span><span class='upload'>Ladda upp</span>";
    return true;
}

function selectAll(id)
{
    document.getElementById(id).focus();
    document.getElementById(id).select();
}