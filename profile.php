<?php

    session_start();
    $pageTitle = 'Profile';
    include 'init.php';
    if(isset($_SESSION['user'])){
      $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
      $getUser->execute(array($sessionUser));
      $info = $getUser->fetch();
      $userid = $info['UserID'];

?>

    <div class="information block">
        <div class="container">
            <div class="panel panel-primary">
              <div class="panel-heading">My information</div>
              <div class="row">
                  <div class="col-md-4">
                    <div class="profile-image">
                        <img src="1.jpg" alt="">
                    </div>
                  </div>

                  <div class="col-md-8">
                    <div class="panel-body">

                      <ul class="list-unstyled">
                          <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>Name</span>: <?php echo $info['Username'] ?>
                          </li>
                          <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Full Name</span>: <?php echo $info['FullName'] ?>
                          </li>
                          <li>
                            <i class="fa fa-envelope-o fa-fw"></i>
                            <span>Email</span>: <?php echo $info['Email'] ?>
                          </li>
                          <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Register Date</span>: <?php echo $info['Date'] ?>
                          </li>
                          <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Favourite Category: </span>
                          </li>
                        </ul>
                        <a href="#" class="btn btn-default">Edit Information</a>
                    </div>
                  </div>
              </div>

            </div>
        </div>
    </div>

    <div id="my-ads" class="my-ads block">
        <div class="container">
            <div class="panel panel-primary">
              <div class="panel-heading">My Items</div>
              <div class="panel-body">
                  <?php
                    if(! empty($myItems)){
                    echo '<div class="row">';
                    foreach ($myItems as $item) {
                        echo '<div class="col-sm-6 col-md-3">';
                            echo '<div class="thumbnail item-box">';
                            if($item['Approve'] == 0) {
                                echo '<span class="approve-status"Waiting Approvel</span>';
                              }
                                echo '<span class="price-tag">' . $item['Price'] . '</span>';
                                echo '<img class"img-responsive" src="1.jpg" alt="" />';
                                echo '<div class="caption">';
                                      echo '<h3><a  href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['C_Name'] . '</a></h3>';
                                      echo '<p>' . $item['Description']. '</p>';
                                      echo '<div class="date">' . $item['Add_Date'] . '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                  }else{
                    echo 'Sorry There\'s No Ads To Show, Create <a href="newad.php">New Ad</a>';
                  }
                ?>

              </div>
            </div>
        </div>
    </div>

    <div class="information_comment block">
        <div class="container">
            <div class="panel panel-primary">
              <div class="panel-heading">Latest Comments</div>
              <div class="panel-body">
<?php
// SELECT All Users Except Admin
$stmt = $con->prepare("SELECT comment FROM comments WHERE user_id = ?");


                    $stmt->execute(array($info['UserID'])); // Execute The Statment
                    $comments = $stmt->fetchAll(); // Asign To Variable

                    if(! empty($comments)){

                      foreach ($comments as $comment) {

                        echo '<p>' . $comment['comment'] . '</p>';
                      }

                    }else {
                      echo 'There\'s No Comments to show';
                    }
                ?>
              </div>
            </div>
        </div>
    </div>
<?php
}else {

    header('Location: login.php');

    exit();
}

    include $tpl . "footer.php";
?>
