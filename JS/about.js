const myButton = document.getElementById("myButton");

// Function to move the button to a specific position
function setButtonPosition(x, y) {
  myButton.style.left = x + "px";
  myButton.style.top = y + "px";
}

// Example: Move the button when clicked
myButton.addEventListener("click", () => {
  const newX = Math.random() * (window.innerWidth - myButton.offsetWidth);
  const newY = Math.random() * (window.innerHeight - myButton.offsetHeight);
  setButtonPosition(newX, newY);
});

// Example: Move the button on mouseover (e.g., to create an "unclickable" button)
myButton.addEventListener("mouseover", () => {
  const newX = Math.random() * (window.innerWidth - myButton.offsetWidth);
  const newY = Math.random() * (window.innerHeight - myButton.offsetHeight);
  setButtonPosition(newX, newY);
});

// Fetch text from a file and display it in an element with id "fetchy"
async function getText(file) {
  let myObject = await fetch(file);
  let myText = await myObject.text();
  document.getElementById("fetchy").innerHTML = myText;
}

