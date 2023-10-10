<?php
  include("./includes/db.php");
  session_start();
 
if (isset($_SESSION['user_id']) || $_SESSION['admin_id']) {
  // $user_name = $_SESSION['user_name'];
  // $user_age = $_SESSION['user_age'];
  // $user_email = $_SESSION['user_email'];
  // $user_password = $_SESSION['user_password'];
  if (isset($_POST['logout_btn'])) {
    session_destroy();
    header("location:./login.php");
  }
}else{
  header("location:./login.php");
}
  // Get the course ID from the URL parameter
  $course_id = $_GET['course'];
  // Prepare the query to fetch course and chapter information
  $query = $conn->prepare("
    SELECT *
    FROM `courses`
    JOIN `chapters` ON courses.crs_id = chapters.crs_id
    WHERE courses.crs_id = :course_id
  ");
  // Bind the course ID parameter
  $query->bindParam(':course_id', $course_id);
  // Execute the query
  $execute = $query->execute();
  // Get the number of rows returned
  $num_rows1 = $query->rowCount();
  if (isset($_GET['chapter'])) {
    $currentChapterId = $_GET['chapter'];
    $courseId = $_GET['course'];
  
    // Prepare the query to fetch the next chapter
    $query2 = $conn->prepare("
      SELECT ch_id
      FROM `chapters`
      WHERE crs_id = :course_id AND ch_id > :current_chapter_id
      ORDER BY ch_id ASC
      LIMIT 1
    ");
  
    $query2->bindParam(':course_id', $courseId);
    $query2->bindParam(':current_chapter_id', $currentChapterId);
  
    $execute = $query2->execute();
  
    if ($row2 = $query2->fetch(PDO::FETCH_ASSOC)) {
      $nextChapterId = $row2['ch_id'];
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
    <link rel="stylesheet" href="../styles/course.css?v=<?php echo time(); ?>" />
    <title>Course || DEVMASTERY</title>
  </head>
  <body>
    <i class="fa-solid fa-bars open_nav"></i>
    <section class="course_show">
      <nav class="left_nav">
     
        <div class="course_img">
          <?php 
            // Fetch course image based on the course ID
            $course_id = $_GET['course'];
            $query1 = $conn->prepare("
              SELECT *
              FROM `courses`
              WHERE courses.crs_id = :course_id
            ");
            $query1->bindParam(':course_id', $course_id);
            $execute = $query1->execute();
            $num_rows1 = $query1->rowCount();
            if ($row1 = $query1->fetch(PDO::FETCH_ASSOC)) {
              echo '<img src="../course_images/'.$row1['crs_img'].'" alt="">';
            }
          ?>
        </div>
        <ul class="m-0">
      
        <li><a href="./course.php?course=<?php echo $course_id; ?>">OverView</a></li>

          <?php
      
            // Display the list of chapters with links
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
              if (isset($_GET['chapter'])) {
                if ($_GET['chapter'] == $row['ch_id']) {
                  echo '<li class="li_active"> 
                  <a href="./course.php?course=' . $row['crs_id'] . '&chapter=' . $row['ch_id'] . '">
                    <span class="nav_content">' . $row['ch_title'] . '</span>
                  </a>
                </li>';}else{
                  echo '<li> 
                  <a href="./course.php?course=' . $row['crs_id'] . '&chapter=' . $row['ch_id'] . '">
                    <span class="nav_content">' . $row['ch_title'] . '</span>
                  </a>
                </li>';}
              }else{
                echo '<li> 
                <a href="./course.php?course=' . $row['crs_id'] . '&chapter=' . $row['ch_id'] . '">
                  <span class="nav_content">' . $row['ch_title'] . '</span>
                </a>
              </li>';}
             
              }
              
           
            ?>
        </ul>
      </nav>
      <div class="course_right">
      <form method="post" class="back_to_home">
      <a href="./courses.php"><i class="fa-solid fa-house fa-shake"></i>Courses</a>
      <?php if (isset($_GET['chapter'])) {
  if (isset($nextChapterId)): ?>
    <a href="./course.php?course=<?php echo $courseId; ?>&chapter=<?php echo $nextChapterId; ?>">
      <i class="fa-solid fa-forward fa-fade"></i>Next Chapter
    </a>
  <?php else: ?>
    <a href="./course.php?course=<?php echo $courseId; ?>">
      <i class="fa-solid fa-forward fa-fade"></i>Next Course
    </a>
  <?php endif;
} ?>



    </form>

        <?php
        
          $courseId = $_GET['course'];
          if (isset($_GET['chapter'])) {
            $ch_id = $_GET['chapter'];
            // Prepare the query to fetch chapter details
            $query = $conn->prepare("
              SELECT *
              FROM `chapters`
              WHERE crs_id = :course_id AND ch_id = :ch_id
            ");

            $query->bindParam(':course_id', $course_id);
            $query->bindParam(':ch_id', $ch_id);

            $execute = $query->execute();

            if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
              echo '
             
              <video controls autoplay>
                <source src="../courses_videos/'.$row['ch_video'].'">
              </video>
               ';
            }
          } else {
        
            // If no specific chapter is selected, display course title
            $query = $conn->prepare("
              SELECT *
              FROM `courses`
              JOIN `chapters` ON courses.crs_id = chapters.crs_id
              WHERE courses.crs_id = :course_id
            ");

            $query->bindParam(':course_id', $course_id);
            $execute = $query->execute();
            $num_rows1 = $query->rowCount();
            $row = $query->fetch(PDO::FETCH_ASSOC);

          echo  '<h1>'.$row['crs_title'].'</h1>
          <h2>'.$row['crs_subtitle'].'</h2>
          <p>'.$row['crs_details'].'</p>
          <li>'.$row['crs_ctg'].'</li>';
          }
        ?> 
       
     
     
      </div>
    </section>

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
