<?php
    ob_start();
    session_start();
    $pageTitle = 'Login';
    if(isset($_SESSION['user'])){
  		header('location: index.php');

  	}

    include 'init.php';


    // check If User Coming Form HTTP Post Requst

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      if(isset($_POST['login'])){

    	$user        = $_POST['username'];
    	$pass        = $_POST['password'];
    	$hashedPass  = sha1($pass);

    	// check if the user exist in database

    	$stmt = $con->prepare("SELECT
    								   UserID, Username, Password
    						   FROM
    						   		 users
    						   WHERE
    						   		 Username = ?
    						   AND
    						   		 Password = ?");



    	$stmt->execute(array($user, $hashedPass));

      $get = $stmt->fetch();

    	$count = $stmt->rowCount();

    	// if count > 0 this mean the database contain record about this username

    	if ($count > 0) {

    		$_SESSION['user'] = $user;  // Register Session Name

        $_SESSION['uid'] = $get['UserID']; // Register User ID in Session

    		header('Location: index.php'); // Redirect To Dashboard Page
    		exit();

    	   }

      }else {  // Signup
          $fullname   = $_POST['fullName'];
          $username   = $_POST['username'];
          $email      = $_POST['email'];
          $password   = $_POST['password'];
          $password2  = $_POST['password2'];
          $avatar     = $_POST['profile_image'];
          $formErrors = array();

          if(isset($username)){ // Username Security

            $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);

            if (strlen($filterdUser) < 4){

              $formErrors[] = 'Username Must Be Larger Than 4 Characters';
            }
      }

      if(isset($password) && isset($password2)){ // Password Security

          if(empty($password) || empty($password2)){

            $formErrors[] = 'Sorry Password Cant Be Empty';

          }

            if(sha1($password) !== sha1($password2)) {

              $formErrors[] = 'Sorry Password Is Not Match';
            }
        }

        if(isset($email)){ // Email Security

          $filterdemail = filter_var($email, FILTER_SANITIZE_EMAIL);

          if (filter_var($filterdemail, FILTER_VALIDATE_EMAIL) != true) {

              $formErrors[] = 'This Email Is Not Vaild';
          }
        }


        if (empty($formError)) { // Check If There's No Error Proceed The Insert Add New User
				$check = checkItem("Username", "users", $username);
				if ($check == 1) { // Error User Is Exists
					$formErrors[] = 'Sorry This User Is Exists';
				} else { // Insert Into Database
					$stmt = $con->prepare("INSERT INTO
											users(FullName, Username, Email, Password, RegStatus, Date, )
											VALUES(:zfull, :zuser, :zmail, :zpass, :zselec, 0, now())");
					$stmt->execute(array(
            'zfull' => $fullname,
						'zuser' => $username,
            'zmail' => $email,
						'zpass' => sha1($password)

					));

					$successMsg = 'Congrats You Are Now Registerd User';
				    }
			    }
        }
      }
 ?>

 <div class="container login-page">
      <h1 class="text-center">
          <span class="selected" data-class="login">Login</span> | <span data-class="signup">SignUp</span>
      </h1>
      <!-- Start Login Form -->
      <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Your username"/>
        <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type Your password"/>
        <input class="btn btn-primary btn-block" type="submit" name="login" value="Login"/>
      </form>
      <!-- End Login Form -->

      <!-- Start SignUp Form -->
      <form  class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="input-container">
            <input pattern=".{4,}" title="Username Must Be 4 Chars" class="form-control" type="text" name="fullName" autocomplete="off" placeholder="Type Your FullName" required/>
        </div>
        <div class="input-container">
            <input pattern=".{4,}" title="Username Must Be 4 Chars" class="form-control" type="text" name="username" autocomplete="off" placeholder="Type Your username" required/>
        </div>
        <div class="input-container">
            <input class="form-control" type="email" name="email" placeholder="Type a Valid email" required/>
        </div>
        <div class="input-container">
            <input minlength="6" class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type Your password" required/>
        </div>
        <div class="input-container">
            <input minlength="6" class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Type Your password Again" required/>
        </div>
        


        <input class="btn btn-success btn-block" name="signup" type="submit" value="Signup"/>

      </form>
      <!-- End SignUp Form -->

      <div class="the-errors text-center">

          <?php
            if(!empty($formErrors)){

              foreach ($formErrors as $error) {

                echo '<p class="msg error">' .  $error . '</p>';

                }
            }

            if (isset($successMsg)) {

               echo '<div class="msg success">' . $successMsg . '</div>';
            }
           ?>
      </div>
 </div>


   <?php
      include $tpl . "footer.php";
      ob_end_flush();
      ?>
