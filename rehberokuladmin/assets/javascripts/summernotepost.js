$(window).on('load', function() {
   $( ".note-editable" ).focusout( function() {
       document.getElementById('hidden-field').value = $('.summernote').summernote('code');
    }); 
})


var frmEmail = document.getElementById("email-form");
    if(frmEmail){
        frmEmail.onsubmit = function() {
            if ($('#summernote-email').summernote('isEmpty')) {
                alert("Mail içeriği Girmediniz!");
                return false;
            }
    }
};









