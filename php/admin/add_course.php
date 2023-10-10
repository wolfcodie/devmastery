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

  $error = '';
  //course add
  if (isset($_POST['add_btn'])) {
    $course_title = htmlspecialchars($_POST['course_title']);
    $course_subtitle = htmlspecialchars($_POST['course_subtitle']);
    // $course_image = htmlspecialchars($_FILES['course_image']);
    $course_category = htmlspecialchars($_POST['course_category']);
    $course_details = htmlspecialchars($_POST['course_details']);
    // images verfication 
    $folder = "../../course_images/";
    $courseImageFile = $_FILES['course_image']['tmp_name'];
    $courseImageName = $_FILES['course_image']['name'];
    // Verify if a file is selected
    // Generate a unique file name to prevent overwriting existing files
    $uniqueFileName = uniqid() . '_' . $courseImageName;
    $destinationPath = $folder . $uniqueFileName;

    if (move_uploaded_file($courseImageFile, $destinationPath)) {
      if ($error == '') {
        $query = $conn->prepare("INSERT INTO `courses`(`crs_title`, `crs_subtitle`,`crs_img`,`crs_ctg`,`crs_details`)
         VALUES (:course_title,:course_subtitle,:crs_img,:course_category,:course_details)");
          $query->bindParam(':course_title', $course_title);
          $query->bindParam(':course_subtitle', $course_subtitle);
          $query->bindParam(':crs_img', $uniqueFileName);
          $query->bindParam(':course_category', $course_category);
          $query->bindParam(':course_details', $course_details);
          $execute = $query->execute();
          if ($execute) {
            $courseId = $conn->lastInsertId();
            $chapterTitles = isset($_POST['chapterTitle']) ? $_POST['chapterTitle'] : [];
            $chapterDescriptions = isset($_POST['chapterDescription']) ? $_POST['chapterDescription'] : [];
            $chapterVideos = isset($_FILES['chapterVideo']['tmp_name']) ? $_FILES['chapterVideo']['tmp_name'] : [];
            // echo $chapterVideos;
            for ($i = 0; $i < count($chapterTitles); $i++) {
              $chapterTitle = isset($chapterTitles[$i]) ? $chapterTitles[$i] : "";
              $chapterDescription = isset($chapterDescriptions[$i]) ? $chapterDescriptions[$i] : "";
              $chapterVideoFile = isset($chapterVideos[$i]) ? $chapterVideos[$i] : "";
          
              // Check if a video file was uploaded for the current chapter
              if (!empty($chapterVideoFile)) {
                $folder = "../../courses_videos/";
                $chapterVideoName = $_FILES['chapterVideo']['name'][$i];
                $chapterVideoSize = $_FILES['chapterVideo']['size'][$i];
                $chapterVideoFile = $_FILES['chapterVideo']['tmp_name'][$i];
                
                // Generate a unique file name to prevent overwriting existing files
                $uniqueFileName = uniqid() . '_' . $chapterVideoName;
                $destinationPath = $folder . $uniqueFileName;        
                if (move_uploaded_file($chapterVideoFile, $destinationPath)) {
                  // Video file moved successfully, update the chapter record in the database with the file name
                  $sql = $conn->prepare("INSERT INTO chapters (ch_title, ch_details, ch_video ,crs_id) VALUES (?, ?, ?,?)");
                  $sql->bindParam(1, $chapterTitle);
                  $sql->bindParam(2, $chapterDescription);
                  $sql->bindParam(3, $uniqueFileName);
                  $sql->bindParam(4, $courseId);
                  $ex = $sql->execute();
                  if ($ex) {
                    header("location:./courses_admin.php");
                    # code...
                  }
                } else {
                  // Failed to move the video file
                  echo "Error moving video file for Chapter: $chapterTitle.<br>";
                }
                
                
              } else {
                // No video file uploaded for the current chapter
                echo "No video file uploaded for Chapter: $chapterTitle.<br>";
              }
             }
            }
          }
     
    } else {
      echo "Error moving course image file.";
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
    <title>Add Course || devmastery</title>
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
      <?php
      if ($error != '') {
      echo  '<div class="course_error"><p>'. $error.'</p></div>';}?>
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
        <h2>New Course</h2>
        <form method="post" enctype="multipart/form-data">
              <input placeholder="Course Title" type="text" name="course_title" value=<?php if (isset($course_title)) {
                echo $course_title;}?> >
              <input placeholder="Course Subtitle" type="text" name="course_subtitle"  value=<?php if (isset($course_subtitle)) {
                echo $course_subtitle;}?>>
              <div class="column">
                <label for="file">Course Image</label>
                <input placeholder="Course Image" type="file" name="course_image" />
              </div>
              <!-- <input placeholder="Course Price" type="number" name="course_price"  value=<?php if (isset($course_price)) {
                echo $course_price;}?>> -->
                  <div class="column">
                    <label for="course_category">Course Category</label>
                    <select name="course_category">
                      <option value="Front-end">Front-end</option>
                      <option value="Back-end">Back-end</option>
                      <option value="Cloud">Cloud</option>
                      <option value="Mobile">Mobile</option>
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
                    ><?php if (isset($course_details)) {
                    echo $course_details;}?></textarea>
                  </div>
                   <div id="chaptersContainer">
                    <h2>Chapters</h2>
                    <div class="chapter">
                      <h3>Chapter 1</h3>
                      <div class="flex">
                          <input placeholder='Chapter Title' type="text" class="chapterTitle" name="chapterTitle[]"/>
                          <textarea class="chapterDescription" name="chapterDescription[]" > </textarea>
                          <div class="column">
                            <label for="chapterVideo1">Upload Video:</label>
                        
                            <input   class="chapterVideo" type="file" name="chapterVideo[]" >

                      </div>
                      </div>
                     
                    </div>  
                  </div>
                  <!-- //chapter -->
                  <!-- //chapter -->
                  <div class="add_section_button">
                    <button  id="add_chapter" class="add_chapter_btn"> Add Chapter</button>
                    <button name='add_btn'>Save Course</button>
                  </div>
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
     
/// add course
let add_chapter_btn = document.getElementById("add_chapter");
let chapterCount = 1;
add_chapter_btn.addEventListener("click", (e) => {
  e.preventDefault();

  chapterCount++;
  const chaptersContainer = document.getElementById("chaptersContainer");

      // Create the chapter div
      const chapterDiv = document.createElement('div');
      chapterDiv.className = 'chapter';

      // Create the h3 element for Chapter 1
      const chapterHeading = document.createElement('h3');
      chapterHeading.textContent = 'Chapter ' + chapterCount + ":";

      // Create the div with class "flex"
      const flexDiv = document.createElement('div');
      flexDiv.className = 'flex';

      // Create the input element for Chapter Title
      const chapterTitleInput = document.createElement('input');
      chapterTitleInput.placeholder = 'Chapter Title';
      chapterTitleInput.type = 'text';
      chapterTitleInput.className = 'chapterTitle';
      chapterTitleInput.name = 'chapterTitle[]';

      // Create the textarea element for Chapter Description
      const chapterDescriptionTextarea = document.createElement('textarea');
      chapterDescriptionTextarea.textContent = 'chapter Description';
      chapterDescriptionTextarea.className = 'chapterDescription';
      chapterDescriptionTextarea.name = 'chapterDescription[]';

      // Create the div with class "column"
      const columnDiv = document.createElement('div');
      columnDiv.className = 'column';

      // Create the label for chapterVideo1
      const videoLabel = document.createElement('label');
      videoLabel.setAttribute('for', 'chapterVideo1');
      videoLabel.textContent = 'Upload Video:';

      // Create the input element for Chapter Video
      const chapterVideoInput = document.createElement('input');
      chapterVideoInput.type = 'file';
      chapterVideoInput.className = 'chapterVideo';
      chapterVideoInput.name = 'chapterVideo[]';

      // Append all the elements together
      columnDiv.appendChild(videoLabel);
      columnDiv.appendChild(chapterVideoInput);

      flexDiv.appendChild(chapterTitleInput);
      flexDiv.appendChild(chapterDescriptionTextarea);
      flexDiv.appendChild(columnDiv);

      chapterDiv.appendChild(chapterHeading);
      chapterDiv.appendChild(flexDiv);

      // Add the chapter div to an existing container element with id "chaptersContainer"
      // const chaptersContainer = document.getElementById('chaptersContainer');
      chaptersContainer.appendChild(chapterDiv);

});

    </script>
    <script src="../../js/admin_dash.js?v=<?php echo time(); ?>"></script>
  </body>
</html>
