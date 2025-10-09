var slider = document.getElementById("myRange");
var output = document.getElementById("demo");
output.innerHTML = slider.value; // Display the default slider value

// Update the current slider value, updates the text as the slider is moved for 2.1.6.1
slider.oninput = function () {
  output.innerHTML = this.value;
  if (output.innerHTML > 50) {
    document.getElementById("TextInSlider").innerHTML = "Good, Better";
  } else document.getElementById("TextInSlider").innerHTML = "Terrible, Bad";
};
