<?php	
include "conn.php";
$Value=$_GET['Value'];
$Value1=$_GET['Value1'];
$WhichField=$_GET['WhichField'];
//echo "Value--".$Value."<br>";
//echo "WhichField--".$WhichField."<br>";
function getClient()
{
	$client = new Google_Client();
	$client->setApplicationName('Google Drive API PHP Quickstart');
	$client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);
	$client->setAuthConfig('client_secret.json');
	$client->setAccessType('offline');
	$client->setRedirectUri('http://kts.kaivalyatech.com/arindra-test/google-api-php-client-2.2.1/oauth2callback.php');
	
	// Load previously authorized credentials from a file.
	$credentialsPath = expandHomeDirectory('credentials.json');
	if (file_exists($credentialsPath)) {
		$accessToken = json_decode(file_get_contents($credentialsPath), true);
	} else {
		// Request authorization from the user.
		$authUrl = $client->createAuthUrl();
		printf("Open the following link in your browser:\n%s\n", $authUrl);
		print 'Enter verification code: ';
		$authCode = trim(fgets(STDIN));

		// Exchange authorization code for an access token.
		$accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

		// Store the credentials to disk.
		if (!file_exists(dirname($credentialsPath))) {
			mkdir(dirname($credentialsPath), 0700, true);
		}
		file_put_contents($credentialsPath, json_encode($accessToken));
		printf("Credentials saved to %s\n", $credentialsPath);
	}
	$client->setAccessToken($accessToken);

	// Refresh the token if it's expired.
	if ($client->isAccessTokenExpired()) {
		$client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
		file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
	}
	return $client;
}

function expandHomeDirectory($path)
{
	$homeDirectory = getenv('HOME');
	if (empty($homeDirectory)) {
		$homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
	}
	return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
if (!class_exists('Google_Client')) {
  require_once __DIR__ . '/vendor/autoload.php';
}

$client = getClient();
$service = new Google_Service_Drive($client);
$pageToken = null;

if($WhichField=="author"){
	$keyword="a";
}else if($WhichField=="subject"){
	$keyword="s";
}else if($WhichField=="title"){
	$keyword="t";
}else if($WhichField=="institution"){
	$keyword="i";
}else if($WhichField=="rangefilter"){
	$keyword="d";
}

do {
	if($Value!=""){
		/*if($Value1!=""){
			$response = $service->files->listFiles(array(
				'q' => "'0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents and properties has { key='".$keyword."' and value>='".(int) $Value."'}",
				//'q' => "'0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents and properties has { key='".$keyword."' and value between '".$Value."' and '".$Value1."'}",
				//'q' => "'0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents and properties has { key='".$keyword."' and value between 100 and 12000}",
				'spaces' => 'drive',
				'pageToken' => $pageToken,
				'fields' => 'nextPageToken, files(id, name)',
			));
		}else*/ 
		if($keyword){
			$response = $service->files->listFiles(array(
				'q' => "'0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents and properties has { key='".$keyword."' and value='".$Value."'}",
				'spaces' => 'drive',
				'pageToken' => $pageToken,
				'fields' => 'nextPageToken, files(id, name)',
			));
		}else{
			$response = $service->files->listFiles(array(
				'q' => "'0B7JhzNLs-FQEeUdMYTdoSDhhbjA' in parents and (fullText contains '".$Value."' or name contains '".$Value."')",
				'spaces' => 'drive',
				'pageToken' => $pageToken,
				'fields' => 'nextPageToken, files(id, name)',
			));
		}
		$FileStr="";
		foreach ($response->files as $file) {
		    if ($FileStr!="")
				$FileStr.=",";
			$FileStr.="'".$file->id."'";	
		}
		//echo "file string=".$FileStr;
		$sql="SELECT id,dc_title, dc_contributor_author, google_drive_id FROM books WHERE `google_drive_id` IN (".$FileStr.")";
		$result = mysqli_query($conn,$sql);
		$Noofrows = mysqli_num_rows($result);
		if(sizeof($response->files)!=0){
			while ($row = $result->fetch_array()){	
				//print_r($row);
				//echo "<br><br>";
				$a="https://drive.google.com/thumbnail?id=".$row['google_drive_id'];
				$b=fopen($a, 'r');
				//echo "b=".$b;
				$ImageClass="";
				if ($b) {
					$ImagePath="https://drive.google.com/thumbnail?id=".$row['google_drive_id'];
				} else {
					$ImagePath="img/pdf.png";
					$ImageClass="PdfImage";
				}
				//echo "image=".$ImagePath;
				//echo "<br><br>";
				if($row['dc_contributor_author']){
					$Author="by ".ucwords($row['dc_contributor_author']);
				}
				
				echo '<div class="wholediv"><div class="bookdiv"><img src="'.$ImagePath.'" class="'.$ImageClass.'" onclick='.'"onclick=OpenFile(\''. $row['google_drive_id'].'\');"'.' /><div class="text"><img src="img/pdf.png">&nbsp;&nbsp;'.$row['id'].'-'.$row['dc_title'].'</div></div><div class="textdiv">'.$row['dc_title'].'<br>'.$Author.'</div></div>';
			}
		}
		$StringValue='"'.$Value.'"';
		echo "<script>$('#searchresult').css('height','auto');$('.searchterm').html('Searching inside 551,427 books (31TB of data)');</script>";
		/*if($Noofrows==0){
			echo "<script>$('#searchresult').css('height','567px');$('.searchterm').html('Your search ".$StringValue." matches 0 documents.');</script>";
			echo "<div class='emptydiv'>No Data Found</div>";		
		}else if($Noofrows<6){
			echo "<script>$('#searchresult').css('height','567px');$('.searchterm').html('Your search ".$StringValue." matches ".$Noofrows." documents.');</script>";
		}else{
			echo "<script>$('#searchresult').css('height','auto');$('.searchterm').html('Your search ".$StringValue." matches ".$Noofrows." documents.');</script>";
		}*/
		
		$pageToken = $repsonse->pageToken;
	}else{
		echo "<script>$('#searchresult').css('height','567px');</script>";
	}
} while ($pageToken != null); 
?>
