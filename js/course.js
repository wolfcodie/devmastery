let openNav = document.querySelector(".open_nav");
let left_Nav = document.querySelector(".left_nav");
let course_right = document.querySelector(".course_right");
let course_li = document.querySelectorAll("li");

openNav.addEventListener("click", () => {
  left_Nav.style.display = "block";
  course_right.style.opacity = "0.3";
  course_right.style.pointerEvents = "none";
});
course_li.forEach((li) => {
  if (window.innerWidth <= 768) {
    left_Nav.style.display = "none";
  }
  //   window.location.reload();
});
let settings = document.querySelector(".settings");
let adNew = document.querySelector(".adNew");
let userBox = document.querySelector(".user-box");
userBox.addEventListener("click", () => {
  console.log("yes");
  settings.classList.toggle("show");
});
// vannilla
let open_nav = document.querySelector(".open_nav");
let close_nav = document.querySelector(".close_nav");
let nav = document.querySelector("#mobile_nav");

//function
open_nav.addEventListener("click", () => {
  nav.style.display = "flex";
});
close_nav.addEventListener("click", () => {
  console.log("oui");
  nav.style.display = "none";
});
