<?php
require_once('config.php');
require_once( 'sdk/src/facebook.php');

$facebook = new Facebook( array( 'appId' => $app_id, 
                                 'secret' => $secret,
                                 'cookie' => true ) );
$session = $facebook->getSession();

$user_id = $_GET['id'];
$user_access_token = $_GET['access_token'];

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
$data = $request['data'];

$ch = curl_init();
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);


foreach ($data as $key => $value) {
  if( array_key_exists( 'access_token', $data[$key] ) ) {
    if( $user_id != $data[$key]['id'] ) {
      $url = "https://graph.facebook.com/$user_id/friends/" . $data[$key]['id'];
      echo "<div>" . $url . "</div>";
    
      $params = array( "access_token" => $user_access_token );
      curl_setopt($ch, CURLOPT_URL, $url );
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params, null, '&'));
      $result = curl_exec( $ch );
      echo "<div>Friend result for " . $user_id . " =  $result</div>";
    
      $url = "https://graph.facebook.com/" . $data[$key]['id'] . "/friends/$user_id";
      echo "<div>" . $url . "</div>";
    
      $params = array( "access_token" => $data[$key]['access_token'] );
      curl_setopt($ch, CURLOPT_URL, $url );
      curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $params, null, '&' ));
      $result = curl_exec($ch);
      echo "<div>Friend result for " . $data[$key]['id'] . " = $result</div>";
    }
    
  }
}
curl_close($ch);

?>
<div>
<a href='/fb/list-test-users.php'>List Test Users</a>
</div>
<div>
<a href='/fb/index.php'>Home</a>
</div>