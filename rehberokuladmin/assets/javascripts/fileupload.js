updateList = function() {
  var input = document.getElementById('upload');
  var output = document.getElementById('filename');

  output.innerHTML = '<ul>';
  for (var i = 0; i < input.files.length; ++i) {
    output.innerHTML += '<li>' + input.files.item(i).name + '</li>';
  }
  output.innerHTML += '</ul>';
}


$( "#upload-single" ).change(function() {
  var filename = this.value;
  var lastIndex = filename.lastIndexOf("\\");
  if (lastIndex >= 0) {
    filename = filename.substring(lastIndex + 1);
  }
  document.getElementById('filename-single').innerHTML = filename;
});


 
 


