<?php require_once('Session.php');
require('Cookies.php');
require '../Controller/DbConn.php';
$conn = $newconn->connect();

if (isset($_POST['form-submit'])) {
  if (isset($_POST['userEmail']) && isset($_POST['userPassword'])) {
    $userEmail = htmlentities($_POST['userEmail']);
    $userName = $_POST['userEmail'];
    $userPass = htmlentities($_POST['userPassword']);
  }
}

try {
  if ($conn == null) {
    $_SESSION['error_log'][] = 'dbConnFailed';
    header ("Location: ../error.php");
  } else {
    $stmt = $conn->prepare("SELECT * FROM mwusers WHERE (userEmail = :userEmail OR userName = :userName) LIMIT 1");
    // $stmt->bindParam(':userEmail', $userEmail);
    $stmt->execute(array(':userEmail' => $userEmail,
    ':userName' => $userName));
    // $result = $st->fetchObject();
    // $stmt->execute();
    $row = $stmt->fetchObject();

    if ($row != null) {
      $userpassword_db = $row->userPassword;

      if (isset($userpassword_db)) { // Checks to see if userpassword exists in db or if its null
        $singamcheckpass = password_verify($userPass, $userpassword_db);

        if ($singamcheckpass === true) { // Checks to see if password typed is valid or not. Extra  naming to avoid hacker intrusion
          // Set session variables
          $userid_db = $row->userID;
          $username_db = $row->userName;
          $userrealname_db = $row->userRealName;
          $useremail_db = $row->userEmail;
          $userProfilePhoto_db = $row->userProfilePhoto;

          $_SESSION['userID'] = $userid_db;
          $_SESSION['userEmail'] = $useremail_db;
          $_SESSION['userRealName'] = $userrealname_db;
          $_SESSION['userName'] = $username_db;
          $_SESSION['userProfilePhoto'] = $userProfilePhoto_db;

          // $date = date("Y-m-d h:i:s");
          date_default_timezone_set('Asia/Kuala_Lumpur');
          $date = date('Y-m-d h:i:s', time());

          $currentUserAgent = $_SERVER['HTTP_USER_AGENT'];

          $stmt2 = $conn->prepare("UPDATE mwusers SET currentUserAgent = :currentUserAgent, lastLoginDate = :lastLoginDate WHERE userID =:userid");
          $stmt2->execute(array(':currentUserAgent' => $currentUserAgent,
                    ':lastLoginDate' => $date,
                    ':userid' => $userid_db));
          $countrow = $stmt2->rowCount();

          if ( isset($_POST['rememberMe']) ) { // Create a cookie token
            $length = 30;
            $token = bin2hex(random_bytes($length));
            setCookieOnLogin($username_db, $userid_db, $token);

            $updateUserToken = "UPDATE mwusers SET userToken='$token' WHERE userID=$userid_db";
            $stmt3 = $conn->prepare($updateUserToken);
            $stmt3->execute();
          }
          header("Location: ../");
          exit;
        } else {
          $_SESSION['error_log'][] = 'invaliduserPass';
        }
      } else {
        $_SESSION['error_log'][] = 'passDontExist';
      }
    } else {
      $_SESSION['error_log'][] = 'userDontExist';
    }
    header ("Location: ../error.php");
    exit;
  }
} catch (PDOException $e) {
  echo '<p class="db">'.'An error occurred talking to the DB. Error log below: '.'</p>' .'<br>'. $e->getMessage();
} finally {
  $connDisc = $newconn->disconnect();
}
?>
