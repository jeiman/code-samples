<?php
    session_start();
    session_unset();
    session_destroy();

    if ( isset($_COOKIE['rme_u']) && isset($_COOKIE['c_user']) ) {
      unset($_COOKIE['rme_u']);
      unset($_COOKIE['c_user']);
      setcookie('rme_u', null, -1, '/');
      setcookie('c_user', null, -1, '/');
      header("Location: ../");
      exit;
    } else {
      header("Location: ../");
      exit;
    }
?>
