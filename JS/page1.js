const slider = document.getElementById("myRange");
const output = document.getElementById("demo");
const text = document.getElementById("TextInSlider");

output.textContent = slider.value;

slider.addEventListener("input", function () {
  output.textContent = this.value; // Update number on screen
  this.setAttribute("value", this.value); // Ensures form submission reflects current position

  if (this.value > 50) {
    text.textContent = "Good, Better";
  } else {
    text.textContent = "Terrible, Bad";
  }
});
