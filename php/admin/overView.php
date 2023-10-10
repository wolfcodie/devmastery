<?php 
include("../includes/db.php");
session_start();
if (isset($_SESSION['admin_id'])) {
  $admin_name = $_SESSION['admin_name'];
  $admin_age = $_SESSION['admin_age'];
  $admin_email = $_SESSION['admin_email'];
  $admin_password = $_SESSION['admin_password'];
  if (isset($_POST['logout_btn'])) {
    session_destroy();
    header("location:../login.php");
  }
}else{
  header("location:../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- font awesome icones -->
    <link
      href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Bungee&family=Raleway:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <!-- google fonts end  -->
    <link rel="stylesheet" href="../../styles/admin_dash.css?v=<?php echo time(); ?>" />
    <title>Dashboard || devmastery</title>
  </head>
  <body>
    <nav class="left_nav">
      <div class="logo">
        <!-- <img src="../project_images/logo.png" alt="" /> -->
        <h1>DEV <br />MASTERY</h1>
      </div>
      <ul class="m-0">
        <li>
          <a href="../../index.php"
            ><i class="fa-solid fa-house fa-shake"></i>
            <span class="nav_content">Home</span>
          </a>
        </li>
        <li class="active_navBtn">
          <a href="./overView.php"
            ><i class="fa-solid fa-user fa-bounce"></i>
            <span class="nav_content">Overview</span></a
          >
        </li>
        <li>
          <a href="./courses_admin.php"
            ><i class="fa-solid fa-list"></i>
            <span class="nav_content">Courses</span></a
          >
        </li>
      
      </ul>
    </nav>
    <main>

      <header class="flex">
        <h4>Welcome admin</h4>

        <div class="user-box">
          <img class="user_img" src="../../assets/user.jpg" alt="user Image" />
          <span><?php echo $admin_name?></span>
          <i class="fa-solid fa-arrow-down fa-bounce arrow_down"></i>
          <form method="post" class="settings">
            <button name="logout_btn" class="btn btn-danger">Log Out</button>
          </form>
        </div>
      </header>
      <section class="main_admin flex">
        <article class="left">
          <img src="../../assets/admin_bg.png" alt="" />
          <h1>Create Your Future</h1>
        </article>
      
      </section>
      <section class="message_section">
        <h5>Messages <i class="fa-solid fa-arrow-right fa-beat-fade"></i></h5>
        <div class="messages flex">
          <article class="message">
            <div class="message_top flex">
              <img src="../../assets/user.jpg" alt="user" />
              <p class="user_message_info">
                karim elalaoui <br />
                kairm@gmail.com
              </p>
              <i class="fa-solid fa-quote-right fa-shake"></i>
            </div>
            <p>
              Lorem, ipsum dolor sit amet consectetur adipisicing elit.
              Veritatis praesentium tenetur aliquid perspiciatis facilis sit
              quam voluptatibus repellat? Quia molestiae aliquid quidem corporis
              quae, dantium fugit distinctio? Officia, autem.
            </p>
          </article>
          <article class="message">
            <div class="message_top flex">
              <img src="../../assets/user.jpg" alt="user" />
              <p class="user_message_info">
                karim elalaoui <br />
                kairm@gmail.com
              </p>
              <i class="fa-solid fa-quote-right fa-shake"></i>
            </div>
            <p>
              Lorem, ipsum dolor sit amet consectetur adipisicing elit.
              Veritatis praesentium tenetur aliquid perspiciatis facilis sit
              quam voluptatibus repellat? Quia molestiae aliquid quidem corporis
              quae, dolorem ad rem saepe inventore iste explicabo maiores
              pariatur doloremque similique accusantium fugit distinctio?
              Officia, autem.
            </p>
          </article>
          <article class="message">
            <div class="message_top flex">
              <img src="../../assets/user.jpg" alt="user" />
              <p class="user_message_info">
                karim elalaoui <br />
                kairm@gmail.com
              </p>
              <i class="fa-solid fa-quote-right fa-shake"></i>
            </div>
            <p>
              Lorem, ipsum dolor sit amet consectetur adipisicing elit.
              Veritatis praesentium tenetur aliquid perspiciatis facilis sit
              quam voluptatibus repellat? Quia molestiae aliquid quidem corporis
              quae, dolorem ad rem saepe inventore iste explicabo maiores
              pariatur doloremque similique accusantium fugit distinctio?
              Officia, autem.
            </p>
          </article>
        </div>
      </section>
    </main>
    <section class="edit_profile_popUp">
      <form  method="post">
        <button class="close_pop">X</button>
        <h3>Edit My Profile</h3>
        <input placeholder="Full Name" type="text" />
        <input placeholder="Age" type="text" />
        <input placeholder="Email" type="text" />
        <input placeholder="Password" type="password" />
        <p class="error">Password Required !!</p>
        <!-- <input placeholder="Password Repeat" type="password" /> -->
        <!-- <p>Forgot Password ?</p> -->
        <button>Submit<i class="fa-solid fa-arrow-right fa-shake"></i></button>
      </form>
    </section>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"
      integrity="sha512-cOH8ndwGgPo+K7pTvMrqYbmI8u8k6Sho3js0gOqVWTmQMlLIi6TbqGWRTpf1ga8ci9H3iPsvDLr4X7xwhC/+DQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script src="../../js/admin_dash.js?v=<?php echo time(); ?>"></script>
  </body>
</html>
