const searchInput = document.getElementById("searchInput");
searchInput.addEventListener("input", (event) => {
  autocomplete(event.target.value);
});

async function autocomplete(query) {
  const dropdown = document.getElementById("dropdown");
  if (!query) {
    dropdown.innerHTML = "";
    dropdown.style.display = "none";
    return;
  }

  dropdown.innerHTML = "";

  fetch("filterusers.php?query=" + encodeURIComponent(query), {
    headers: { "X-Requested-With": "XMLHttpRequest" },
  })
    .then((response) => response.text())
    .then((data) => {
      console.log(data, "data");
      const parser = new DOMParser();
      const document_result = parser.parseFromString(data, "text/html");
      const users = document_result.getElementsByClassName("user-result");
      console.log(users, "users");

      if (users.length === 0) {
        dropdown.style.display = "none";
        return;
      }

      // Inspiration https://codepen.io/jaredgroff/pen/bGxJaXe
      Array.from(users).forEach((userElem) => {
        let text = userElem.innerText;
        let anchor = document.createElement("a");
        anchor.textContent = text;
        anchor.classList.add("dropdown-item");
        anchor.onclick = () => {
          searchInput.value = userElem
            .querySelector("strong")
            .nextSibling.textContent.trim();
          dropdown.style.display = "none";
        };
        dropdown.appendChild(anchor);
      });

      dropdown.style.display = "block";
    });
}
