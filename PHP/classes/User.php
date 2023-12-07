<?php
class User{
   public static function handlerReg(){
      $name = $_POST['name'];
      $lastname = $_POST['lastname'];
      $email = $_POST['email'];
      $pass = $_POST['pass'];
      $pass = password_hash($pass, PASSWORD_DEFAULT);
      global $mysqli;
      $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
      if ($result->num_rows) {
   // echo"Вы уже зарегистрированы";
         return json_encode(["result"=>"exist"]);
      } else { 
         $mysqli->query("INSERT INTO `users` ( `name`, `lastname`, `email`, `pass`) VALUES ('$name', '$lastname', '$email', '$pass')");
// echo header("Location: ../html/login.php");
// echo"success";
      return json_encode(["result"=>"success"]);
      }
   }
   public static function login(){
      global $mysqli;
      $email = $_POST['email'];
      $pass = $_POST['pass'];
      $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");
      $row = $result->fetch_assoc();
      if(password_verify($pass, $row['pass'])) {
         $_SESSION ["name"] = $row["name"];
         $_SESSION ["lastname"] = $row["lastname"];
         $_SESSION ["email"] = $row["email"];
         $_SESSION ["pass"] = $row["pass"];
         $_SESSION ["id"] = $row["id"];
         $_SESSION ["img"] = $row["img"];
         echo json_encode(["result"=>'success']);
      } else {
         return json_encode(["result"=>"error"]);
      }
   }
   public static function getUserData(){
      return json_encode($_SESSION);
   }
   public static function logout(){
      session_destroy();
      header("location: /");
   }
   public static function changeUserAvatar(){
      global $mysqli;
      $userId = $_SESSION['id'];
      $img = $_FILES['avatar'];
      $extation = explode("/", $img['type'])[1];
      $fileName = time().'.'.explode("/", $img['type'])[1];
      $uploadDir = 'sourse/'.$fileName;
      if ($extation == 'jpeg'|| $extation == 'png'){
         move_uploaded_file($img['tmp_name'], $uploadDir);
         $mysqli->query("UPDATE users SET `img`='$uploadDir' WHERE id=1");
         $_SESSION['img'] = "/$uploadDir";
         header('Location: /profile');
      } else {
         echo "Недопустимый формат файла";
      }
      
   }
}

?>