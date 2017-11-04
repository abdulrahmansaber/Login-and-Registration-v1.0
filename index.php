<?php
  require __DIR__ . '/autoload.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>script-v.1.0</title>

  <!-- Required CSS Files -->
  <link rel='stylesheet' href='layout/css/font-awesome.min.css'>
  <link rel='stylesheet' href='layout/css/resets.css'>
  <link rel='stylesheet' href='layout/css/main.css'>

  <!-- Themes CSS Files
       Default CSS Theme File -> themes/css-theme/default.scss -->
  <?php
    $theme->theme = '02-theme';
    $theme->require_theme_files('design');
  ?>
</head>
<body>

  <?php

    // Start Our Work Here !

    if (isset($_COOKIE['myaccountremembered'])) {
      $re = new Redirect();
      $re->redirect_header('profile?id=' . $_COOKIE['myaccountremembered'], 5);
      Messages::success('Checking...... ');
    }

    # is request method = post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $account  = safe($_POST['account']);
      $password = safe($_POST['password']);
      $sha1pass = sha1($password);
      $errors   = array();

      $validate = new Validation();
      if ($validate->is_empty($account)) {
        $errors[] = 'Username or Email Field is Required';
      }
      if ($validate->is_empty($password)) {
        $errors[] = 'Please write your Account Password!';
      }
      $msgs = new Messages();
      foreach ($errors as $error) {
        $msgs->error($error);
      }

      if (empty($errors)) {
        $find = new Find();
        $rowCountUsername = $find->find_rec_row('users', 'username', $account);
        $rowCountPassword = $find->find_rec_row('users', 'password', sha1($password));
        $rowCountEmail    = $find->find_rec_row('users', 'email', $account);
        $query = new Query();
        if ($rowCountUsername > 0 || $rowCountEmail > 0 && $rowCountPassword > 0) {
          $account_data = $query->query_fetch("SELECT * FROM users WHERE username = '$account' OR email = '$account' AND password = '$sha1pass'");
          $redirect = new Redirect();
          if (isset($_POST['rm-sts'])) {
            setcookie('myaccountremembered', $account_data['userid'], time() + 500000);
            if (isset($_COOKIE['myaccountremembered'])) {
              $redirect->redirect_header('profile?id=' . $account_data['userid'], 5);
            }
          } else {
            $_SESSION['userid'] = $account_data['userid'];
          }
        } else {
          $msgs->error('Can\'t find your data!');
        }
      }

    }

  ?>

  <!-- Login Form -->
  <section class='login-form'>
    <div class='header'>
      <h1>Login Form</h1>
    </div>
    <form method='post'>
      <label>Username or Email</label>
      <input type='text' placeholder='Username or Email Address' name='account'>

      <label>Password</label>
      <input type='password' placeholder='Enter your password' name='password' autocomplete='new-password'>

      <label class='flexed' for='remme' unselectable='on'>
        <input type='checkbox' id='remme' name='rm-sts'> Remember me for next time ?
      </label>

      <button class='btn btn-success'>Signin</button>
    </form>
  </section>


  <!-- Required JavaScript Files -->
  <script src='layout/js/jquery.js'></script>
  <script src='layout/js/main.js'></script>

  <!-- Themes JS Files
       Default JS File -> themes/js-theme/default.js -->
  <?php
    $theme->theme = 'default';
    $theme->require_theme_files('javascript');
  ?>
</body>
</html>
