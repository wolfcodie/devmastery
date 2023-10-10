<?php 
  include("./php/includes/db.php");

session_start();
if (isset($_POST['logout_btn'])) {
  session_destroy();
  header("location:./php/login.php");
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
            header("Location:./php/members/overview.php");
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
    <link rel="stylesheet" href="./styles/index.css?v=<?php echo time(); ?>" />
    <title>DevMastery</title>
  </head>
  <body>
    <!-- <div class="loader">
      <h1 class="loader_title" id="loader_title">DEVMASTERY</h1>
      <svg
        class="line"
        id="loader_line"
        height="4"
        viewBox="0 0 1440 4"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      ></svg>
    </div> -->

    <header>
      <h1>DEV <br />MASTERY</h1>
      <nav id="desktop_nav">
        <ul>
          <a href="./index.html">Home</a>
          <a href="./php/courses.php">Courses</a>
          <a href="./php/roadmap.php">Roadmap</a>
          <a href="">FAQ</a>
        </ul>
        <div class="nav_buttons">
          <?php if (isset($_SESSION['admin_id'])) {
            echo '
            <div class="user-box">
              <img class="user_img" src="./assets/user.jpg" alt="user Image" />
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
              <img class="user_img" src="./assets/user.jpg" alt="user Image" />
              <span>'. $_SESSION['user_name'].'</span>
              <i class="fa-solid fa-arrow-down fa-bounce arrow_down"></i>
              <form method="post" class="settings">
              <a href="./php/members/overview.php">Profile</a>
                <button name="logout_btn" class="btn btn-danger">Log Out</button>
              </form>
            </div>';
          }else{
            echo '
            <a class="loginBtn" href="./php/login.php">Login</a>
            <a href="./php/sign.php" class="sign_upBtn">Sign Up</a>
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
        <a href="./index.html">Home</a>
        <a href="./php/courses.php">Courses</a>
        <a href="./php/roadmap.php">Roadmap</a>
        <a href="">FAQ</a>
      </ul>
      <div class="nav_buttons">
      <?php if (isset($_SESSION['admin_id'])) {
            echo '
            <div class="user-box">
              <img class="user_img" src="./assets/user.jpg" alt="user Image" />
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
              <img class="user_img" src="./assets/user.jpg" alt="user Image" />
              <span>'. $_SESSION['user_name'].'</span>
              <i class="fa-solid fa-arrow-down fa-bounce arrow_down"></i>
              <form method="post" class="settings">
              <a href="./php/members/overview.php">Profile</a>
                <button name="logout_btn" class="btn btn-danger">Log Out</button>
              </form>
            </div>';
          }else{
            echo '
            <a class="loginBtn" href="./php/login.php">Login</a>
            <a href="./php/sign.php" class="sign_upBtn">Sign Up</a>
            ';
          }
          ?>
     
      </div>
      <button class="close_nav">X Close</button>
    </nav>
    <!-- main start -->
    <main>
      <section class="hero_section">
        <div class="hero_title_container">
          <h1 class="hero_title">Unlock Your Potential in <br /></h1>
        </div>

        <div class="hero_title_container">
          <h1 class="hero_title">Software Development</h1>
        </div>
        <div class="hero_subtitle_container">
          <h4 class="hero_subtitle">
            Start Your Journey to Software Mastery Today!
          </h4>
        </div>
        <div class="hero_button_container">
          <button class="hero_btn">

            <a href="./php/roadmap.php" >
              Start Now <i class="fa-solid fa-arrow-right"></i>
            </a>
          </button>
        </div>
      </section>
      <div class="hero_images">
        <article class="hero_img_container">
          <img class="hero_img" src="./assets/web-dev.jpg" alt="cloud-dev" />
          <h3>Web develepment</h3>
        </article>
        <article class="hero_img_container">
          <img class="hero_img" src="./assets/cloud-dev.jpg" alt="cloud-dev" />
          <h3>Cloud develepment</h3>
        </article>
        <article class="hero_img_container">
          <img class="hero_img" src="./assets/13.jpg" alt="cloud-dev" />
          <h3>Mobile develepment</h3>
        </article>
      </div>
      <!-- about start -->
      <section class="about">
        <div class="about_title_container">
          <h2 class="about_title">< About US ></h2>
        </div>
        <p class="about_p">
          DevMastery, an innovative online learning platform created by Mr.
          hassan to revolutionize software development in Morocco. Our platform
          is designed to provide aspiring learners with comprehensive and
          engaging resources to master the art of programming
        </p>
        <div class="about_stats center">
          <article class="about_stat">
            <h5>15+</h5>
            <p>Years of Experience</p>
          </article>
          <article class="about_stat">
            <h5>10+</h5>
            <p>Coding Courses</p>
          </article>
          <article class="about_stat">
            <h5>100+</h5>
            <p>Students taught</p>
          </article>
        </div>
        <!-- <svg
          class="about_line"
          width="1440"
          height="6"
          viewBox="0 0 1440 6"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        ></svg> -->
        <svg
          class="about_line"
          id="about_line"
          height="4"
          viewBox="0 0 1440 4"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        ></svg>
        <svg
          class="about_outline_circle"
          width="120"
          height="120"
          viewBox="0 0 120 120"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <rect
            x="0.5"
            y="0.5"
            width="119"
            height="119"
            rx="59.5"
            fill="black"
          />
          <rect
            x="0.5"
            y="0.5"
            width="119"
            height="119"
            rx="59.5"
            stroke="white"
          />
        </svg>

        <svg
          class="about_circle"
          width="30"
          height="30"
          viewBox="0 0 30 30"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <circle cx="15" cy="15" r="14.5" fill="white" stroke="black" />
        </svg>
      </section>
      <!-- about end -->
      <!-- features start -->
      <section class="features">
        <div class="features_title_container">
          <h2 class="features_title">< Features and Benefits ></h2>
        </div>
        <div class="features_grid">
          <article class="feature1">
            <h3>1.Beginner-Friendly and Easy to Follow</h3>
            <p>
              simplifying complex concepts into easy-to-digest lessons that can
              be understood by anyone.
            </p>
            <!-- <svg
              width="566"
              height="2"
              class="feature_line feature1_line"
              viewBox="0 0 566 2"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            ></svg>
            <svg class="feature_circle1" viewBox="0 0 30 30">
              <circle cx="15" cy="15" r="14.5" fill="white" stroke="black" />
            </svg> -->
          </article>
          <article class="feature2">
            <h3>2.Beginner-Friendly and Easy to Follow</h3>
            <p>
              simplifying complex concepts into easy-to-digest lessons that can
              be understood by anyone.
              <!-- </p>
            <svg
              width="566"
              height="2"
              class="feature_line"
              viewBox="0 0 566 2"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            ></svg> -->
            </p>
          </article>

          <article class="feature3">
            <h3>3.Beginner-Friendly and Easy to Follow</h3>
            <p>
              simplifying complex concepts into easy-to-digest lessons that can
              be understood by anyone.
            </p>
            <!-- <svg
              width="566"
              height="2"
              class="feature_line"
              viewBox="0 0 566 2"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            ></svg> -->
          </article>
          <article class="feature4">
            <h3>4.Beginner-Friendly and Easy to Follow</h3>
            <p>
              simplifying complex concepts into easy-to-digest lessons that can
              be understood by anyone.
            </p>
            <!-- <svg
              width="566"
              height="2"
              class="feature_line"
              viewBox="0 0 566 2"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            ></svg> -->
          </article>
          <!-- <svg
            class="middle_line"
            width="10"
            height="759"
            viewBox="0 0 9 759"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <line
              x1="5.50001"
              y1="759.009"
              x2="3.58243"
              y2="0.00849372"
              stroke="white"
              stroke-width="7"
              stroke-dasharray="14 14"
            />
          </svg> -->
        </div>
      </section>
      <!-- features end -->
      <!-- courses start  -->
      <section class="courses">
        <h2>< Courses ></h2>
        <div class="courses_flex flex">
          <?php
            $query = $conn->prepare("SELECT * FROM `courses`");
            $result3 = $query->execute();
            $rows = $query->rowCount();
            if ($rows > 0) {
              while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo '<article class="course">
                <div class="ctg">
                    <p class="crs_ctg">'.$row['crs_ctg'].'</p>
                </div>
                <img src="./course_images/'.$row['crs_img'].'" alt="" />
                <h4>'.$row['crs_title'].'</h4>
                <p>'.$row['crs_subtitle'].'</p>';
            
              echo '<form method="post" class="flex">';
              if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
                  echo '<a href="./php/course.php?course='.$row['crs_id'].'">Get Started</a>
                  <button name="save_btn" value="'.$row['crs_id'].'" class="save_btn" href="./php/login.php"><i class="fa-solid fa-bookmark"></i></button>';
              } else {
                  echo '<a class="login_red" href="./php/login.php">Please Login</a>';
              }
              echo '
              </form>
              </article>';
            
                  }
            }
          ?>
      
        </div>
        <a  href="./php/courses.php" class="more_courses_btn">View More</a>
      </section>
      <!-- courses end  -->
      <!-- contact start  -->
      <section class="contact">
        <h2 class="animation_title">
          CONTACT US CONTACT US / CONTACT US / CONTACT US / CONTACT US / CONTACT
          US / CONTACT US / CONTACT US
        </h2>
        <div class="contact_main flex">
          <article class="contact_left">
            <h4>Contact DevMastery Your Questions Answered</h4>
          </article>
          <form class="contact_right">
            <input placeholder="Name" type="text" />
            <input placeholder="Email" type="text" />
            <textarea placeholder="Message" cols="30" rows="10"></textarea>
            <button>SEND <i class="fa-solid fa-arrow-right"></i></button>
          </form>
        </div>
      </section>
      <!-- contact start  -->
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
    <script>
  setTimeout(function() {
    document.getElementById('errorDiv').style.display = 'none';
  }, 5000);
</script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
    <script src="./js/index.js?v=<?php echo time(); ?>"></script>
  </body>
</html>
