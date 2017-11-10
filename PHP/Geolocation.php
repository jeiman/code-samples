<?php

function getGeoLocation ($ipAddress = NULL, $purpose = 'location') {
  $output = NULL;

  if ($ipAddress) {
    $jsonFile = file_get_contents("http://www.geoplugin.net/json.gp?ip=$ipAddress");
    $ipDetails = json_decode($jsonFile, true);

    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    // echo "IP Address: $ipAddress<br><br>";

    switch ($purpose) {
      case 'location':
        $output = array(
          "city"           => $ipDetails['geoplugin_city'],
          "state"          => $ipDetails['geoplugin_regionName'],
          "country"        => $ipDetails['geoplugin_countryName'],
          "country_code"   => $ipDetails['geoplugin_countryCode'],
          "continent"      => $continents[strtoupper( $ipDetails['geoplugin_continentCode'] )],
          "continent_code" => $ipDetails['geoplugin_continentCode']
          // "gp_credit"      => $ipDetails['geoplugin_credit']
        );
        $output = implode("<br>", $output);
        break;

      case 'country':
        if ($ipAddress === '127.0.0.1') {
          $output = 'Localhost Testing';
        } else {
          $output = $ipDetails['geoplugin_countryName'];
        }
        break;

      case 'city':
        $output = $ipDetails['geoplugin_city'];
        break;

      case 'state':
        $output = $ipDetails['geoplugin_regionName'];
        break;

      case 'countrycode':
        $output = $ipDetails['geoplugin_countryCode'];
        break;
    } 
  }
  return $output;
}
?>