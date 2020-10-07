<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>

    <!-- here idea for css cashing  -->
    <!-- https://css-tricks.com/can-we-prevent-css-caching/ -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=base_url()?>css/boot4/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>image-preview-uploader/image-uploader.css">
    <link rel="stylesheet" href="<?=base_url()?>fontawesome/css/all.css">
    <link rel="stylesheet" href="<?=base_url()?>phone-list-code/css/intlTelInput.css">
    <link rel="stylesheet" href="<?=base_url()?>css/main-style.css?<?php echo date('l jS \of F Y h:i:s A'); ?>">

    <script src="<?=base_url()?>js/boot4/jquery.min.js" charset="utf-8"></script>
    <script src="<?=base_url()?>js/boot4/bootstrap.js" charset="utf-8"></script>
    <script type="text/javascript" src="<?=base_url()?>image-preview-uploader/image-uploader.js"></script>
    <title>الصفحة الرئيسية</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row d-none d-md-block d-lg-block">
        <header>
          <div class="col-md-2">
            <div class="logo">
              <img class="logo" src="<?=base_url()?>img/logo.jpg" alt="logo" width="120">
            </div>
          </div>
          <div class="col-md-7">
            <nav>
              <ul class="nav_links">
                <li><a href="<?=base_url()?>">الرئيسية</a></li>
                <li><a href="<?=base_url()?>">العقارات</a></li>
                <li><a href="<?=base_url()?>">عن الموقع</a></li>
              </ul>
            </nav>
          </div>
          <div class="col-md-3">
            <?php
              if($this->session->userdata('logged_in')){
            ?>
            <a href="<?=base_url()?>client" class="btn btn-success" title="ملفك الشخصي"><i class="fas fa-user "></i></a>
            <?php } ?>

            <a href="<?=base_url()?>client/add_entity" title="أضف عقارك" class="btn btn-primary"  >اضف عقار</a>
            <?php
              if(!$this->session->userdata('logged_in')){
            ?>
            <a href="<?=base_url()?>auth/register" class="btn btn-warning">تسجيل</a>
            <a href="<?=base_url()?>auth/login" class="btn btn-success">دخول</a>
          <?php }else{ ?>
            <a href="<?=base_url()?>auth/logout" title="سجل خروجك من الموقع" class="btn btn-danger"><i class="fas fa-power-off"></i></a>
          <?php } ?>

          </div>
        </header>
      </div>


      <div class="row d-none  d-block d-sm-block d-md-none d-lg-none d-xl-none">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <a class="navbar-brand" href="<?=base_url()?>">Aqar4D</a>

          <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <?php
                if($this->session->userdata('logged_in')){
              ?>
              <li class="nav-item active">
                <a href="<?=base_url()?>client" class="btn btn-outline-warning my-2 my-sm-0 btn-block">صفحتك الشخصية</a>
                <!-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> -->
              </li>
              <li class="nav-item active">
                <a href="<?=base_url()?>client/add_entity" class="btn btn-outline-primary my-2 my-sm-0 btn-block">اضف عقار</a>
                <!-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> -->
              </li>
              <li class="nav-item active">
                <a href="<?=base_url()?>auth/logout" class="btn btn-danger my-2 my-sm-0 btn-block">خروج</a>
                <!-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> -->
              </li>
            <?php }else{ ?>
              <li class="nav-item">
                <a href="<?=base_url()?>auth/register" class="btn btn-warning my-2 my-sm-0 btn-block">تسجيل</a>
                <!-- <a class="nav-link" href="#">Link</a> -->
              </li>
              <li class="nav-item">
                <a href="<?=base_url()?>auth/login" class="btn btn-success my-2 my-sm-0 btn-block">دخول</a>
                <!-- <a class="nav-link disabled" href="#">Disabled</a> -->
              </li>
            <?php } ?>
            </ul>
            <!-- <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form> -->
          </div>
        </nav>
      </div>
