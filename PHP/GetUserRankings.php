<?php
/**
 * Created by PhpStorm.
 * User: Jeiman
 * Date: 17-Mar-16
 * Time: 7:26 PM
 */
require 'DbConn.php';
$conn = $newconn->connect();

try {
  if ($conn == null) {
    $_SESSION['error_log'][] = 'dbConnFailed';
    header ("Location: ../error.php");
    } else {
    $stmtRank = $conn->prepare("SELECT (@cnt := @cnt + 1) AS rowNumber, t.userRealName, t.userPoints, t.userProfilePhoto FROM mwusers AS t CROSS JOIN (SELECT @cnt := 0) AS dummy ORDER BY userPoints desc LIMIT 15");
    $stmtRank->execute();

    $stmtTotalPoints = $conn->prepare("select sum(userPoints) as totalPoints from mwusers");
    $stmtTotalPoints->execute();
    $totalPointsFetch = $stmtTotalPoints->fetchObject();
    $TotalPoints = $totalPointsFetch->totalPoints; ?>
    
    <table>
      <thead>
        <tr>
          <td>No</td>
          <td>Name</td>
          <td>Rank</td>
          <td>Points</td>
        </tr>
      </thead>
      <tbody>
            <?php
            foreach ($stmtRank->fetchAll() as $rowRank) {

                $userTempNo = $rowRank['rowNumber'];
                $userFullNameRank = $rowRank['userRealName'];
                $userPoints = $rowRank['userPoints'];
                $userProfilePhotoRank = $rowRank['userProfilePhoto'];
                $congrats = '';
                require 'RankSystem.php';

                if ($userPoints > 200 ) {
                    $congrats = $userPoints.'<img style="right:-3px;" class="rank-img" src="assets/img/rank4.svg">';
                } else {
                    $congrats = $userPoints;
                }
                ?>
                <tr>
                    <td><?php echo $userTempNo;?></td> <?php // Asset Check is being invoked in getNav.php so dont get scared. ?>
                    <td><img class="rank-img" src="<?php echo $userProfilePhotoRank; ?>"><?php echo $userFullNameRank;?></td>
                    <td><?php echo $rank;?></td>
                    <td><?php echo $congrats;?></td>
                </tr>

            <?php } ?>

            </tbody>
            <tfoot>
            <tr>
                <td colspan="3">Total Points</td>
                <td><?php echo $TotalPoints;?></td>
            </tr>
            </tfoot>
        </table>


    <?php }

} catch (PDOException $e) {
    echo '<p class="db">'.'An error occurred talking to the DB. Error log below: '.'</p>' .'<br>'. $e->getMessage();
} finally {
    $connDisc = $newconn->disconnect();
}
?>
