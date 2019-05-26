<?php

	/*
	==================================================
	= Mange Members Page
	= You Can Add | Edit | Delete Members From Here
	==================================================
	*/
	ob_start();

	session_start();

	$pageTitle = 'Members';

	if(isset($_SESSION['Username'])){

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Mange';

/*================================================= Start Manage ============================================*/

		if ($do == 'Mange') {  // Mange Page

			$query = '';  // RegStatus Page

			if(isset($_GET['page']) && $_GET['page'] == 'Pending') {

				$query = 'AND RegStatus = 0';
			}

				// SELECT All Users Except Admin
				$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");


				// Execute The Statement
				$stmt->execute();

				// Assign To Variable
				$rows = $stmt->fetchAll();

				if(! empty($rows)){

			 ?>

					<h1 class="text-center">Mange Members</h1>
					<div class="container">
								<div class="table-responsive">
										<table class="main-table mange-members text-center table table-bordered">
													<tr>
															<td>#ID</td>
															<td>profile_image</td>
															<td>FullName</td>
															<td>Username</td>
															<td>Email</td>
															<td>Registerd Date</td>
															<td>Control</td>
													</tr>

													<?php

															foreach ($rows as $row) {

																echo "<tr>";
																			echo "<td>" . $row['UserID'] . "</td>";
																			echo "<td>";
																						if(empty($row['profile_image'])){
																								echo 'No Image';
																						} else {
																								echo "<img src='uploads/users/" . $row['profile_image'] . "' alt='' />";
																							}
																			echo"</td>";
																			echo "<td>" . $row['FullName'] . "</td>";
																			echo "<td>" . $row['Username'] . "</td>";
																			echo "<td>" . $row['Email'] . "</td>";
																			echo "<td>" . $row['Date'] . "</td>";
																			echo "<td>
																							<a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
																							<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

																							if ($row['RegStatus'] == 0) {

																								echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] . "' class='btn btn-info activate'><i class='fa fa-check'></i>Activate</a>";
																							}

																			echo "</td>";
																echo "</tr>";
															}
													?>

										</table>
								</div>

						<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add New Member</a>

					</div>

				<?php } else {

					echo '<div class="container">';
							echo '<div class="nice-message">There\'s No Members Show</div>';
					echo '</div>';
				}?>
<?php
		/*================================================= End Manage ============================================*/
		/*================================================= Start Add ============================================*/
					} elseif ($do == 'Add') { // Add Memmbers Page ?>

								<h1 class="text-center">Add New Member</h1>
								<div class="container">
									<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
										<!-- Start Full Name Field -->
										<div class="form-group form-group-lg">
											<label class="col-sm-2 control-label">Full Name</label>
											<div class="col-sm-10 col-md-4">
												<input type="text" name="full" class="form-control" autocomplete="off" required="requird" placeholder="Full Name Appear In Your Profile Page" />
											</div>
										</div>
										<!-- End Full Name Field -->

										<!-- Start Username Field -->
										<div class="form-group form-group-lg">
											<label class="col-sm-2 control-label">Username</label>
											<div class="col-sm-10 col-md-4">
												<input type="text" name="username" class="form-control" autocomplete="off" required="requird" placeholder="Username To Login Into Shop" />
											</div>
										</div>
										<!-- End Username Field -->

										<!-- Start Email Field -->
										<div class="form-group form-group-lg">
											<label class="col-sm-2 control-label">Email</label>
											<div class="col-sm-10 col-md-4">
												<input type="email" name="email" class="form-control" required="requird" placeholder="Email Must Be Valid" />
											</div>
										</div>
										<!-- End Email Field -->

										<!-- Start Password Field -->
										<div class="form-group form-group-lg">
											<label class="col-sm-2 control-label">Password</label>
											<div class="col-sm-10 col-md-4">
												<input type="password" name="password" class="Password form-control" autocomplete="password" required="requird" placeholder="Password Must Be Hard & Complex" />
												<i class="show-pass fa fa-eye fa-2x"></i>
											</div>
										</div>
										<!-- End Password Field -->

										<!-- Start Profile imge Field -->
										<div class="form-group form-group-lg">
											<label class="col-sm-2 control-label">User Image</label>
											<div class="col-sm-10 col-md-4">
												<input type="file" name="profile_image" class="form-control" autocomplete="off" />
											</div>
										</div>
										<!-- End Profile imge Field -->

										<!-- Start Submit Field -->
										<div class="form-group">
											<div class="col-sm-offset-2 col-sm-10">
												<input type="submit" value="Add Memmber" class="btn btn-primary btn-lg" />
											</div>
										</div>
										<!-- End Submit Field -->

									</form>
								</div>

					<?php
					/*================================================= End Add ============================================*/
					/*================================================= Start Insert =======================================*/
						}elseif ($do=='Insert') {  // Insert Memmber Pag

								if ($_SERVER['REQUEST_METHOD'] == 'POST') {

										echo"<h1 class='text-center'>Insert Member</h1>";
										echo "<div class='container'>";

										// Upload Variables

										$avatarName 	= $_FILES['profile_image']['name'];
										$avatarSize 	= $_FILES['profile_image']['size'];
										$avatarTmp 		= $_FILES['profile_image']['tmp_name'];
										$avatarType 	= $_FILES['profile_image']['type'];

										// List Of Allowed File Typed To Upload

										$avatarAllowedExtension = array("jpeg", "jpg", "png");

										// Get Profile image Extension
									//	'image.png';

										$avatarExtension = strtolower(end(explode('.', $avatarName)));

										// Get Variables Form The Form
										 $name 		= $_POST['full'];
										 $user 		= $_POST['username'];
										 $email 	= $_POST['email'];
										 $pass 		= $_POST['password'];
										 $hashPass = sha1($_POST['password']);
										 // Validate The Form

										 $formErrors = array();

										 if (empty($name)) {

											 $formErrors[] = 'Full Name Cant Be Empty';

										 }

										 if (strlen($user) < 4) {

											 $formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';

										 }

										 if (strlen($user) > 20) {

											 $formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';

										 }

										 if (empty($email)) {

											 $formErrors[] = 'Email Cant Be Empty';

										 }


										 if (empty($pass)) {

											 $formErrors[] = 'password Cant Be <strong>Empty</strong>';

										 }
										 if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){

											 	$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
										 }

										 if (empty($avatarName)){

											 	$formErrors[] = 'Image Is <strong>Requird</strong>';
										 }

										 if ($avatarSize > 4194304){

											 	$formErrors[] = 'Image Cant Be Larger Than <strong>4MB</strong>';
										 }

										 // Loop Into Errors Array And Echo It
										 foreach ($formErrors as $error) {

											 echo '<div class="alert alert=danger">' . $error . '</div>';
										 }

										 // Check If There's No Error Proceed The Update Operation
										 if (empty($formErrors)) {

											 $avatar = rand(0, 100000) . '_' . $avatarName;

											 move_uploaded_file($avatarTmp, "uploads\users\\" . $avatar);

													// 	Check If User Exist in Database
													$check = checkItem("Username", "users", $user);

													if($check == 1) {

														$theMsg = '<div class="alert alert-danger">Sorry This Username Is Exist</div>';

														redirectHome($theMsg, 'back');
													} else {

														 // Insert Userinfo In Database

															$stmt = $con->prepare("INSERT INTO
																						users(FullName, Username, Email, Password, RegStatus, Date, profile_image)
																						VALUES(:zname, :zuser, :zmail, :zpass, 1, now(), :zprofile_image)");
															$stmt->execute(array(
																						':zname' => $name,
																						':zuser' => $user,
																						':zmail' => $email,
																						':zpass' => $hashPass,
																					  ':zprofile_image' => $avatar));

															//Echo Success Message
															$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Inserted</div>';

															redirectHome($theMsg, 'back');

															 }
													 }

												}else {

													echo "<div class'container'>";

												 $theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';
												 redirectHome($theMsg);

												 echo "</div>";
											 }

											 echo "</div>";

 /*========================================================== End Insert =============================================*/
 /*========================================================== Start Edit =============================================*/
										} elseif ($do =='Edit') {  // Edit Page

										// Check If Get Request userid Is Numeric & Get The Integer Value Of It
											$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']):0; // Security

											//Select All Data Depend On This ID

											$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1"); // LIMIT 1 ► One row

											// Execute Query

								    		$stmt->execute(array($userid));

								    		// Fetch The Data

								    		$row = $stmt->fetch();

								    		// The Row Count

								    		$count = $stmt->rowCount();

								    		// If Thers's Such ID Show The Form

								    		if($count > 0) { ?>
															<h1 class="text-center">Edit Member</h1>
															<div class="container">
																<form class="form-horizontal" action="?do=Update" method="POST">
																	<input type="hidden" name="userid" value="<?php echo $userid ?>" />
																	<!-- Start Full Name Field -->
																	<div class="form-group form-group-lg">
																		<label class="col-sm-2 control-label">Full Name</label>
																		<div class="col-sm-10 col-md-4">
																			<input type="text" name="full" value="<?php echo $row['FullName']?>" class="form-control" required="requird" />
																		</div>
																	</div>
																	<!-- End Full Name Field -->

																	<input type="hidden" name="userid" value="<?php echo $userid ?>" />
																	<!-- Start Username Field -->
																	<div class="form-group form-group-lg">
																		<label class="col-sm-2 control-label">Username</label>
																		<div class="col-sm-10 col-md-4">
																			<input type="text" name="username" value="<?php echo $row['Username'] ?>" class="form-control" autocomplete="off" required="requird" />
																		</div>
																	</div>
																	<!-- End Username Field -->

																	<!-- Start Email Field -->
																	<div class="form-group form-group-lg">
																		<label class="col-sm-2 control-label">Email</label>
																		<div class="col-sm-10 col-md-4">
																			<input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="requird" />
																		</div>
																	</div>
																	<!-- End Email Field -->

																	<!-- Start Password Field -->
																	<div class="form-group form-group-lg">
																		<label class="col-sm-2 control-label">Password</label>
																		<div class="col-sm-10 col-md-4">
																			<input type="hidden" name="oldpassword" value="<?php echo $row['password'] ?>" />
																			<input type="password" name="newpassword" class="form-control" autocomplete="new-password" />
																		</div>
																	</div>
																	<!-- End Password Field -->

																	<!-- Start Submit Field -->
																	<div class="form-group">
																		<div class="col-sm-offset-2 col-sm-10">
																			<input type="submit" value="Save" class="btn btn-primary btn-lg" />
																		</div>
																	</div>
																	<!-- End Submit Field -->

																</form>
															</div>

															<?php
															} else {
															// If There's No Such ID Show Error Message
																echo "<div class='container'>";

																$theMsg = '<div class="alert alert-danger">Theres No Such ID</div>';

																redirectHome($theMsg);

																echo "</div>";
																}
/*========================================================== End Edit =============================================*/
/*========================================================== Start Update =============================================*/
													     } elseif ($do == 'Update') {  //Update Page

																		 echo "<h1 class='text-center'>Update Member</h1>";
																		 echo "<div class='container'>";

													            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

													         			// Get Variables Form The Form

																				$id 	  = $_POST['userid'];
																				$name 	= $_POST['full'];
																				$user 	= $_POST['username'];
																				$email 	= $_POST['email'];

																				// Password Trick
																				// Condition ? True : False

																				$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

																				// Validate The Form

																				$formErrors = array();

																				if (empty($user)) {

																					$formErrors[] = 'Username Cant Be Empty';

																				}



																				if (empty($email)) {

																					$formErrors[] = 'Email Cant Be Empty';

																				}

																				if (empty($name)) {

																					$formErrors[] = 'Full Name Cant Be Empty';

																				}

																				// Loop Into Errors Array And Echo It

																				foreach ($formErrors as $error) {

																					echo '<div class="alert alert=danger">' . $error . '</div>';
																				}

																				// Check If There's No Error Proceed The Update Operation
																				if (empty($formErrors)) {


																					$stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
																					$stmt2->execute(array($user, $id));
																					$count = $stmt2->rowCount();

																					if ($count == 1) {

																						$theMsg = "<div class='alert alert-danger'>Sorry This Users Is Exist</div>";
																						redirectHome($theMsg, 'back');

																					} else {

																						// Update The Database with This Info

																						$stmt = $con->prepare("UPDATE users SET FullName = ?, Username = ?, Email = ?, Password = ?  WHERE UserID = ?");
																						$stmt->execute(array($name, $user, $email, $pass, $id));

																						//Echo Success Message
																						$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Updat</div>';

																						redirectHome($theMsg, 'back');

																				}

																			}

																		 } else {

																			$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

																			redirectHome($theMsg);
																		}

																		echo "</div>";
