<?php

$addArticleURL = stripos( $_SERVER['SCRIPT_NAME'], 'add-article/index.php' );
$settingsURL = stripos( $_SERVER['SCRIPT_NAME'], 'account/settings.php' );

if ( $addArticleURL || $settingsURL ) {
  $jsonFile = file_get_contents("../src/data/translations.json");
} else {
  $jsonFile = file_get_contents("src/data/translations.json");
}
$jsonObj = json_decode($jsonFile, true);

$loginTitle = $jsonObj['formData']['loginTitle'];
$loginSubheading = $jsonObj['formData']['loginSubheading'];
$signupTitle = $jsonObj['formData']['signupTitle'];
$signupSubheading = $jsonObj['formData']['signupSubheading'];
$addArticleTitle = $jsonObj['formData']['addArticleTitle'];
$addArticleSubheading = $jsonObj['formData']['addArticleSubheading'];
$settingsTitle = $jsonObj['formData']['settingsTitle'];
$settingsSubheading = $jsonObj['formData']['settingsSubheading'];

$accept = $jsonObj['ctaButton']['accept'];
$submit = $jsonObj['ctaButton']['submit'];
$update = $jsonObj['ctaButton']['update'];
$login = $jsonObj['ctaButton']['login'];
$signup = $jsonObj['ctaButton']['signup'];
$addArticle = $jsonObj['ctaButton']['addArticle'];
$editProfile = $jsonObj['ctaButton']['editProfile'];
$viewProfile = $jsonObj['ctaButton']['viewProfile'];