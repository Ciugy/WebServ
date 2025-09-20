const backy = 

window.addEventListener("click", myFunction);

function myFunction() {
  document.getElementById("clicked").innerHTML = "You clicked randomly?";
}

// Instead of using block, I invoke a hidden class that sets display to none for 2.1.4
function toggleOnOff() {
  var x = document.getElementById("carimages");
  x.classList.toggle("hidden");
}

// Change button text on losing focus on the button, you have to click outside the button to see the change, click it 
// once then click outside the button for the last part
function ChangebtnText(elem) {
  elem.innerHTML = "Don't double click.";
}
