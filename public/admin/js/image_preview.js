
// image_preview.js
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('imagePreview');
        output.innerHTML = '<img src="' + reader.result + '" style="max-width:100%;max-height:100%;">';
    }
    reader.readAsDataURL(event.target.files[0]);
}



// function toggleDescription(element) {
//     var description = element.parentNode.previousSibling;
//     description.classList.toggle('full-description');
//     if (description.classList.contains('full-description')) {
//         element.innerHTML = 'Read less';
//     } else {
//         element.innerHTML = 'Read more';
//     }
// }


// delete script elements
function confirmation(ev) {
    ev.preventDefault();

    var urlToRedirect = ev.currentTarget.getAttribute('href');

    console.log(urlToRedirect);

    swal({

         title:"Are You Sure To Delete This",
         text: "This delete will be parmanent",
         icon: "warning",
         buttons: true,
         dangerMode: true,
    })

    .then((willCancel)=>{
     if(willCancel){
         window.location.href = urlToRedirect;
     }
     else{
         swal("Your Data is safe");
     }
    })
 }
