<?php
  include("./includes/db.php");
  session_start();
  if (isset($_POST['logout_btn'])) {
    session_destroy();
    header("location:./login.php");
  }
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_POST["save_btn"])) {
      $crs_id = $_POST['save_btn'];
      $checkQuery = $conn->prepare("SELECT * FROM `favorite` WHERE `mem_id` = :mem_id AND `crs_id` = :crs_id");
        $checkQuery->bindParam(':mem_id', $user_id);
        $checkQuery->bindParam(':crs_id', $crs_id);
        $checkQuery->execute();
        $num_rows1 = $checkQuery->rowCount();
  
        if ($num_rows1 > 0) {
          // Handle the ase when the combination of mem_id and crs_id already exists in the favorite table
          echo '<div id="errorDiv">The course is already saved as a favorite.</div>';
        }elseif($num_rows1 < 1){
            // Insert the new favorite record
            $query = $conn->prepare("INSERT INTO `favorite`(`crs_id`, `mem_id`) VALUES (:crs_id, :mem_id)");
            $query->bindParam(':crs_id', $crs_id);
            $query->bindParam(':mem_id', $user_id);
            if ($query->execute()) {
              header("Location:./members/overview.php");
            }
          
        }
    }
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
    <link rel="stylesheet" href="../styles/courses.css?v=<?php echo time(); ?>" />
    <title>Courses || DEVMASTERY</title>
  </head>
  <body>
    <header>
      <h1>DEV <br />MASTERY</h1>
      <nav id="desktop_nav">
        <ul>
          <a href="../index.php">Home</a>
          <a href="./courses.php">Courses</a>
          <a href="">Roadmap</a>
          <a href="">FAQ</a>
        </ul>
        <div class="nav_buttons">
        <?php if (isset($_SESSION['admin_id'])) {
            echo '
            <div class="user-box">
              <img class="user_img" src="../assets/user.jpg" alt="user Image" />
              <span>'. $_SESSION['admin_name'].'</span>
              <i class="fa-solid fa-arrow-down fa-bounce arrow_down"></i>
              <form method="post" class="settings">
              <a href="./admin/overView.php">Profile</a>
                <button name="logout_btn" class="btn btn-danger">Log Out</button>
              </form>
            </div>';
          }elseif(isset($_SESSION['user_id'])){
            echo '
            <div class="user-box">
              <img class="user_img" src="../assets/user.jpg" alt="user Image" />
              <span>'. $_SESSION['user_name'].'</span>
              <i class="fa-solid fa-arrow-down fa-bounce arrow_down"></i>
              <form method="post" class="settings">
              <a href="./members/overview.php">Profile</a>
                <button name="logout_btn" class="btn btn-danger">Log Out</button>
              </form>
            </div>';
          }else{
            echo '
            <a class="loginBtn" href="./login.php">Login</a>
            <a href="./sign.php" class="sign_upBtn">Sign Up</a>
            ';
          }
          ?>
     
        </div>
      </nav>

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
        <a href="../index.php">Home</a>
        <a href="./courses.php">Courses</a>
        <a href="">Roadmap</a>
        <a href="">FAQ</a>
      </ul>
      <div class="nav_buttons">
      <?php if (isset($_SESSION['admin_id'])) {
            echo '
            <div class="user-box">
              <img class="user_img" src="../assets/user.jpg" alt="user Image" />
              <span>'. $_SESSION['admin_name'].'</span>
              <i class="fa-solid fa-arrow-down fa-bounce arrow_down"></i>
              <form method="post" class="settings">
              <a href="./php/admin/overView.php">Profile</a>
                <button name="logout_btn" class="btn btn-danger">Log Out</button>
              </form>
            </div>';
          }elseif(isset($_SESSION['user_id'])){
            echo '
            <div class="user-box">
              <img class="user_img" src="../assets/user.jpg" alt="user Image" />
              <span>'. $_SESSION['user_name'].'</span>
              <i class="fa-solid fa-arrow-down fa-bounce arrow_down"></i>
              <form method="post" class="settings">
              <a href="./php/members/overview.php">Profile</a>
                <button name="logout_btn" class="btn btn-danger">Log Out</button>
              </form>
            </div>';
          }else{
            echo '
            <a class="loginBtn" href="./login.php">Login</a>
            <a href="./sign.php" class="sign_upBtn">Sign Up</a>
            ';
          }
          ?>
     
      </div>
      <button class="close_nav">X Close</button>
    </nav>
    <!-- main start -->
    <main>
      <section class="course_filters Roadmap_section ">
        <?php
