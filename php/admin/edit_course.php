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
 $course_id = $_GET['course'];
 $query = $conn->prepare("SELECT * FROM `courses` WHERE crs_id = $course_id");
 $execute = $query->execute();
 $num_rows1 = $query->rowCount();
 $row = $query->fetch(PDO::FETCH_ASSOC);
 //update
  if (isset($_POST['update_btn'])) {
    $course_title = htmlspecialchars($_POST['course_title']);
    $course_subtitle = htmlspecialchars($_POST['course_subtitle']);
    $course_category = htmlspecialchars($_POST['course_category']);
    $course_details = htmlspecialchars($_POST['course_details']);
    if (empty($course_title) || empty($course_subtitle) ||empty($course_category)|| empty($course_details)) {
    echo '<p class="update_error">Fill All inputs</p>';
    }else{
      // check if user dont add img
      if ($_FILES['course_image']['name'] == '') {
        $query = $conn->prepare("UPDATE `courses` 
          SET `crs_title`=:course_title ,`crs_subtitle`= :course_subtitle ,`crs_ctg`=:course_category,`crs_details`=:course_details 
          WHERE crs_id = $course_id");
           $query->bindParam(':course_title', $course_title);
            $query->bindParam(':course_subtitle', $course_subtitle);
            $query->bindParam(':course_category', $course_category);
            $query->bindParam(':course_details', $course_details);
          
            if ($query->execute()) {
              header("location:./courses_admin.php");
            }
         }else{
          // the user add img
          $folder = "../../course_images/";
          $courseImageFile = $_FILES['course_image']['tmp_name'];
          $courseImageName = $_FILES['course_image']['name'];
          $uniqueFileName = uniqid() . '_' . $courseImageName;
          $destinationPath = $folder . $uniqueFileName;
          if (move_uploaded_file($courseImageFile, $destinationPath)) {
            $query1 = $conn->prepare("UPDATE `courses` 
                SET `crs_title`=:course_title ,`crs_subtitle`=:course_subtitle ,`crs_img`=:crs_img,`crs_ctg`=:course_category,`crs_details`=:course_details 
                 WHERE crs_id = $course_id");
                      $query1->bindParam(':course_title', $course_title);
                      $query1->bindParam(':course_subtitle', $course_subtitle);
                      $query1->bindParam(':crs_img', $uniqueFileName);
                      $query1->bindParam(':course_category', $course_category);
                      $query1->bindParam(':course_details', $course_details);
                      $execute1 = $query1->execute();
                      if ($execute1) {
                        header("location:./courses_admin.php");
                   }
          }

         }
    }
   
  }
  if (isset($_POST['update_chapter'])) {
   
    $chapterTitles = $_POST['chapterTitle'];
    $chapterDescriptions = $_POST['chapterDescription'];
    $chapterVideos = $_FILES['chapterVideo']['tmp_name'];
    $chapterIds = $_POST['chapterId'];
    // echo '<pre>';
    // print_r($chapterVideos);
    // echo '</pre>';

    for ($i = 0; $i < count($chapterIds); $i++) {
      $chapterId = $chapterIds[$i];
      $chapterTitle = htmlspecialchars($chapterTitles[$i]);
      $chapterDescription = htmlspecialchars($chapterDescriptions[$i]);
      $chaptervideo = htmlspecialchars($chapterVideos[$i]);

    //   echo '<pre>';
    // print_r($chaptervideo[$i]);
    // echo '</pre>';
      //upload videos
      $folder = "../../courses_videos/";
      $chapterVideoName = $_FILES['chapterVideo']['name'][$i];
   
      $chapterVideoSize = $_FILES['chapterVideo']['size'][$i];
      $chapterVideoFile = $_FILES['chapterVideo']['tmp_name'][$i];
      // Generate a unique file name to prevent overwriting existing files
      $uniqueFileName = uniqid() . '_' . $chapterVideoName;
      $destinationPath = $folder . $uniqueFileName;        
      if (move_uploaded_file($chapterVideoFile, $destinationPath)) {

        $query = $conn->prepare("UPDATE `chapters` SET ch_title = :chapterTitle, ch_details = :chapterDescription , ch_video=:ch_video WHERE ch_id = :chapterId");
        $query->bindParam(':chapterTitle', $chapterTitle);
        $query->bindParam(':chapterDescription', $chapterDescription);
        $query->bindParam(':ch_video', $uniqueFileName);
        $query->bindParam(':chapterId', $chapterId);
  
        if ($query->execute()) {
          header("location:./courses_admin.php");
            // Update successful
            // Handle success or redirect as needed
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
    <title>Edit Course || devmastery</title>
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
        <li>
          <a href=""
            ><i class="fa-sharp fa-solid fa-check"></i>
            <span class="nav_content">Borrowed</span>
          </a>
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
      <!-- add new item start  -->
      <section class="add_section">
        <h2>edit Course</h2>
        <form method="post" enctype="multipart/form-data">
              <input placeholder="Course Title" type="text" name="course_title" value='<?php echo $row['crs_title']?>' >
              <input placeholder="Course Subtitle" type="text" name="course_subtitle"  value='<?php echo $row['crs_subtitle'] ?>'>
              <div class="column">
                <label for="file">Course Image</label>
                <input placeholder="Course Image" type="file" name="course_image" />
              </div>
                  <div class="column">
                    <label for="course_category">Course Category</label>
                    <select name="course_category">
                    <option <?php echo ($row['crs_ctg'] == 'Front-end') ? 'selected="selected"' : ''; ?> value="Front-end">Front-end</option>
                    <option <?php echo ($row['crs_ctg'] == 'Back-end') ? 'selected="selected"' : ''; ?> value="Back-end">Back-end</option>
                    <option <?php echo ($row['crs_ctg'] == 'Cloud') ? 'selected="selected"' : ''; ?> value="Cloud">Cloud</option>
                    <option <?php echo ($row['crs_ctg'] == 'Mobile') ? 'selected="selected"' : ''; ?> value="Mobile">Mobile</option>

                    </select>
                  </div>
               <br />
                  <div class="column2">
                    <label for="course_details">Course Details</label>
                    <textarea
                      placeholder="Course Details"
                      name="course_details"
                      id=""
                      cols="20"
                      rows="5"
                    ><?php echo $row['crs_details'] ?></textarea>
                  </div>
                  <div class="add_section_button">
                    <button name='update_btn'>Update Course</button>
                  </div>
                   <div id="chaptersContainer">
                    <h2>Chapters</h2>
                    <?php 
                     $course_id = $_GET['course'];
                     $query = $conn->prepare("SELECT * FROM `chapters` WHERE crs_id = $course_id");
                     $execute = $query->execute();
                     $num_rows1 = $query->rowCount();
                     while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                      echo '<div class="chapter">
                          <div class="flex">
                              <div class="column">
                                  <label for="chapterVideo1">Chapter title:</label>
                                  <input placeholder="Chapter Title" type="text" class="chapterTitle" name="chapterTitle[]" value="' . $row['ch_title'] . '">
                              </div>
                              <!-- Input field for chapter title -->
                              <div class="column">
                                  <label for="chapterVideo1">Chapter Details:</label>
                                  <textarea class="chapterDescription" name="chapterDescription[]">' . $row['ch_details'] . '</textarea>
                              </div>
                              <!-- Textarea for chapter description -->
                              <div class="column">
                                  <label for="chapterVideo1">Upload Video:</label>
                                  <!-- Label for the video upload field -->
                                  <input class="chapterVideo" type="file" name="chapterVideo[]">
                                  <!-- Input field for uploading video -->
                              </div>
                              <input type="hidden" name="chapterId[]" value="' . $row['ch_id'] . '">
                          </div>
                      </div>';
                  }                  
                     ?>
                  
                  </div>
                  <button class="update_chapter" name="update_chapter">Update</button>

                  <!-- //chapter -->
                  <!-- //chapter -->
             
        </form>

      </section>
    </main>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"
      integrity="sha512-cOH8ndwGgPo+K7pTvMrqYbmI8u8k6Sho3js0gOqVWTmQMlLIi6TbqGWRTpf1ga8ci9H3iPsvDLr4X7xwhC/+DQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>

    <script>

     
  setTimeout(function() {
    document.querySelector('.update_error').style.display = 'none';
  }, 5000);


     
         </script>
    <script src="../../js/admin_dash.js?v=<?php echo time(); ?>"></script>
  </body>
</html>