/*========================================================== End Update =============================================*/
/*========================================================== Start Delete =============================================*/

																		} elseif ($do == 'Delete') {	// Delete Member Page

																			echo"<h1 class='text-center'>Delete Member</h1>";
								 										 	echo "<div class='container'>";

																		// Check If Get Request userid Is Numeric & Get The Integer Value Of It
																			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']): 0; // Security

																			//Select All Data Depend On This ID
																			$check = checkItem('userid', 'users', $userid);


																    		// If Thers's Such ID Show The Form
																    		if($check > 0) {

																							$stmt = $con->prepare("DELETE FROM users WHERE UserID  = :zuser");

																							$stmt->bindParam(":zuser", $userid);

																							$stmt->execute();

																							//Echo Success Message
																							$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';

																							redirectHome($theMsg, 'back');

																							} else {

																									$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

																									redirectHome($theMsg);
																							}

																									echo '</div>';

/*========================================================== End Delete =============================================*/
/*========================================================== Start Activate =============================================*/
																							}elseif ($do == 'Activate') {

																								echo"<h1 class='text-center'>Activate Member</h1>";
																								echo "<div class='container'>";

																							// Check If Get Request userid Is Numeric & Get The Integer Value Of It
																								$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']):0;

																								//Select All Data Depend On This ID
																								$check = checkItem('userid', 'users', $userid);


																									// If Thers's Such ID Show The Form
																									if($check > 0) {

																												$stmt = $con->prepare("UPDATE users SET RegStatus  = 1 WHERE UserID = ?");

																												$stmt->execute(array($userid));

																												//Echo Success Message
																												$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Updeted Deleted</div>';

																												redirectHome($theMsg);

																												} else {

																														$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

																														redirectHome($theMsg);
																												}

																														echo '</div>';
																							}
/*========================================================== End Activate =============================================*/

																							include $tpl . 'footer.php';

																								} else {

																									header('Location: index.php');

																									exit();
																								}
																								ob_end_flush();
																								?>