if (isset($_GET['road'])) {
    $road = $_GET['road'];
    
    if ($road == 'front_end') {
        echo '
        <div class="flex">
            <a class="back_to_roads" href="./roadmap.php">All Roadmaps</a>
            <h1>Front End Developer Roadmap</h1>
        </div>
        <img src="../assets/r1.png" > ';
    } else if ($road == 'back_end') {
        echo '
        <div class="flex">
         <a class="back_to_roads" href="./roadmap.php">All Roadmaps</a>
         <h1>Back End Developer Roadmap</h1>
        </div>
        <img src="../assets/r2.png" > ';
    }elseif($road == 'cloud') {
        echo '
        <div class="flex">
         <a class="back_to_roads" href="./roadmap.php">All Roadmaps</a>
         <h1>Cloud  Developer Roadmap</h1>
        </div>
        <img src="../assets/r3.png" > ';
    }elseif($road == 'mobile') {
        echo '
        <div class="flex">
         <a class="back_to_roads" href="./roadmap.php">All Roadmaps</a>
         <h1>Mobile  Developer Roadmap</h1>
        </div>
        <img src="../assets/r4.png" > ';
    } else {
        echo '<h1>Developer Roadmaps</h1>
        <p>Step by step guides and paths to learn different tools or technologies</p>
        <div class="roads flex">
            <a href="./roadmap.php?road=front_end" class="road">
                <h3>Front-end Developer</h3>
                <p>Step by step guide to becoming a modern frontend developer in 2023</p>
            </a>
            <a href="./roadmap.php?road=back_end" class="road">
                <h3>Backend Developer</h3>
                <p>Step by step guide to becoming a modern backend developer in 2023</p>    
            </a>
            <a href="./roadmap.php?road=cloud" class="road">
                <h3>Cloud Developer</h3>
                <p>Step by step guide to becoming a modern Cloud developer in 2023</p>
            </a>
            <a href="./roadmap.php?road=mobile" class="road">
                <h3>Mobile Developer</h3>
                <p>Step by step guide to becoming a modern Mobile developer in 2023</p>
            </a>';
    }
} else {
    echo '<h1>Developer Roadmaps</h1>
    <p>Step by step guides and paths to learn different tools or technologies</p>
    <div class="roads flex">
        <a href="./roadmap.php?road=front_end" class="road">
            <h3>Front-end Developer</h3>
            <p>Step by step guide to becoming a modern frontend developer in 2023</p>
        </a>
        <a href="./roadmap.php?road=back_end" class="road">
            <h3>Backend Developer</h3>
            <p>Step by step guide to becoming a modern backend developer in 2023</p>    
        </a>
        <a href="./roadmap.php?road=cloud" class="road">
            <h3>Cloud Developer</h3>
            <p>Step by step guide to becoming a modern Cloud developer in 2023</p>
        </a>
        <a href="./roadmap.php?road=mobile" class="road">
            <h3>Mobile Developer</h3>
            <p>Step by step guide to becoming a modern Mobile developer in 2023</p>
        </a>';
}
?>

      
        </div>
        </section>
   
    </main>
    <footer>
      <div class="footer flex">
        <article>
          <h1>DEV <br />MASTERY</h1>
          <p>
            Explore the World of <br />
            Software DEVELOPMENT with DevMastery
          </p>
        </article>
        <article>
          <h3>links</h3>
          <ul>
            <li><a href="">Home</a></li>
            <li><a href="">Courses</a></li>
            <li><a href="">Roadmap</a></li>
            <li><a href="">FAQ</a></li>
          </ul>
        </article>
        <article>
          <h3>ABOUT</h3>
          <ul>
            <li><a href="">testimonials</a></li>
            <li><a href="">About us</a></li>
            <li><a href="">Roadmap</a></li>
            <li><a href="">Contact</a></li>
          </ul>
        </article>
        <article class="social_media_part">
          <h3>Social media</h3>
          <ul class="social_media">
            <li>
              <a href=""
                ><i
                  class="fa-brands fa-facebook fa-bounce"
                  style="color: #2d3139"
                ></i
              ></a>
            </li>
            <li>
              <a href=""
                ><i
                  class="fa-brands fa-youtube fa-bounce"
                  style="color: #30343b"
                ></i
              ></a>
            </li>
            <li>
              <a href=""
                ><i
                  class="fa-brands fa-github fa-bounce"
                  style="color: #3f434b"
                ></i
              ></a>
            </li>
            <li>
              <a href=""
                ><i
                  class="fa-brands fa-instagram fa-bounce"
                  style="color: #2b2f36"
                ></i
              ></a>
            </li>
          </ul>
        </article>
      </div>
      <p class="copy_right">
        @COPYRIGHT 2023 <br />
        ALL RIGHTS RESERVED BY DEVMASTERY
      </p>
    </footer>
    <!-- main end -->
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"
      integrity="sha512-cOH8ndwGgPo+K7pTvMrqYbmI8u8k6Sho3js0gOqVWTmQMlLIi6TbqGWRTpf1ga8ci9H3iPsvDLr4X7xwhC/+DQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
    <script src="../js/course.js?v=<?php echo time(); ?>"></script>
  </body>
</html>
