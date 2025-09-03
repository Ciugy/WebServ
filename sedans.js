window.addEventListener("click", myFunction);

function myFunction() {
  document.getElementById("clicked").innerHTML = "You clicked randomly?";
}

function toggleOnOff() {
  var x = document.getElementById("carimages");
  x.classList.toggle("hidden");
}
