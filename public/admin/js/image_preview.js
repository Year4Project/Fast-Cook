
// image_preview.js
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('imagePreview');
        output.innerHTML = '<img src="' + reader.result + '" style="max-width:100%;max-height:100%;">';
    }
    reader.readAsDataURL(event.target.files[0]);
}
