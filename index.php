$urx0="https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=AIzaSyDluKZPdsuwxICZvjKi43I7KLLgAHGtovU";

$datax0='{
  "email": "'.$randomemail.'",
  "password": "123456qwerty",
  "returnSecureToken": true
}';



$headers0[]="content-type: application/json";
$headers0[]='X-Forwarded-For: '.$ip.'';

	$ch1 = curl_init();
	curl_setopt($ch1, CURLOPT_URL,$urx0);curl_setopt($ch1, CURLOPT_HEADER,0);
	curl_setopt($ch1, CURLOPT_POST,0);
	curl_setopt($ch1, CURLOPT_POSTFIELDS,$datax0);
	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch1, CURLOPT_HTTPHEADER,$headers0);
	curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
 echo $one80=curl_exec($ch1);
$json80=json_decode($one80,true);


$tok=$json80["idToken"];
$uid=$json80["localId"];
