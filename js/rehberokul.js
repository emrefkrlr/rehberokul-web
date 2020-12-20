window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
  	$('#upToTopButton').css('display', 'block');
  	$('#ownerArea').css('display', 'block');
  } else {
  	$('#upToTopButton').css('display', 'none');
  	$('#ownerArea').css('display', 'none');
  }
}

// When the user clicks on the button, scroll to the top of the document
function upToPageTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}


var sssAcc = document.getElementsByClassName("sss-accordion");
var i;

for (i = 0; i < sssAcc.length; i++) {
  sssAcc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var sssPanel = this.nextElementSibling;
    if (sssPanel.style.display === "block") {
      sssPanel.style.display = "none";
    } else {
      sssPanel.style.display = "block";
    }
  });
}

