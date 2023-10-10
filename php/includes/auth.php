<?php 
include("./includes/db.php");

//=================
//=================
//====Sign Up======
//=================
//=================
$error ='';
$succes = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['signUpBtn'])) {
        $user_name = htmlspecialchars($_POST['fullName']);
        $user_age = htmlspecialchars($_POST['age']);
        $user_email = htmlspecialchars($_POST['email']);
        $user_password = htmlspecialchars($_POST['password']);
        $user_passwordRepeat = htmlspecialchars($_POST['passwordRepeat']);
        
        //regex
        $name_Pattern = "#^[a-zA-Z]+$#";
        $age_Pattern = "#^[0-9]+$#";
         //condition
        if (!preg_match($name_Pattern, $user_name) || strlen($user_name) >20 || strlen($user_name <3)) {
            $error = 'Invalide Name'; 
        }elseif(!preg_match($age_Pattern, $user_age) || empty($user_age) || $user_age <18|| $user_age > 140){
            $error = 'Please Type Valid Age'; 
        }elseif (empty($user_email)) {
            $error = "Email is required.";
        }elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        }elseif(empty($user_password) || strlen($user_password) >100 || strlen($user_password)<4 ){
            $error = 'Please Type A Proper Password';
        }elseif($user_passwordRepeat !== $user_password){
            $error = 'Password Does Not Match';
        }else{$newPass = password_hash($user_password, PASSWORD_DEFAULT);} 

        //check if the email is already in db ---------
        $query = $conn->prepare("SELECT * FROM `member`");
        $execute = $query->execute();
        if ($execute) {
          while($row = $query->fetch(PDO::FETCH_ASSOC)){
            $sql_email = $row['mem_email'];
            if ($sql_email == $user_email) {$error = 'Email Already Taken';}
          }
        }
        if ($error =='') {
            $succes = 'User Created Succesfully';
                  $query = $conn->prepare("INSERT INTO `member`
                  (`mem_name`, `mem_age`, `mem_email`, `mem_password`) VALUES (:name, :age, :email, :password)");
                  $query->bindParam(':name', $user_name);
                  $query->bindParam(':age', $user_age);
                  $query->bindParam(':email', $user_email);
                  $query->bindParam(':password', $newPass);
                  if ($query->execute()) {
                      $success = 'User created successfully';
                      header("Location:./login.php");
                      exit();
                  } else {
                      $error = 'Error inserting user into the database';
                  }
        }
    }
}

//=================
//=================
//====login========
//=================
//=================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login_btn'])) {
        $user_login_email = htmlspecialchars($_POST['email']);
        $user_login_password = htmlspecialchars($_POST['password']);
        if (!filter_var($user_login_email, FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format.";
        }elseif(empty($user_login_password) || strlen($user_login_password) >100 || strlen($user_login_password)<4){$error = 'Please Type A Proper Password';}
        if ($error == '') {
        if ($user_login_email == 'hassan@gmail.com' && $user_login_password == 'karim1212') {
            session_start();
            $_SESSION['admin_id'] =1;
            $_SESSION['admin_name'] ='hassan elbakali';
            $_SESSION['admin_age'] = 33;
            $_SESSION['admin_email'] = 'hassan@gmail.com';
            $_SESSION['admin_password'] ='karim1212';
            header("Location:./admin/overView.php");
        }else{
            $query = $conn->prepare("SELECT * FROM `member` WHERE mem_email = :email ");
            $query->bindParam(':email', $user_login_email); 
            $execute = $query->execute();
            if ($execute) {
                $num_rows = $query->rowCount();  
                if ($num_rows >0) {
                   $row = $query->fetch(PDO::FETCH_ASSOC);
                   $user_id = $row['mem_id'];
                   $user_name = $row['mem_name'];
                   $user_age = $row['mem_age'];
                   $user_email = $row['mem_email'];
                   $user_password = $row['mem_password'];
                   if (password_verify($user_login_password , $user_password)) {
                       session_start();
                       $_SESSION['user_id'] =$user_id;
                       $_SESSION['user_name'] =$user_name;
                       $_SESSION['user_age'] =$user_age;
                       $_SESSION['user_email'] =$user_email;
                       $_SESSION['user_password'] =$user_password;
                       header("location:./members/overview.html");
                   }else{
                     $error = 'Wrong Password';
                   }
                }else{
                   $error = 'Email Not Found';
                }
            }
            
        }
      
        
        }
    }
}