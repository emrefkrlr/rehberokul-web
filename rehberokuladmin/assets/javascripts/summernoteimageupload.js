//$(document).ready(function() {
//    $('#summernote').summernote({
//        placeholder: "Haber içeriği...",
//        height: 300,
//        callbacks: {
//            onImageUpload: function(files, editor, welEditable) {
//                for(var i = files.length - 1; i>=0; i--) {
//                    //sendFile(files[i], this);
//                }
//                //sendFile(files[0], editor, welEditable);
//            },
//            onMediaDelete : function(target) {
//                deleteFile(target[0].src);
//            }
//        }
//
//    });
//
//    function sendFile(file, el) {
//        var data_img = new FormData();
//        data_img.append("file", file);
//        $.ajax({
//            data: data_img,
//            type: "POST",
//            url: "ajaxrequest",
//            cache: false,
//            contentType: false,
//            processData: false,
//            success: function(url) {
//                $(el).summernote('editor.insertImage', url); //url resmin serverdaki urli
//            }
//        });
//    }
//
//
//    function deleteFile(src) {
//        $.ajax({
//            data: {src : src,
//                    token: $('#token').val()},
//            type: "POST",
//            url: "ajaxrequest/delete", // replace with your url
//            cache: false,
//            success: function(resp) {
//                console.log(resp);
//            }
//        });
//    }
//});
//

function CleanPastedHTML(input) {
  // 1. remove line breaks / Mso classes
  var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g;
  var output = input.replace(stringStripper, ' ');
  // 2. strip Word generated HTML comments
  var commentSripper = new RegExp('<!--(.*?)-->','g');
  var output = output.replace(commentSripper, '');
  var tagStripper = new RegExp('<(/)*(meta|link|span|\\?xml:|st1:|o:|font)(.*?)>','gi');
  // 3. remove tags leave content if any
  output = output.replace(tagStripper, '');
  // 4. Remove everything in between and including tags '<style(.)style(.)>'
  var badTags = ['style', 'script','applet','embed','noframes','noscript'];

  for (var i=0; i< badTags.length; i++) {
    tagStripper = new RegExp('<'+badTags[i]+'.*?'+badTags[i]+'(.*?)>', 'gi');
    output = output.replace(tagStripper, '');
  }
  // 5. remove attributes ' style="..."'
  var badAttributes = ['style', 'start'];
  for (var i=0; i< badAttributes.length; i++) {
    var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"','gi');
    output = output.replace(attributeStripper, '');
  }
  return output;
}

$(document).ready(function() {
    $('#summernote-kinder').summernote({
        placeholder: "Okul hakkında detaylı bilgi giriniz...",
        height: 300,
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            ['height', ['height']]
        ],

        fontNames: [
            'Arial', 'Arial Black', 'Comic Sans MS', 'Courier New',
            'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande',
            'Tahoma', 'Times New Roman', 'Verdana'
        ],


        callbacks: {
            onPaste: function(e) {
                var updatePastedText = function(){
                    var original = $('.summernote').summernote('code');
                    var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                    $('.summernote').summernote('code',cleaned); //this sets the displayed content editor to the cleaned pasted code.
                };
                setTimeout(function () {
                    //this kinda sucks, but if you don't do a setTimeout,
                    //the function is called before the text is really pasted.
                    updatePastedText();
                }, 10);

            }
        }
    });
});

$(document).ready(function() {

    $('#summernote-email').summernote({
        placeholder: "Mail içeriği giriniz...",
        height: 300,
        callbacks: {
            onPaste: function(e) {
                var updatePastedText = function(){
                    var original = $('.summernote').summernote('code');
                    var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                    $('.summernote').summernote('code',cleaned); //this sets the displayed content editor to the cleaned pasted code.
                };
                setTimeout(function () {
                    //this kinda sucks, but if you don't do a setTimeout,
                    //the function is called before the text is really pasted.
                    updatePastedText();
                }, 10);

            }
        }
    });
});


   /* Bütün stili yapıştırdığında silme    callbacks: {
            onPaste: function (e) {
                var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                e.preventDefault();
                bufferText = bufferText.replace(/\r?\n/g, '<br>');
                document.execCommand('insertHtml', false, bufferText);

            }
        }*/

