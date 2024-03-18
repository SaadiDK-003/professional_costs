  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index.php" class="nav-link"><?= $Home_ ?? 'Home' ?></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#!" class="nav-link"><?= $Contact_ ?? 'Contact' ?></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <!-- <div id="google_translate_element"></div> -->
        <form id="lang-changer-form" method="post" action="">
          <select name="lang_changer" id="lang-changer">
            <option value="" selected hidden>Select Language</option>
            <option <?= ($lang == 'en_US') ? 'selected' : '' ?> value="en_US">English</option>
            <option <?= ($lang == 'ar_AR') ? 'selected' : '' ?> value="ar_AR">Arabic</option>
          </select>
        </form>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->