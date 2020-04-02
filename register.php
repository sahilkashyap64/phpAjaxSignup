
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  
  <title>Register An Account</title><script src="./jquery.min.js"></script>
</head>
<body class="bg-primary">
  <div class="container">
    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
          <h2>Create Account</h2>
          <?php echo $error; ?>
          <p>Fill in this form to register</p>
          <form  method="POST" enctype="multipart/form-data"  name="vform" id="form" onsubmit="return Validate()" >
            <div class="form-group" id="username_div">
              <label for="name">Name</label>
              <input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
              <span class="invalid-feedback"><?php echo $name_err; ?></span>
              <div id="name_error"></div>
            </div>
            <div class="form-group" id="email_div">
              <label for="email">Email Address</label>
              <input type="email" name="email"  size="30" class="form-control form-control-lg <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>" onkeyup="manage(this)" >
              <span class="invalid-feedback" ><?php echo $email_err; ?></span>
              <div id="email_error"></div>
            </div>
            <div class="form-group" id="password_div">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
              <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group" id="pass_confirm_div">
              <label for="confirm_password">Confirm Password</label>
              <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
              <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
              <div id="password_error"></div>
            </div>
            <div class="form-group" id="phone_div">
              <label for="phone">Phone</label>
            <input type='number' name='phone' class="form-control form-control-lg <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>"  /></div>
            <div id="phone_error"></div>
            <div>
      <span>Upload a File:</span>
      <input type="file" name="uploadedFile" class="<?php echo (!empty($message)) ? 'is-invalid' : ''; ?>" />
    </div>
    <div class="text-danger" id="err"></div>
            <div class="form-row">
              <div class="col">
                <input type="submit" id="btSubmit" value="Register" class="btn btn-success btn-block">
              </div>
              <div class="col">
                <a href="login.php" class="btn btn-light btn-block">Have an account? Login</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div  class="result"></div>
    
  </div>
  
  <script type="text/javascript" async>
        var username = document.forms['vform']['name'];
    var email = document.forms['vform']['email'];
    var password = document.forms['vform']['password'];
    var password_confirm = document.forms['vform']['confirm_password'];

    var phone = document.forms['vform']['phone'];
    // SELECTING ALL ERROR DISPLAY ELEMENTS
    var name_error = document.getElementById('name_error');
    var email_error = document.getElementById('email_error');
    var password_error = document.getElementById('password_error');
    var phone_error = document.getElementById('phone_error');
    // SETTING ALL EVENT LISTENERS
    username.addEventListener('blur', nameVerify, true);
    phone.addEventListener('blur', phoneVerify, true);
    email.addEventListener('blur', emailVerify, true);
    password.addEventListener('blur', passwordVerify, true);
    // validation function
    
    var isValidate=true;
    
    function Validate() {
      // validate username
      if (username.value == "") {
        username.style.border = "1px solid red";
        document.getElementById('username_div').style.color = "red";
        name_error.textContent = "Usernames is required";
        username.focus();
        isValidate&=false;
      }
      // validate username
      if (username.value.length < 3) {
        username.style.border = "1px solid red";
        document.getElementById('username_div').style.color = "red";
        name_error.textContent = "Username must be at least 3 characters";
        username.focus();
        isValidate&=false;
      }
      // validate phone
      // if (phone.value.length < 11) {
      //   phone.style.border = "1px solid red";
      //   document.getElementById('phone_div').style.color = "red";
      //   phone_error.textContent = "Phone must be at least 10 characters";
      //   phone.focus();
      //   isValidate&=false;
      // }
      // validate email
      if (email.value == "") {
        email.style.border = "1px solid red";
        document.getElementById('email_div').style.color = "red";
        email_error.textContent = "Emails is required";
        email.focus();
        isValidate&=false;
      }
      // validate password
      if (password.value == "") {
        password.style.border = "1px solid red";
        document.getElementById('password_div').style.color = "red";
        password_confirm.style.border = "1px solid red";
        password_error.textContent = "Passwords is required";
        password.focus();
        isValidate&=false;
      }
      // check if the two passwords match
      if (password.value != password_confirm.value) {
        password.style.border = "1px solid red";
        document.getElementById('pass_confirm_div').style.color = "red";
        password_confirm.style.border = "1px solid red";
        password_error.innerHTML = "The two passwords do not match";
        isValidate&=false;
      }
      return !(!isValidate);
    }
    // event handler functions
    function nameVerify() {
      if (username.value != "") {
       username.style.border = "1px solid #5e6e66";
       document.getElementById('username_div').style.color = "#5e6e66";
       name_error.innerHTML = "";
       return true;
      }
    }
    function phoneVerify() {
      if (phone.value != "") {
       phone.style.border = "1px solid #5e6e66";
       document.getElementById('phone_div').style.color = "#5e6e66";
       phone_error.innerHTML = "";
       return true;
      }
    }
    function emailVerify() {
      if (email.value != "") {
      	email.style.border = "1px solid #5e6e66";
      	document.getElementById('email_div').style.color = "#5e6e66";
      	email_error.innerHTML = "";
      	return true;
      }
    }
    function passwordVerify() {
      if (password.value != "") {
      	password.style.border = "1px solid #5e6e66";
      	document.getElementById('password_div').style.color = "#5e6e66";
      	password_error.innerHTML = "";
      	return true;
      }
      
    }
    
    function manage(txt) {
        var bt = document.getElementById('btSubmit');
        if (txt.value != '') {
            bt.disabled = false;
        }
        else {
            bt.disabled = true;
        }
    }
    $(document).ready(function (e) {
 $("#form").on('submit',(function(e) {
  e.preventDefault();
  $.ajax({
         url: "insert.php",
   type: "POST",
   data:  new FormData(this),
   contentType: false,
         cache: false,
   processData:false,
   dataType: 'json',
   beforeSend : function()
   { 
    //$("#preview").fadeOut();
    $("#err").fadeOut();
   },
   success: function(data)
      {
        console.log(data);
    if(data=='successfuldatainserted')
    {
     // invalid file format.
    alert("data successfully entered");
    window.location.href = "login.php";
    }
    
      },
     error: function(e) 
      { 
        $("#err").html(e.responseText).fadeIn();
       // console.log(e.responseText);
    
      }          
    });
 }));
});
    </script>

</body>
</html>
