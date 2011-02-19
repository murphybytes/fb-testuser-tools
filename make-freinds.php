<?php
require_once('config.php');
require_once( 'sdk/src/facebook.php');

$facebook = new Facebook( array( 'appId' => $app_id, 
                                 'secret' => $secret,
                                 'cookie' => true ) );
$session = $facebook->getSession();

$url = 'https://graph.facebook.com/oauth/access_token';
$params=array(
                         "type" => "client_cred",
                         "client_id" => $app_id,
                         "client_secret" => $secret);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, null, '&') );
$data = curl_exec($ch);
curl_close($ch);
    
$access_token = str_replace('access_token=', '', $data);


$url = "https://graph.facebook.com/$app_id/accounts/test-users?access_token=$access_token";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);
 
$request = json_decode($data,true);
$list1 = $request['data'];
$list2 = $request['data'];



foreach ($list1 as $key1 => $value1) {
  foreach($list2 as $key2 => $value2 ) {
    $id1 = $list1[$key1]['id'];
    $id2 = $list2[$key2]['id'];
    if( $id1 != $id2 ) {
    }

  }
} 
  //echo '<br>Test user ID: '.$request[$key]['id'].'<br>';
  //  echo 'Log in as this test user: ' . $request[$key]['login_url'] . '<br>';
  echo "<div style='clear:both;height:15px;'>";
  echo "<div style='float:left;width:30%;'>Test User: " . $data[$key]['id'] . "</div>";
  echo "<div style='float:left;'><a href='" . $data[$key]['login_url'] . "'>Log In</a></div>";
  echo "<div style='float:left;margin-left:10px;'><a href='/fb/delete.php?id=" . $data[$key]['id'] . "'>Delete</a></div>";
  echo "</div>";

  }
?>

<div style='margin-top:15px;'>
<a href='/fb/make-freinds.php'>Make Test Users Friends</a>
</div>