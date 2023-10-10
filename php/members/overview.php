<?php 
include("../includes/db.php");
session_start();
if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $user_name = $_SESSION['user_name'];
  $user_age = $_SESSION['user_age'];
  $user_email = $_SESSION['user_email'];
  $user_password = $_SESSION['user_password'];
  if (isset($_POST['logout_btn'])) {
    session_destroy();
    header("location:../login.php");
  }
      $query = $conn->prepare("SELECT favorite.*, courses.*, member.*
      FROM favorite
      JOIN courses ON favorite.crs_id = courses.crs_id
      JOIN member ON favorite.mem_id = member.mem_id
      WHERE favorite.mem_id = :mem_id");

    $query->bindParam(':mem_id', $user_id);
    $query->execute();

}else{
  header("location:../login.php");
}
    $error = '';
    if (isset($_POST['submit'])) {
      $full_name = $_POST['full_name'];
      $age = $_POST['age'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      if (empty($full_name) || empty($age) || empty($email) || empty($password)) {
        $error = "All input fields are required.";
      } 
      if ($error == '') {
        if (password_verify($password , $user_password)) {
           
              // Update the table
              $query = $conn->prepare("UPDATE `member` SET `mem_name` = :full_name, `mem_age` = :age, `mem_email` = :email WHERE `mem_id` = :mem_id");
              $query->bindParam(':full_name', $full_name);
              $query->bindParam(':age', $age);
              $query->bindParam(':email', $email);
              $query->bindParam(':mem_id', $user_id);

              if ($query->execute()) {
                session_destroy();
                header("location:../login.php");
                echo '<p class="secces_p">Profile Updated</p>';
                // echo "Profile updated successfully!";
              } 
          }else{
            
          }
        } else {
          // Password is incorrect
        
          $error =  "Password is incorrect.";
        }
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
    <link rel="stylesheet" href="../../styles/member.css?v=<?php echo time(); ?>" />
    <title>Dashboard || devmastery</title>
  </head>
  <body>
    <header class="member_nav">
      <h1>DEV <br />MASTERY</h1>
      <nav id="desktop_nav">
        <ul>
          <a href="../../index.php">Home</a>
          <a href="../courses.php">Courses</a>
          <a href="../roadmap.php">Roadmap</a>
          <a href="">FAQ</a>
        </ul>
      </nav>
      <div class="user-box">
        <img class="user_img" src="../../assets/user.jpg" alt="user Image" />
        <span><?php echo $user_name; ?> </span>
        <i class="fa-solid fa-arrow-down fa-bounce arrow_down"></i>
        <form method="post" class="settings">
          <button name="logout_btn" class="btn btn-danger">Log Out</button>
        </form>
      </div>

      <svg
        width="35"
        class="open_nav"
        height="30"
        viewBox="0 0 35 30"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M8.3899 0.0016342H33.0244C35.6585 -0.0865531 35.6585 3.42414 33.0244 3.33595H8.48808C5.90178 3.42414 5.8012 0.0016342 8.3875 0.0016342H8.3899ZM33.0244 13.3347C35.558 13.3347 35.558 16.6669 33.0244 16.6669H19.135C16.5487 16.6669 16.5487 13.3347 19.135 13.3347H33.0244ZM33.0244 26.6678C35.558 26.6678 35.558 30 33.0244 30H1.90021C-0.6334 30 -0.6334 26.6678 1.90021 26.6678H33.0244Z"
          fill="white"
        />
      </svg>
    </header>
    <nav id="mobile_nav">
      <ul>
        <a href="../../index.php">Home</a>
        <a href="../courses.php">Courses</a>
        <a href="../roadmap.php">Roadmap</a>
        <a href="">FAQ</a>
      </ul>
   
      <button class="close_nav">X Close</button>
    </nav>
    <main class="member_main">
      <section class="main_admin flex">
        <article class="left">
          <img src="../../assets/admin_bg.png" alt="" />
          <h1>Create Your Future</h1>
        </article>
        <article class="right">
          <img src="../../assets/user.jpg" alt="" />
          <h3><?php echo $user_name; ?> </h3>
          <p>Email <span><?php echo $user_email; ?> </span></p>
          <button class="open_edit_pop">Edit Profile</button>
        </article>
      </section>
      <section class="message_section">
        <h5>My courses <i class="fa-solid fa-arrow-right fa-beat-fade"></i></h5>
        <div class="member_courses flex">
          <?php
          while($row = $query->fetch(PDO::FETCH_ASSOC)){
          echo '  <article class="course">
          <img src="../../course_images/'.$row['crs_img'].'" alt="" />
          <h4>React & typescript</h4>
          <p>
          '.$row['crs_subtitle'].'
          </p>
          <a href="../course.php?course='.$row['crs_id'].'">Get Started</a>
          </article>';
          }
          ?> 
        

        </div>
      </section>
    </main>
    <section class="edit_profile_popUp">
      <form action="" method="post">
        <button class="close_pop">X</button>
        <h3>Edit My Profile</h3>
        <input placeholder="Full Name" name="full_name" type="text" value=<?php echo $user_name; ?> >
        <input placeholder="Age" name="age" type="text" value=<?php echo $user_age; ?>  >
        <input placeholder="Email" name="email" type="text" value=<?php echo $user_email; ?> >
        <input placeholder="Password" name="password" type="password"  >
        <p class="error">Password Required !!</p>
        <!-- <input placeholder="Password Repeat" type="password" /> -->
        <p><?php if (isset($error)) {
        echo $error;
        } ?></p>
        <button name='submit'>Submit<i class="fa-solid fa-arrow-right fa-shake"></i></button>
      </form>
    </section>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"
      integrity="sha512-cOH8ndwGgPo+K7pTvMrqYbmI8u8k6Sho3js0gOqVWTmQMlLIi6TbqGWRTpf1ga8ci9H3iPsvDLr4X7xwhC/+DQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script>
  setTimeout(function() {
    document.querySelector('.secces_p').style.display = 'none';
  }, 5000);
</script>
    <script src="../../js/admin_dash.js"></script>
  </body>
</html>
