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
$query = $conn->prepare("SELECT * FROM `courses`");
$execute = $query->execute();
$num_rows1 = $query->rowCount();
if (isset($_POST['deleteBtn'])) {
echo '  <section class="delete_pop">
<form  method="post">
  <a href="./courses_admin.php">X</a>
  <h3>Are You Sure To delete this Course </h3>
  <button value='.$_POST['deleteBtn'].' name="confirm_delete" >Delete<i class="fa-solid fa-arrow-right fa-shake"></i></button>
</form>
</section>';
}
if (isset($_POST['confirm_delete'])) {
  $course_id =$_POST['confirm_delete'];
  $query = $conn->prepare("DELETE FROM chapters WHERE crs_id = $course_id");
  $execute = $query->execute();
  if ($execute) {
    $query1 = $conn->prepare("DELETE FROM courses WHERE crs_id = $course_id");
  $execute1 = $query1->execute();
  if ($execute1) {
   header("location:./courses_admin.php");
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
    <title>Courses Dashboard || devmastery</title>
  </head>
  <body>

    <nav class="left_nav">
      <div class="logo">
        <h1>DEV <br />MASTERY</h1>
      </div>
      <ul class="m-0">
        <li>
          <a href="../../index.php"
            ><i class="fa-solid fa-house fa-shake"></i>
            <span class="nav_content">Home</span>
          </a>
        </li>
        <li>
          <a href="./overView.php"
            ><i class="fa-solid fa-user fa-bounce"></i>
            <span class="nav_content">Overview</span></a
          >
        </li>
        <li class="active_navBtn">
          <a href="./courses_admin.php"
            ><i class="fa-solid fa-list fa-shake"></i>
            <span class="nav_content">Courses</span></a
          >
        </li>
    
      </ul>
    </nav>
    <main>
      <header class="flex">
        <h4>Welcome admin</h4>
        <form method="get" class="search_bar flex">
          <input name="searched_course" type="text" placeholder="Search By Name" />
          <i name="searchBtn" class="fa-solid h-100 fa-magnifying-glass"></i>
        </form>
       <div class="user-box">
          <img class="user_img" src="../../assets/user.jpg" alt="user Image" />
          <span><?php echo $admin_name?></span>
          <i class="fa-solid fa-arrow-down fa-bounce arrow_down"></i>
          <form method="post" class="settings">
            <button name="logout_btn" class="btn btn-danger">Log Out</button>
          </form>
        </div>
      </header>
      <!-- add new item start  -->
      <section class="adNew flex">
        <ul class="flex">
          <li class="flex">
            <i class="fa-solid fa-book"></i>
            <div class="column3">
              <span>Total Courses</span>
              <br />
              <span class="hight_opacity"><?php echo $num_rows1;?></span>
            </div>
          </li>
          <li class="flex">
            <i class="fa-solid fa-users"></i>
            <div class="column3">
              <span>Total Members</span><br />
              <span class="hight_opacity">5</span>
            </div>
          </li>
        
        </ul>
        <a href="./add_course.php" target="_blank" class="addNewButton">Add New Listing</a>
      </section>
      <section class="admin_courses_section">
        <h5>
           <?php if (isset($_GET['searched_course'])) { echo $_GET['searched_course'];}else{echo "Latest  ";}?> courses <i class="fa-solid fa-arrow-right fa-beat-fade"> </i>
         
        </h5>
        <div class="member_courses flex">
          <?php
          if (isset($_GET['searched_course'])) {
            $searched_name = $_GET['searched_course'];
            $query = $conn->prepare("SELECT * FROM `courses` WHERE crs_title LIKE '$searched_name%'");
            $execute = $query->execute();
            $num_rows = $query->rowCount(); 
            if ($num_rows > 0) {
              while($row = $query->fetch(PDO::FETCH_ASSOC)){
              echo '<article class="course">
              <img src="../../course_images/'.$row['crs_img'].'" alt="" />
              <h4>'.$row['crs_title'].'</h4>
              <p>'.$row['crs_subtitle'].'</p>
              <form method="post" class="course_buttons flex">
                <a href="./edit_course?course='.$row['crs_id'].'" class="Update_Btn">Update</a>
                <button value='.$row['crs_id'].' name="deleteBtn" class="delete_btn">Delete</button>
              </form>
            </article>';
              }}else{
                echo 'No Courses Found';
              }
          }else{
            $query = $conn->prepare("SELECT * FROM `courses`");
            $execute = $query->execute();
            $num_rows1 = $query->rowCount();
            if ($num_rows1 > 0) {
              while($row = $query->fetch(PDO::FETCH_ASSOC)){
              echo '<article class="course">
              <img src="../../course_images/'.$row['crs_img'].'" alt="" />
              <h4>'.$row['crs_title'].'</h4>
              <p>'.$row['crs_subtitle'].'</p>
              <form method="post" class="course_buttons flex">
                <a href="./edit_course.php?course='.$row['crs_id'].'" class="Update_Btn">Update</a>
                <button value='.$row['crs_id'].' name="deleteBtn" class="delete_btn">Delete</button>
              </form>
            </article>';
              }}
          }
          
         
          
          ?>

        </div>
      </section>
    </main>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"
      integrity="sha512-cOH8ndwGgPo+K7pTvMrqYbmI8u8k6Sho3js0gOqVWTmQMlLIi6TbqGWRTpf1ga8ci9H3iPsvDLr4X7xwhC/+DQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <script src="../../js/admin_dash.js?v=<?php echo time(); ?>"></script>
  </body>
</html>
