const sidebar = document.querySelector(".sidebar");
const closeBtn = document.querySelector("#btn");

function openNav() {
  // If localStorage is supported by the browser
  if (typeof Storage !== "undefined") {
    // Save the state of the sidebar as "open"
    localStorage.setItem("sidebar", "open");
  }
}

function closeNav() {
  // If localStorage is supported by the browser
  if (typeof Storage !== "undefined") {
    // Save the state of the sidebar as "closed"
    localStorage.setItem("sidebar", "closed");
  }
}

function menuBtnChange() {
  if (sidebar.classList.contains("open")) {
    closeBtn.classList.replace("bx-arrow-to-right", "bx-arrow-to-left");
  } else {
    closeBtn.classList.replace("bx-arrow-to-left", "bx-arrow-to-right");
  }
}

closeBtn.addEventListener("click", function () {
  if (sidebar.classList.toggle("open")) {
    openNav();
  } else {
    closeNav();
  }

  menuBtnChange();
});