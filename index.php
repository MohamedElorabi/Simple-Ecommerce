<?php

    session_start();

    $pageTitle = 'Homepage';

    include 'init.php';
?>

    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
          </ol>

          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox">
            <div class="item active">
              <img src="image/2.jpg" alt="...">
              <div class="carousel-caption">

              </div>
            </div>
            <div class="item">
              <img src="image/3.png" alt="...">
              <div class="carousel-caption">

              </div>
            </div>

            <div class="item">
              <img src="image/4.jpg" alt="...">
              <div class="carousel-caption">

              </div>
            </div>

            <div class="item">
              <img src="image/5.jpg" alt="...">
              <div class="carousel-caption">

              </div>
            </div>

          </div>

          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>


<!-- Start Get All Item -->
    <div class="container">
      <div class="row">

        <?php
        $allItems = getAllFrom('*', 'items', 'where Approve = 1', '', 'Item_ID');
        foreach ($allItems as $item) {
            echo '<div class="col-sm-6 col-md-3">';
                echo '<div class="thumbnail item-box">';
                    echo '<span class="price-tag">' . $item['Price'] . '</span>';
                    echo '<img class"img-responsive" style="height:380px;" src="admin/uploads/items/'. $item['items_image'].'" alt="" />';
                    echo '<div class="caption">';
                          echo '<h3><a  href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h3>';
                          echo '<p>' . $item['Description']. '</p>';
                          echo '<div class="date">' . $item['Add_Date'] . '</div>';
                          echo '<button class="primary-btn"><a href="">Buy Now</a></button>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
    }
    ?>

      </div>
    </div>
    <!-- End Get All Item -->

    <!-- NEWSLETTER -->
    <div id="newsletter" class="section">
    	<!-- container -->
    	<div class="container">
    		<!-- row -->
    		<div class="row">
    			<div class="col-md-12">
    				<div class="newsletter">
    					<p>Sign Up for the <strong>NEWSLETTER</strong></p>
    					<form>
    						<input class="input" type="email" placeholder="Enter Your Email">
    						<button class="newsletter-btn"><i class="fa fa-envelope"></i> Subscribe</button>
    					</form>
    					<ul class="newsletter-follow">
    						<li>
    							<a href="#"><i class="fa fa-facebook"></i></a>
    						</li>
    						<li>
    							<a href="#"><i class="fa fa-twitter"></i></a>
    						</li>
    						<li>
    							<a href="#"><i class="fa fa-instagram"></i></a>
    						</li>
    						<li>
    							<a href="#"><i class="fa fa-pinterest"></i></a>
    						</li>
    					</ul>
    				</div>
    			</div>
    		</div>
    		<!-- /row -->
    	</div>
    	<!-- /container -->
    </div>
    <!-- /NEWSLETTER -->
<?php
    include $tpl . "footer.php";
?>
