<?php 

include("./includes/auth.php");
session_start();
if (isset($_SESSION['admin_id'])) {
  header("location:./admin/overView.php");
}
if (isset($_SESSION['user_id'])) {
  header("location:./members/overview.php");
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Bungee&family=Raleway:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="../styles/login_sign.css?v=<?php echo time(); ?>" />
    <title>Sign Up to DEVMASYTERY</title>
  </head>
  <body>
    <div class="login_page">
      <h1>Sign Up to devmastery</h1>
      <a href="../index.php" class="close_login_page">Back to Home</a>
      <img class="login_bg" src="../assets/loginbg.png" alt="" />
      <form  method="post">
          <input placeholder="Full Name" type="text" name="fullName" value=<?php if (isset($user_name)) {
            echo $user_name;}?> >
          <input placeholder="Age" type="text" name="age" value=<?php if (isset($user_age)) {
            echo $user_age;}?> >
          <input placeholder="Email" type="text" name="email"  value=<?php if (isset($user_email)) {
            echo $user_email;}?> >  
          <input placeholder="Password" type="password" name="password" value=<?php if (isset($user_password)) {
            echo $user_password;}?> >
          <input placeholder="Password Repeat" type="password" name="passwordRepeat" value=<?php if (isset($user_passwordRepeat)) {echo $user_passwordRepeat;}?> >
          <div class="error">
            <?php if ($error) {echo '<p class="error_messsage">'.$error.' </p>';}?>
            <?php if ($succes) {echo '<p class="succes_messsage">'.$succes.' </p>';}?>
          </div>
      <button name='signUpBtn' >Sign Up</button>
              <p>Have an account? <a href="./login.php">Login</a></p>
    </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script>
      
    </script>
    <script>
      // GSAP animation code
      gsap.set(".login_page", { opacity: 0, scale: 0.2 }); // Initial state

      gsap.to(".login_page", {
        opacity: 1,
        scale: 1,
        duration: 1,
        ease: "elastic.out(1, 0.5)",
        delay: 0.5,
      }); // Elastic animation to scale and fade in the login page

      gsap.from("h1", {
        opacity: 0,
        y: -50,
        duration: 0.6,
        delay: 1,
        ease: "back.out(1.7)",
      }); // Slide up and bounce animation for the heading

      gsap.from("form", {
        opacity: 0,
        y: 50,
        duration: 0.6,
        delay: 1.2,
        ease: "power4.out",
      }); // Slide up animation for the form

      gsap.from(".login_bg", {
        opacity: 0,
        duration: 0.6,
        delay: 0.8,
        ease: "power2.out",
      }); // Fade in animation for the login background image

      const errorMessage = document.querySelector('.error');
          gsap.fromTo(
            errorMessage,
            { opacity: 0, scale: 0 },
            { opacity: 1, scale: 1, duration: 0.5, ease: 'back.out(1.7)' });
    </script>
  </body>
</html>
