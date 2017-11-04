<?php
  $title = 'Create Account';
  require __DIR__ . '/autoload.php';
?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <title><?php title(); ?></title>

  <!-- Required CSS Files -->
  <link rel='stylesheet' href='layout/css/font-awesome.min.css'>
  <link rel='stylesheet' href='layout/css/resets.css'>
  <link rel='stylesheet' href='layout/css/main.css'>

  <!-- Themes CSS Files
       Default CSS Theme File -> themes/css-theme/default.scss -->
  <?php
    $theme->theme = 'default';
    $theme->require_theme_files('design');
  ?>
</head>
<body>

  <?php

    $fields = array(
      'username' => array(
        'name_php'    => 'username',
        'placeholder' => 'Enter Your Username',
        'max-length'  => 50,
        'min-length'  => 6,
        'html-type'   => 'text',
        'required'    => true,
        'db_rec_name' => 'username'
      ),
      'password' => array(
        'name_php'    => 'password',
        'placeholder' => 'Enter Your Password',
        'max-length'  => 60,
        'min-length'  => 8,
        'html-type'   => 'password',
        'required'    => true,
        'db_rec_name' => 'password'
      ),
      'email' => array(
        'name_php'    => 'email',
        'placeholder' => 'Enter Your Email Address',
        'max-length'  => 80,
        'min-length'  => 5,
        'html-type'   => 'email',
        'required'    => true,
        'db_rec_name' => 'email'
      ),
      'phone' => array(
        'name_php'    => 'phone',
        'placeholder' => 'Enter Phone Number',
        'max-length'  => 20,
        'min-length'  => 5,
        'html-type'   => 'text',
        'required'    => true,
        'db_rec_name' => 'phone'
      ),
      'location' => array(
        'name_php'    => 'location',
        'placeholder' => 'Enter Your City',
        'max-length'  => 40,
        'min-length'  => 4,
        'html-type'   => 'text',
        'required'    => true,
        'db_rec_name' => 'location'
      )
    );

    // User Submitted
    if ($request->request(default_request)) {

      // Fields with safe output
      $acc_username = safe($_POST[$fields['username']['name_php']]);
      $acc_password = safe($_POST[$fields['password']['name_php']]);
      $hashed_password = sha1($acc_password);
      $acc_phone    = safe($_POST[$fields['phone']['name_php']]);
      $acc_location = safe($_POST[$fields['location']['name_php']]);
      $acc_email    = safe($_POST[$fields['email']['name_php']]);

      // Errors array. Errors store here
      $errors = [];

      // Validation Class visit it at [import/validation/check.php] xD
      $validate = new Validation();

      // Validate Fields (Empty, Max Length, Min Length, ..)
      foreach ($fields as $field => $attr_vals) {

        // if Fields empty
        if ($validate->is_empty(@$_POST[$field])) {
          $errors[] = '<strong>' . ucfirst($attr_vals['name_php']) . '</strong>' . ' Cannot be empty';
        }

        // Validate Max Length of fields
        if ($validate->maxlen(@$_POST[$field], $attr_vals['max-length'])) {
          $errors[] = '<strong>' . ucfirst($attr_vals['name_php']) . '</strong>' . ' Must be less than ' . '<strong>' . $attr_vals['max-length'] . '</strong>';
        }

        // Validate Min Length of fields
        if ($validate->minlen(@$_POST[$field], $attr_vals['min-length'])) {
          $errors[] = '<strong>' . ucfirst($attr_vals['name_php']) . '</strong>' . ' Must be More than ' . '<strong>' . $attr_vals['min-length'] . '</strong>';
        }
      }

      // Display Errors
      foreach ($errors as $error) {
        messages::error($error);
      }

      // If There's No Any Error
      if (empty($errors)) {
        $find = new Find();

        $find_user = $find->find_rec_row('users', 'username', $acc_username);
        if ($find_user > 0) {
          Messages::error('Username exists please choose anethor one');
        } else {
          $recorders = new Query();
          $query = "INSERT INTO `users`(username, password, email, phone, location)
          VALUES ('$acc_username', '$hashed_password', '$acc_email', '$acc_phone', '$acc_location')";
          $results = $recorders->query_rowcount($query);
          if ($results > 0) {
            $data = $find->find_rec('users', 'username', $acc_username);
            messages::success('Your Account Has Been Created Successfully!');
            messages::success('Saving data, Redirecting.....');
            $redirect->redirect_header('profile?id=' . $data['userid'], 3);
          }
        }
      }

    }

  ?>

  <!-- Registertion Form - Look a like Login Form so div 'd be have same class -->

  <section class='login-form'>
    <div class='header'>
      <h1>Registertion</h1>
    </div>
    <form method='post'>
      <?php foreach ($fields as $key => $value) { ?>
        <input
          type="<?php echo $value['html-type']; ?>"
          placeholder="<?php echo $value['placeholder'] ?>"
          name="<?php echo $key; ?>"
          maxlength="<?php echo $value['max-length']; ?>"
          minlength="<?php echo $value['min-length'] ?>"
          <?php if ($value['required'] == true) { echo "required"; } ?>>
      <?php } ?>
      <label class='flexed' style='margin: 10px 0 10px 8px;'>
        <a href="#" style='margin-right: 25px;'><i class='fa fa-sign-in'></i> I Already have an account ?</a>
        <a href="#"><i class='fa fa-sign-in'></i> Forgot Password ?</a>
      </label>
      <button class='btn btn-success'>Create new Account</button>
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
