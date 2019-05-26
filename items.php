<?php

    session_start();
    $pageTitle = 'Show Items';
    include 'init.php';

    // Check If Get Request itemid Is Numeric & Get The Integer Value Of It
      $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']):0; // Security

      //Select All Data Depend On This ID

      $stmt = $con->prepare("SELECT items.*, categories.C_Name
                              FROM
                                  items
                              INNER JOIN
                                  categories
                              ON
                                  categories.ID = items.Cat_ID
                              WHERE
                                  Item_ID = ?
                              AND
                                  Approve = 1"); // LIMIT 1 ► One row

      // Execute Query

        $stmt->execute(array($itemid));

        $count =$stmt->rowCount();

        if ($count > 0){

        // Fetch The Data

        $item = $stmt->fetch();

?>
<h1 class="text-center"><?php $item['Name'] ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
          <?php
            echo '<img class="img-responsive img-thumbnail center-block" src="admin/uploads/items/'. $item['items_image'].'" alt="" />';
          ?>
        </div>
        <div class="col-md-9 item-info">
            <h2><?php echo $item['Name'] ?></h2>
            <p><?php echo $item['Description'] ?></p>
            <ul class="list-unstyled">

              <li>
                <i class="fa fa-calendar fa-fw"></i>
                <span>Added Date</span> : <?php echo $item['Add_Date'] ?>
              </li>
              <li>
                <i class="fa fa-money fa-fw"></i>
                <span>Price</span> : <?php echo $item['Price'] ?>
              </li>
              <li>
                <i class="fa fa-building fa-fw"></i>
                <span>Made In</span> : <?php echo $item['Country_Made'] ?>
              </li>
              <li>
                <i class="fa fa-tags fa-fw"></i>
                <span>Category</span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php echo $item['C_Name'] ?></a>
              </li>
              <li>
                <i class="fa fa-user fa-fw"></i>
                <span>Add By</span> : <a href="#"><?php echo $item['MemberName'] ?></a>
              </li>
              <li>
                <i class="fa fa-tags fa-fw"></i>
                <span>Tags</span> :
                <?php
                    $allTags = explode(",", $item['tags']);
                    foreach ($allTags as $tag) {
                        $tag = str_replace(' ', '', $tag);
                        $lowertag = strtolower($tag);
                        if (! empty($tag)){
                              echo "<a href='tags.php?name={$lowertag}'>" . $tag . '</a> |';
                            }
                    }
                ?>
              </li>
          </ul>
            <button class="btn btn-primary pull-right">Add To Cart</button>
        </div>
    </div>


    <hr class="custom-hr">
    <?php if (isset($_SESSION['user'])){ ?>

    <!-- Start Add Comment -->
    <div class="row">
        <div class="col-md-offset-3">
          <div class="add-comment">
            <h3>Add Your Comment</h3>
            <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID']?>" method="post">
                <textarea name="comment"></textarea>
                <input class="btn btn-primary" type="submit" value="Add Comment">
            </form>
            <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST'){

                    $comment  = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
                    $itemid   = $item['Item_ID'];
                    $userid   = $_SESSION['uid'];

                    if (! empty($comment)){

                        $stmt = $con->prepare("INSERT INTO
                           comments(comment, status, comment_date, item_id, user_id)
                           VALUES(:zcomment, 0, NOW(), :zitemid, :zuserid)");

                           $stmt->execute(array(

                             'zcomment' => $comment,
                             'zitemid'    => $itemid,
                             'zuserid'  => $userid

                           ));

                           if($stmt){

                              echo '<div class="alert alert-success">Comment Added</div>';
                           }
                    }
                }
              ?>
          </div>
        </div>
    </div>
    <!-- End Add Comment -->
  <?php } else {
      echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> To Add Comment';
  } ?>
    <hr class="custom-hr">
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
                            WHERE
                                item_id = ?
                            AND
                                status = 1
                            ORDER BY
                                c_id DESC");


                        $stmt->execute(array($item['Item_ID'])); // Execute The Statment
                        $comments = $stmt->fetchAll(); // Asign To Variable


                    ?>

      <?php
      foreach ($comments as $comment) {?>
              <div class="comment-box">
                  <div class="row">
                    <div class="col-sm-2 text-center">
                          <?php echo $comment['Member'] ?>
                    </div>
                    <div class="col-sm-10">
                          <p class="lead"><?php echo $comment['comment'] ?></p>
                    </div>
                  </div>
              </div>
              <hr class="custom-hr">
      <?php } ?>

</div>

<?php
} else {
    echo '<div class="container">';
        echo '<div class="alert alert-danger">There\'s No Such ID Or This Item Is Waiting Approvel</div>';
    echo '<div>';
}

    include $tpl . "footer.php";

    ob_end_flush();
?>
