<?php

 		/*
		==========================================================
		== Items Page
		==========================================================
		*/

		ob_start();  //Output Buffering Start

		session_start();

		$pageTitle = 'Items';

		if (isset($_SESSION['Username'])){

				include 'init.php';

				$do = isset($_GET['do']) ? $_GET['do'] : 'Mange';

/*================================================= Start Manage ============================================*/

				if ($do == 'Mange') {


					 $stmt = $con->prepare("SELECT
						  												items.*,
									 												categories.C_Name AS category_name,
																				  users.Username
																		  FROM
																			 		items
						 													INNER JOIN
																			 		categories
																		  ON
																			 		categories.ID = items.Cat_ID
																			INNER JOIN
																			 		users
																		  ON
																			 		users.UserID = items.Item_ID
																			ORDER BY Item_ID DESC");


					 // Execute The Statement
					 $stmt->execute();

					 // Assign To Variable
					 $items = $stmt->fetchAll();

					 if (! empty($items)){

					?>

						 <h1 class="text-center">Mange Items</h1>
						 <div class="container">
									 <div class="table-responsive">
											 <table class="main-table text-center table table-bordered">
														 <tr>
																 <td>#ID</td>
																 <td>Name</td>
																 <td>Description</td>
																 <td>Price</td>
																 <td>Adding Date</td>
																 <td>Category</td>
																 <td>Username</td>
																 <td>Control</td>
														 </tr>

														 <?php

																 foreach ($items as $item) {

																	 echo "<tr>";
																				 echo "<td>" . $item['Item_ID'] . "</td>";
																				 echo "<td>" . $item['Name'] . "</td>";
																				 echo "<td>" . $item['Description'] . "</td>";
																				 echo "<td>" . $item['Price'] . "</td>";
																				 echo "<td>" . $item['Add_Date'] . "</td>";
																				 echo "<td>" . $item['category_name'] . "</td>";
																				 echo "<td>" . $item['Username'] . "</td>";
																				 echo "<td>
																								 <a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
																								 <a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
																								 if ($item['Approve'] == 0) {
	 																								echo "<a
																									 href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "'
																									 class='btn btn-info activate'>
																									 <i class='fa fa-check'></i>Approve</a>";
	 																							}

																				 echo "</td>";
																	 echo "</tr>";
																 }
														 ?>

											 </table>
									 </div>

							 <a href="items.php?do=Add" class="btn btn-primary">
								 <i class="fa fa-plus"></i> New Item
							 </a>

						 </div>

					 <?php } else {

						echo '<div class="container">';
								echo '<div class="nice-message">There\'s No Items Show</div>';
								echo '<a href="items.php?do=Add" class="btn btn-primary">
 								 					<i class="fa fa-plus"></i> New Item
 							 			 </a>';
						echo '</div>';
					}?>


		<?php
/*================================================= End Manage ============================================*/

/*================================================= Start Add ============================================*/
				} elseif ($do == 'Add') { ?>
					<h1 class="text-center">Add New Item</h1>
					<div class="container">
						<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
							<!-- Start Name Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="name" class="form-control" placeholder="Name Of the item" />
								</div>
							</div>
							<!-- End Name Field -->

							<!-- Start Description Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Description</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="description" class="form-control" placeholder="Description Of the item" />
								</div>
							</div>
							<!-- End Description Field -->

							<!-- Start Price Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Price</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="price" class="form-control" placeholder="Price Of the item" />
								</div>
							</div>
							<!-- End Price Field -->

							<!-- Start Country Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Country</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="country" class="form-control" placeholder="Country Of Made" />
								</div>
							</div>
							<!-- End Country Field -->

							<!-- Start Profile imge Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Items Image</label>
								<div class="col-sm-10 col-md-4">
									<input type="file" name="items_image" class="form-control" autocomplete="off"/>
								</div>
							</div>
							<!-- End Profile imge Field -->

							<!-- Start Status Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Status</label>
								<div class="col-sm-10 col-md-4">
										<select name="status">
												<option value="0">....</option>
												<option value="1">New</option>
												<option value="2">Like New</option>
												<option value="3">Used</option>
												<option value="4">Very Old</option>
										</select>
								</div>
							</div>
							<!-- End Status Field -->

							<!-- Start Members Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Member</label>
								<div class="col-sm-10 col-md-4">
										<select name="member">
												<option value="0">....</option>
												<?php
														$allMembers = getAllFrom("*", "users", "", "", "UserID");
														foreach ($allMembers as $user) {

															echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
														}
											  ?>
										</select>
								</div>
							</div>
							<!-- End Members Field -->

							<!-- Start Categories Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Category</label>
								<div class="col-sm-10 col-md-4">
										<select name="category">
												<option value="0">....</option>
												<?php
														$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
														foreach ($allCats as $cat) {
															echo "<option value='" . $cat['ID'] . "'>" . $cat['C_Name'] . "</option>";
															$childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
															foreach ($childCats as $child) {
																echo "<option value='" . $child['ID'] . "'>---" . $child['C_Name'] . "</option>";
															}
														}
											  ?>
										</select>
								</div>
							</div>
							<!-- End Categories Field -->


							<!-- Start Tags Field -->
							<div class="form-group form-group-lg">
								<label class="col-sm-2 control-label">Tags</label>
								<div class="col-sm-10 col-md-4">
									<input type="text" name="tags" class="form-control" placeholder="Separte Tags With Comma (,)" />
								</div>
							</div>
							<!-- End Tags Field -->


							<!-- Start Submit Field -->
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
								</div>
							</div>
							<!-- End Submit Field -->

						</form>
					</div>

	<?php
/*================================================= End Add ============================================*/
/*================================================= Start Insert =======================================*/

				} else if ($do =='Insert') {
					if ($_SERVER['REQUEST_METHOD'] == 'POST') {

							echo"<h1 class='text-center'>Insert Item</h1>";
							echo "<div class='container'>";


							 // Get Variables Form The Form
							 $name 						= $_POST['name'];
							 $desc 						= $_POST['description'];
							 $price 					= $_POST['price'];
							 $country 				= $_POST['country'];
							 $items_image    	= $_FILES['items_image'] ['name'];
							 $items_image_tmp = $_FILES['items_image'] ['tmp_name'];
							 $status 					= $_POST['status'];
							 $member 					= $_POST['member'];
							 $cat 						= $_POST['category'];
							 $tags 						= $_POST['tags'];
							 // Validate The Form

							 $formErrors = array();

							 if (empty($name)) {

								 $formErrors[] = 'Name Can\'t be <strong>Empty</strong>';

							 }



							 if (empty($desc)) {

								 $formErrors[] = 'Description Can\'t be <strong>Empty</strong>';

							 }

							 if (empty($price)) {

								 $formErrors[] = 'Price Can\'t be <strong>Empty</strong>';

							 }

							 if (empty($country)) {

								 $formErrors[] = 'Country Can\'t be <strong>Empty</strong>';

							 }

							 if ($status == 0) {

								 $formErrors[] = 'You Must Choose the <strong>Status</strong>';

							 }

							 if ($member == 0) {

								 $formErrors[] = 'You Must Choose the <strong>Member</strong>';

							 }

							 if ($cat == 0) {

							 	$formErrors[] = 'You Must Choose the <strong>Category</strong>';

							 }



							 // Loop Into Errors Array And Echo It
							 foreach ($formErrors as $error) {

								 echo '<div class="alert alert=danger">' . $error . '</div>';
							 }

							 // Check If There's No Error Proceed The Update Operation
							 if (empty($formErrors)) {


								 	// move uplode image
									move_uploaded_file($items_image_tmp, "uploads/items/$items_image");

											 // Insert Userinfo In Database

												$stmt = $con->prepare("INSERT INTO
																items( Name, Description, Price, Add_Date, Country_Made, items_image, Status, Cat_ID, Member_ID, tags)
															VALUES( :zname, :zdesc, :zprice, now(), :zcountry, :zitems_img, :zstatus, :zcat, :zmember, :ztags)");
												$stmt ->execute(array(
																			'zname' 			=> $name,
																			'zdesc' 			=> $desc,
																			'zprice' 			=> 	$price,
																			'zcountry' 		=> $country,
																			'zitems_img' 	=> $items_image,
																			'zstatus' 		=> $status,
																			'zcat' 				=> $cat,
																			'zmember' 		=> $member,
																			'ztags'    		=> $tags
																		));

												//Echo Success Message
												$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Inserted</div>';

												redirectHome($theMsg, 'back');

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

				} elseif ($do == 'Edit') {
							// Check If Get Request itemid Is Numeric & Get The Integer Value Of It
								$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0; // Security

								//Select All Data Depend On This ID

								$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?"); // LIMIT 1 ► One row

								// Execute Query

									$stmt->execute(array($itemid));

									// Fetch The Data

									$item = $stmt->fetch();

									// The Row Count

									$count = $stmt->rowCount();

									// If Thers's Such ID Show The Form

									if($count > 0) { ?>
											<h1 class="text-center">Edit Item</h1>
											<div class="container">
												<form class="form-horizontal" action="?do=Update" method="POST">
													<input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
													<!-- Start Name Field -->
													<div class="form-group form-group-lg">
														<label class="col-sm-2 control-label">Name</label>
														<div class="col-sm-10 col-md-4">
															<input type="text" name="name" class="form-control" placeholder="Name Of the item" value="<?php echo $item['Name'] ?>" />
														</div>
													</div>
													<!-- End Name Field -->

													<!-- Start Description Field -->
													<div class="form-group form-group-lg">
														<label class="col-sm-2 control-label">Description</label>
														<div class="col-sm-10 col-md-4">
															<input type="text" name="description" class="form-control" placeholder="Description Of the item" value="<?php echo $item['Description'] ?>" />
														</div>
													</div>
													<!-- End Description Field -->

													<!-- Start Price Field -->
													<div class="form-group form-group-lg">
														<label class="col-sm-2 control-label">Price</label>
														<div class="col-sm-10 col-md-4">
															<input type="text" name="price" class="form-control" placeholder="Price Of the item" value="<?php echo $item['Price'] ?>" />
														</div>
													</div>
													<!-- End Price Field -->

													<!-- Start Country Field -->
													<div class="form-group form-group-lg">
														<label class="col-sm-2 control-label">Country</label>
														<div class="col-sm-10 col-md-4">
															<input type="text" name="country" class="form-control" placeholder="Country Of Made" value="<?php echo $item['Country_Made'] ?>" />
														</div>
													</div>
													<!-- End Country Field -->

													<!-- Start Status Field -->
													<div class="form-group form-group-lg">
														<label class="col-sm-2 control-label">Status</label>
														<div class="col-sm-10 col-md-4">
																<select name="status">
																		<option value="0">....</option>
																		<option value="1" <?php if ($item['Status'] == 1){ echo 'selected';} ?>>New</option>
																		<option value="2" <?php if ($item['Status'] == 2){ echo 'selected';} ?>>Like New</option>
																		<option value="3" <?php if ($item['Status'] == 3){ echo 'selected';} ?>>Used</option>
																		<option value="4" <?php if ($item['Status'] == 4){ echo 'selected';} ?>>Very Old</option>
																</select>
														</div>
													</div>
													<!-- End Status Field -->

													<!-- Start Members Field -->
													<div class="form-group form-group-lg">
														<label class="col-sm-2 control-label">Member</label>
														<div class="col-sm-10 col-md-4">
																<select name="member">
																		<option value="0">....</option>
																		<?php
																				$stmt = $con->prepare("SELECT * FROM users");
																				$stmt->execute();
																				$users = $stmt->fetchAll();
																				foreach ($users as $user) {

																					echo "<option value='" . $user['UserID'] . "'";
																				  if ($item['Member_ID'] == $user['UserID']){ echo 'selected';}
																					echo">" . $user['Username'] . "</option>";
																				}
																	  ?>
																</select>
														</div>
													</div>
													<!-- End Members Field -->

													<!-- Start Categories Field -->
													<div class="form-group form-group-lg">
														<label class="col-sm-2 control-label">Category</label>
														<div class="col-sm-10 col-md-4">
																<select name="category">
																		<option value="0">....</option>
																		<?php
																				$stmt2 = $con->prepare("SELECT * FROM categories");
																				$stmt2->execute();
																				$cats = $stmt2->fetchAll();
																				foreach ($cats as $cat) {

																					echo "<option value='" . $cat['ID'] . "'";
																					 if ($item['Cat_ID'] == $cat['ID']){ echo 'selected';}
																					 echo ">" . $cat['C_Name'] . "</option>";
																				}
																	  ?>
																</select>
														</div>
													</div>
													<!-- End Categories Field -->

													<!-- Start Tags Field -->
													<div class="form-group form-group-lg">
														<label class="col-sm-2 control-label">Tags</label>
														<div class="col-sm-10 col-md-4">
															<input type="text" name="tags" class="form-control" placeholder="Separte Tags With Comma (,)" value="<?php echo $item['tags'] ?>" />
														</div>
													</div>
													<!-- End Tags Field -->

													<!-- Start Submit Field -->
													<div class="form-group">
														<div class="col-sm-offset-2 col-sm-10">
															<input type="submit" value="Save Item" class="btn btn-primary btn-sm" />
														</div>
													</div>
													<!-- End Submit Field -->

												</form>
												<?php
												// SELECT All Users Except Admin
												$stmt = $con->prepare("SELECT
								                                    comments.*, users.Username AS Member
								                               FROM
								                                    comments

								                               INNER JOIN
								                                    users
								                                ON
								                                    users.UserID =comments.user_id
																								WHERE item_id = ?");


								                						$stmt->execute(array($itemid)); // Execute The Statment
								                						$rows = $stmt->fetchAll(); // Asign To Variable

																						if(! empty($rows)){

											             ?>

													<h1 class="text-center">Mange Comments[ <?php echo $item['Name'] ?>]</h1>
																<div class="table-responsive">
																		<table class="main-table text-center table table-bordered">
																					<tr>
																							<td>Comment</td>
																							<td>User Name</td>
																							<td>Added Date</td>
																							<td>Control</td>
																					</tr>

																					<?php

																							foreach ($rows as $row) {

																								echo "<tr>";
																											echo "<td>" . $row['comment'] . "</td>";
																											echo "<td>" . $row['user_id'] . "</td>";
																											echo "<td>" . $row['comment_date'] . "</td>";
																											echo "<td>
																															<a href='comments.php?do=Edit&comid=" . $row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
																															<a href='comments.php?do=Delete&comid=" . $row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

																															if ($row['status'] == 0) {

																																echo "<a href='comments.php?do=Approve&comid=" . $row['c_id'] . "' class='btn btn-info activate'><i class='fa fa-check'></i>Approve</a>";
																															}

																											echo "</td>";
																								echo "</tr>";
																							}
																					?>

																		</table>
																</div>
															<?php } ?>
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
				} elseif ($do == 'Update') {
							echo "<h1 class='text-center'>Update Item</h1>";
							echo "<div class='container'>";

							if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check Request Method

								$id 		= $_POST['itemid']; // Get Variables From The Form
								$name 	 	= $_POST['name'];
								$desc 	 	= $_POST['description'];
								$price 	 	= $_POST['price'];
								$country	= $_POST['country'];
								$status 	= $_POST['status'];
								$cat 			= $_POST['category'];
								$member 	= $_POST['member'];
								$tags 		= $_POST['tags'];

								$formError = array(); // Validate Form
								if (empty($name)) {
									$formError[] = 'Name Can\'t Be <strong>Empty</strong>';
								}
								if (empty($desc)) {
									$formError[] = 'Description Can\'t Be <strong>Empty</strong>';
								}
								if (empty($price)) {
									$formError[] = 'Price Can\'t Be <strong>Empty</strong>';
								}
								if (empty($country)) {
									$formError[] = 'Country Can\'t Be <strong>Empty</strong>';
								}
								if ($status == 0) {
									$formError[] =  'You Must Choose The <strong>Status</strong>';
								}
								if ($member == 0) {
									$formError[] =  'You Must Choose The <strong>Member</strong>';
								}
								if ($cat == 0) {
									$formError[] =  'You Must Choose The <strong>Category</strong>';
								}

								foreach ($formError as $error) { // Loop Into Errors Array And Echo It
									echo '<div class="alert alert-danger">' . $error . '</div>';
								}

									if (empty($formError)) { // Check If There's No Error Proceed The Update Operation

										$stmt = $con->prepare("UPDATE
																	items
																SET
																	Name 			= ?,
																	Description 	= ?,
																	Price 			= ?,
																	Country_Made 	= ?,
																	Status 			= ?,
																	Cat_ID 			= ?,
																	Member_ID 		= ?,
																	tags  = ?
																WHERE
																	Item_ID 		= ?");

										$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $id));

										$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . 'Record Updated </div>'; // Echo Success Message
										redirectHome($theMsg, 'back', 5);
									}
							} else {

								$theMsg = "<div class='alert alert-danger'>Sorry You Cant Browse This Bage Directly</div>";
								redirectHome($theMsg);
							}

							echo "</div>";

/*========================================================== End Update =============================================*/
/*========================================================== Start Delete =============================================*/
				} elseif ($do == 'Delete') {
							echo"<h1 class='text-center'>Delete Item</h1>";
							echo "<div class='container'>";

							// Check If Get Request Item ID Is Numeric & Get The Integer Value Of It
							$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']): 0; // Security

							//Select All Data Depend On This ID
							$check = checkItem('Item_ID', 'items', $itemid);


								// If Thers's Such ID Show The Form
								if($check > 0) {

											$stmt = $con->prepare("DELETE FROM items WHERE Item_ID  = :zid");

											$stmt->bindParam(":zid", $itemid);

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
/*========================================================== Start Approve =============================================*/
				} elseif ($do == 'Approve') {
					echo"<h1 class='text-center'>Approve Item</h1>";
					echo "<div class='container'>";

					// Check If Get Request itemid Is Numeric & Get The Integer Value Of It
					$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0;

					//Select All Data Depend On This ID
					$check = checkItem('Item_ID', 'items', $itemid);


						// If Thers's Such ID Show The Form
						if($check > 0) {

									$stmt = $con->prepare("UPDATE items SET Approve  = 1 WHERE Item_ID = ?");

									$stmt->execute(array($itemid));

									//Echo Success Message
									$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Updeted Deleted</div>';

									redirectHome($theMsg, 'back');

									} else {

											$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

											redirectHome($theMsg);
									}

											echo '</div>';
										}
/*========================================================== End Activate =============================================*/


				include $tpl . 'footer.php';

			}else {

						header('Location: index.php');

						exit();
					}
					ob_end_flush();
					?>
