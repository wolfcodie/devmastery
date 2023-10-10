let settings = document.querySelector(".settings");
let adNew = document.querySelector(".adNew");
let userBox = document.querySelector(".user-box");
userBox.addEventListener("click", () => {
  console.log("yes");
  settings.classList.toggle("show");
});

let open_edit_pop = document.querySelector(".open_edit_pop");
let close_pop = document.querySelector(".close_pop");
let edit_profile_popUp = document.querySelector(".edit_profile_popUp");

var tl = gsap.timeline();

open_edit_pop.addEventListener("click", () => {
  tl.to(".edit_profile_popUp", {
    ease: "bounce.out",
    clipPath: "polygon(0.1% 0.1%, 99.9% 0.1%, 99.9% 99.9%, 0.1% 99.9%)",
  });
  // edit_profile_popUp.style.clipPath = "polygon(0 0, 100% 0, 100% 100%, 0 100%)";
});
close_pop.addEventListener("click", (e) => {
  e.preventDefault();
  tl.to(".edit_profile_popUp", {
    ease: "bounce.out",
    clipPath: " polygon(50% 41%, 57% 41%, 57% 41%, 50% 41%)",
  });
});

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
