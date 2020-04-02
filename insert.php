<?php
  // Include db config
  require_once 'db.php';

  // Init vars
  $name = $email = $password = $confirm_password = '';
  $name_err = $email_err = $password_err = $confirm_password_err = '';
  $error = '';
  // Process form when post submit
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
  // Sanitize POST
  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

  // Put post vars in regular vars
  $name =  trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $phone = $_POST['phone'];
  $confirm_password = trim($_POST['confirm_password']);

  // Validate email
  if(empty($email)){
    http_response_code(400);
    $email_err = '<p>Please enter email</p>';
    echo $email_err;
  } else {
    // Prepare a select statement
    $sql = 'SELECT id FROM users WHERE email = :email';

    if($stmt = $pdo->prepare($sql)){
      // Bind variables
      $stmt->bindParam(':email', $email, PDO::PARAM_STR);

      // Attempt to execute
      if($stmt->execute()){
        // Check if email exists
        if($stmt->rowCount() === 1){
          $email_err = '<p>Email is already taken</p>';
          echo $email_err;
        }
      } else {
        http_response_code(500);
        die('Something went wrong1');
      }
    }

    unset($stmt);
  }
  if(empty($email_err)) 
  {if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // get details of the uploaded file
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    // sanitize file-name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');

    if (in_array($fileExtension, $allowedfileExtensions))
    {
      // directory in which the uploaded file will be moved
      $uploadFileDir = './uploads/';
      $dest_path = $uploadFileDir . $newFileName;

      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        $message ='File is successfully uploaded.';
       // echo $message;
      }
      else 
      {   http_response_code(400);
        $message = '<p>There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.</p>';
        echo $message;
      }
    }
    else
    {  http_response_code(400);
      $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
      echo $message;
    }
  }
  else
  {
    $message = 'There is some error in the file upload. Please check the following error.'.'   '.'Error:' . $_FILES['uploadedFile']['error'];
    
    echo $message;
  }}
    

    // Validate name
    if(empty($name)){
      http_response_code(400);
      $name_err = '<p>Please enter name</p>';
      echo $name_err;
    }

    // Validate password
    if(empty($password)){
      http_response_code(400);
      $password_err = '<p>Please enter password</p>';
    } elseif(strlen($password) < 6){
      http_response_code(400);
      $password_err = '<p>Password must be at least 6 characters </p>';
      echo $password_err;
    }

    // Validate Confirm password
    if(empty($confirm_password)){
      http_response_code(400);
      $confirm_password_err = '<p>Please confirm password</p>';
      echo $confirm_password_err;
    } else {
      if($password !== $confirm_password){
        http_response_code(400);
        $confirm_password_err = '<p>Passwords do not match</p>';
        echo $confirm_password_err;
      }
    }

    // Make sure errors are empty
    if(empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
      // Hash password
      $password = password_hash($password, PASSWORD_DEFAULT);

      // Prepare insert query
      $sql = 'INSERT INTO users (name, email, password,phone,file_name) VALUES (:name, :email, :password,:phone,:file)';

      if($stmt = $pdo->prepare($sql)){
        // Bind params
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':file', $newFileName, PDO::PARAM_STR);

        // Attempt to execute
        if($stmt->execute()){
          // Redirect to login
         // header('location: login.php');
         http_response_code(200);
          echo '<script>alert("successfully data inserted");window.location.href = "login.php";</script>';

        } else {
          http_response_code(400);
          die('Something went wrong2');
        }
      }
      unset($stmt);
    }

    // Close connection
    unset($pdo);
  }
?>
