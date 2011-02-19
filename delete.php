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

$user_id = $_GET['id'];
$url = "https://graph.facebook.com/$user_id?access_token=$access_token";


$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "DELETE" );
$data = curl_exec( $ch );
curl_close($ch); 
?>

<div>
Test user <? echo($user_id); ?> has been deleted.
</div>
<div style='margin-top:15px;'>
<a href='/fb/list-test-users.php'>List Test Users</a>
</div>