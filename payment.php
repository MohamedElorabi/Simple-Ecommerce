<?php

    session_start();

    $pageTitle = 'Homepage';

    include 'init.php';
?>


<!--Start Form-->

<form class="form-horizontal">
  <div class="form-group ">
    <label class="col-md-2 control-label">Full Name</label>

      <div class="col-md-6">
        <input type="text" class="form-control">
    </div>
  </div>

  <div class="form-group">
    <label class="col-md-2 control-label">Mobile</label>
    <div class="col-md-6">
        <input type="password" class="form-control" id="inputPassword3">
    </div>
  </div>

<div class="form-group">
    <label class="col-md-2 control-label">E-mail</label>

      <div class="col-md-6">
        <input type="email" class="form-control" id="inputEmail3">
    </div>
  </div>

<div class="form-group">
      <label class="col-md-2 control-label">Countery</label>

        <div class="col-md-6">
      <select class="form-control">
            <option>EGY</option>
            <option>KSA</option>
            <option>UAE</option>
      </select>
      </div>
    </div>

<div class="form-group">
    <label class="col-md-2 control-label">Address</label>

      <div class="col-md-6">
        <input type="tel" class="form-control">
    </div>
  </div>





<div class="form-group">
    <label class="col-md-2 control-label">Payment methods</label>
      <div class="col-md-6">
    <select class="form-control">
          <option>Visa</option>
          <option>Vodafone Cash</option>
          <option>Cash on Delivery</option>
    </select>
    </div>
   </div>



  <div class="form-group">
    <div class="col-sm-offset-2 col-md-6">
        <button type="submit" class="btn btn-primary">submit</button>
    </div>
  </div>
</form>






<?php
    include $tpl . "footer.php";
?>
