<?php
/**
 * User: Jeiman
 * Date: 29-Dec-16
 * Time: 9:24 AM
 *
 * Cookies settings area
 */

function setCookieOnLogin($user, $userID, $token) {
  $cookie = $user . ':' . $token;
  $mac = hash_hmac('sha256', $cookie, SECRET_KEY);
  $cookie .= ':' . $mac;
  $domain = '';
  $timetoExpire = strtotime("+1 month", time());
  setcookie('rme_u', $cookie, $timetoExpire, '/', $domain, false, true);
  setcookie('c_user', $userID, $timetoExpire, '/', $domain, false, true);
}

function validateCookie() {
  $cookie = isset( $_COOKIE['rme_u'] ) ? $_COOKIE['rme_u'] : '';
  if ( $cookie ) {
    list ($user, $token, $mac) = explode(':', $cookie);
    if (hash_equals(hash_hmac('sha256', $user . ':' . $token, SECRET_KEY), $mac)) {
      try {
        $DB_con = Database::connect();
        $stmt = $DB_con->prepare("select userID, userName, userRealName, userProfilePhoto, userToken from mwusers where userName = :userName");
        $stmt->bindParam(':userName', $user);
        $stmt->execute();
        $row = $stmt->fetchObject();

        $userID = $row->userID;
        $userName = $row->userName;
        $userRealName = $row->userRealName;
        $userToken = $row->userToken;
        $userProfilePhoto = $row->userProfilePhoto;
        
        if (!hash_equals($token, $userToken)) {
          session_unset();
          session_destroy();
          session_start();
          initSessionDefault();
          } else {
            $_SESSION['userID'] = $userID;
            $_SESSION['userRealName'] = $userRealName;
            $_SESSION['userName'] = $userName;
            $_SESSION['userProfilePhoto'] = $userProfilePhoto;
          }
        } catch (PDOException $e) {
          echo '<p class="db">'.'An error occurred talking to the DB. Error log below: '.'</p>' .'<br>'. $e->getMessage();
        } finally {
        }
      } else {
        echo 'doesnt match for shit';
      }
    }
}
?>
