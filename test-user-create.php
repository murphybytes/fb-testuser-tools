<div style='margin-bottom:10px;'>
<a href='/fb/list-test-users.php'>Test User List</a>
</div>
<?

require_once( './config.php');
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

$attachment = array('access_token' => $access_token);
 
$request = $facebook->api("/$app_id/accounts/test-users?installed=false&permissions=", 'POST', $attachment);
$new_id = $request['id'];
?>
<div> 
Test user ID: <?  echo($request['id']); ?>
</div>
<div>
<a href='<? echo( $request['login_url'] ); ?>'>Log in as test user</a>
</div>


