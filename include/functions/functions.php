<?php
global $con;


/*
** Get ALL Function v2.0
** Function To Get All Records From Any Database Table
*/

 function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfiled, $ordering = "DESC") {

			global $con;

			$getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfiled $ordering");

			$getAll->execute();

			$all = $getAll->fetchAll();

			return $all;

	 }


/*
** Get categories Function v1.0
** Function To Get Gategories From Database
*/

 function getCat() {

			global $con;

			$getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");

			$getCat->execute();

			$cats = $getCat->fetchAll();

			return $cats;

	 }

/*
** check if the user Is Not Activated
** Function To Check The RegStatus Of The User
*/
function checkUserStatus($user){

     global $con;

     $stmtx = $con->prepare("SELECT
                       Username, RegStatus
                  FROM
                      users
                  WHERE
                      Username = ?
                  AND
                      RegStatus = 0");
     $stmtx->execute(array($user));

     $status = $stmtx->rowCount();

     return $status;
   }


   /*
 	** Check Items Function v1.0
 	** Function to Check Item In Database [ Function Accept Parameters ]
 	** $select = The Item To Select [ Example: user, item, ]
 	** $Value = The Value Of Select [ Example: Mohamed, Box, Electronic ]
 	*/

 	function checkItem($select, $form, $value){

 			global $con;

 			$statement = $con->prepare("SELECT $select FROM $form WHERE $select = ?");

 			$statement->execute(array($value));

 			$count = $statement->rowCount();

 			return $count;
 	}




/*========================================================= Backend ======================================================*/

	/*
	====================================================================
	** Title Function v1.0
	** Title Function That Echo The Page Title In Case The Page
	** Has The Variable SpageTitle And Echo Defult Title For Other Pages
	====================================================================
	*/

	function getTitle(){

		global $pageTitle;

		if(isset($pageTitle)) {

			echo $pageTitle;

		}else {

			echo 'Defult';
		}
	}


	/*
	** Home Redirect Function v1.0
	** This Function Accept Parameters
	** $errorMsg = Echo The Error Message
	** $seconds = Seconds Befor Redirecting
	------------------------------------------------------------------------
	function RedirectHome($errorMsg, $seconds = 3) {

		echo "<div class='alert alert-danger'>$errorMsg</div>";

		echo "<div class='alert alert-info'>You Will Be Redirected to Homepage After $seconds Seconds .</div>";

		header("refresh:$seconds;url=index.php");

		exit();
	}

	==========================================================================================================================

	/*
	** Home Redirect Function v2.0
	** This Function Accept Parameters
	** $theMsg = Echo The Error Message [ Error, Success, Warning ]
	** $url = The link You Want To Redirect To
	** $seconds = Seconds Befor Redirecting
	*/

	function redirectHome ($theMsg, $url = null, $seconds = 5) {

	if ($url === null) {
		$url = "index.php";
		$link = "Homepage";
	} else {
		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
			$url = $_SERVER['HTTP_REFERER'];
			$link = "Previous Page";
		} else {
			$url = "index.php";
			$link = "Homepage";
		}
	}
	echo $theMsg;
	echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds Seconds.</div>";
	header("refresh:$seconds;url=$url");
	exit();
}

	/*
	** Check Items Function v1.0
	** Function to Check Item In Database [ Function Accept Parameters ]
	** $select = The Item To Select [ Example: user, item, ]
	** $Value = The Value Of Select [ Example: Mohamed, Box, Electronic ]
	*/
/*
	function checkItem($select, $form, $value){

			global $con;

			$statement = $con->prepare("SELECT $select FROM $form WHERE $select = ?");

			$statement->execute(array($value));

			$count = $statement->rowCount();

			return $count;
	}


*/
	/*
	** 	Count Number Of Items Function v1.0
	**	Function To Count Number Of Items Rows
	**	$item = the Item To Count
	**	$table = The Table To Choose From
	*/
			function countItems($item, $table){

			global $con;

			$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

			$stmt2->execute();

			return $stmt2->fetchColumn();
		}

		/*
		** Get Latest Records Function v1.0
		** Function To Get Latest Items From Database [ Users, Items, Comments ]
		** $select = Field To Select
		** $table = The Table To Choose From
		** $Limit = Number Of Records To Get
		*/

		 function getLatest($select, $table, $order, $limit = 5) {

			 		global $con;

			 		$getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

					$getStmt->execute();

					$rows = $getStmt->fetchAll();

					return $rows;
			 }
