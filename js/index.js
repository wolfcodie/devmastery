var tl = gsap.timeline();
// let title2 = tl.from("#loader_title", { opacity: 0, duration: 1 });

// tl.from("#loader_line", { width: "0px", duration: 1, ease: Power0.easeNone });

// tl.to("#loader_line", {
//   postion: "fixed",
//   duration: 1,
//   height: "100vh",
//   backgroundColor: "#14213d",
//   // ease: Power0.easeNone,
// });
// tl.to("#loader_title", { display: "none", opacity: 0, duration: 1 }, "-=2");
// tl.to(".loader", {
//   display: "none",
//   // opacity: 0,
//   // height: "0",
//   duration: 0.1,
//   ease: Power0.easeNone,
// });
tl.from("header", {
  y: "-100%",
  duration: 1.3,
  ease: Expo.easeOut,
});
tl.from(".hero_title", { y: "-100%", duration: 1 }, "-=0.2");
tl.from(".hero_subtitle", { y: "140%", duration: 1 }, "-=.5");
tl.from(".hero_btn", { y: "120%", duration: 1 }, "-=1");
tl.to(
  ".hero_img_container",
  {
    backgroundColor: "#0000",
    duration: 1,
  },
  "-=2"
);
tl.to(".hero_img_container", {
  clipPath: "polygon(100% 0, 0 0, 0 100%, 100% 100%)",
  duration: 1,
});
tl.from(".hero_img", { scale: 1.4, duration: 1 }, "-=1");

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

// // GSAP ScrollTrigger animation code
// gsap.registerPlugin(ScrollTrigger);

// const featureTitleContainer = document.querySelector(
//   ".features_title_container"
// );
// const features = gsap.utils.toArray(".features_grid article");
// const circle = document.querySelector(".feature_circle1");

// gsap.set(featureTitleContainer, { opacity: 0, y: 20 });
// gsap.set(features, { opacity: 0, y: 20 });

// gsap.to(featureTitleContainer, {
//   opacity: 1,
//   y: 0,
//   duration: 1,
//   scrollTrigger: { trigger: ".features", start: "top 80%" },
// });

// features.forEach((feature, index) => {
//   const line = feature.querySelector(".feature_line");

//   gsap.set(line, { scaleX: 0 });
//   gsap.set(feature, { opacity: 0, y: 20 });

//   gsap.to(line, {
//     scaleX: 1,
//     duration: 1,
//     scrollTrigger: { trigger: feature, start: "top 80%" },
//   });
//   gsap.to(feature, {
//     opacity: 1,
//     y: 0,
//     duration: 1,
//     scrollTrigger: { trigger: feature, start: "top 70%" },
//   });
// });

// // Move circle with scroll using gsap.utils.random()
// gsap.to(circle, {
//   y: () => `+=${gsap.utils.random(-100, 100)}`,
//   duration: 2,
//   ease: "power1.out",
//   scrollTrigger: {
//     trigger: ".features",
//     start: "top 10%",
//     end: "bottom 10%",
//     scrub: 0.5,
//   },
// });
// Select the course elements
// Select the course elements
// const courses = document.querySelectorAll(".course");

// // Set initial opacity and position for courses
// courses.forEach((course) => {
//   gsap.set(course, { opacity: 0, y: 50 });
// });

// // Create a timeline for the animation
// const timeline = gsap.timeline({
//   defaults: { duration: 1, ease: "power2.out" },
// });

// // Add animations to the timeline
// timeline
//   .from(".courses h2", { opacity: 0, y: -50 })
//   .from(".more_courses_btn", { opacity: 0, y: 50 }, "-=0.5");

// Create a ScrollTrigger for each course element
// courses.forEach((course) => {
//   gsap.registerPlugin(ScrollTrigger);

//   // Create a ScrollTrigger for the course element
//   const trigger = {
//     trigger: course,
//     start: "top 70%", // Adjust the start position as needed
//     end: "bottom 50%", // Adjust the end position as needed
//     toggleClass: "active",
//     onEnter: () => {
//       gsap.to(course, { opacity: 1, y: 0, duration: 0.5, ease: "power2.out" });
//     },
//   };

//   // Apply the ScrollTrigger to the course element
//   ScrollTrigger.create(trigger);
// });
let settings = document.querySelector(".settings");
let adNew = document.querySelector(".adNew");
let userBox = document.querySelector(".user-box");
userBox.addEventListener("click", () => {
  console.log("yes");
  settings.classList.toggle("show");
});
