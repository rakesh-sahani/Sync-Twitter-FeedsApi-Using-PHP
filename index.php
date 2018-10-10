<?php
require_once 'vendor/autoload.php';

//Twitter Feeds
error_reporting(E_ALL);
ini_set('display_errors', '1');
$settings = array(
    'oauth_access_token' => "721770962480275456-oc8XyvNoojBZ2UcdTgLskDVbZgpYr98",
    'oauth_access_token_secret' => "Czd0Vrdr8O73vBR1hYSlTpwLxANWkyHYBtgDFyMMsFhU0",
    'consumer_key' => "rWKyqcuzN8vFnUm19B4x18bCL",
    'consumer_secret' => "zUOnnhToTeyMHgDowYtjM6RLw3OHEB1uL5adrzMRZrIpXenCD2"
);


$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=realDonaldTrump&count=10';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);


$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

$data =  json_decode($response);
$tName;
 foreach ($data as $nameData) :

     $tName = $nameData->user->screen_name;
    endforeach;
//print_r($data);

//Mysql Connection
$servername = "sql12.freemysqlhosting.net";
$username = "sql12260574";
$password = "WHHqFXziJa";
$dbname = "sql12260574";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
foreach ($data as $tableData) :
    $tName = $tableData->user->screen_name;
    $pImg = $tableData->user->profile_image_url;
    $screenName = $tableData->user->screen_name;
    $uName = $tableData->user->name;
    $tText =  $tableData->text;


    $sql = "INSERT INTO feed ( user_screen_name, user_name,profile_image_url,text)
VALUES ('$screenName', '$uName', '$pImg','$tText')";

    if ($conn->query($sql) === TRUE) {
        $Output = "Record Inserted";
        echo("<script>console.log('PHP: ".$Output."');</script>");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

endforeach;
$conn->close();
?>




<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TwitterHighOnM</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Quicksand:300,400' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
    <link href="https://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.css" rel="stylesheet">

</head>
<body>

		<span class="first">
			  @<?php echo $tName; ?> 	<span class="icon-refresh new" onclick="window.location.reload()" ></span>
		</span>
        <ul class="timeline">
            <?php foreach ($data as $htmlData) : ?>
            <li>
                <div class="avatar">
                    <img src="<?php echo $htmlData->user->profile_image_url; ?>">
                    <div class="hover">
                        <div class="icon-twitter"></div>
                    </div>
                </div>
                <div class="bubble-container">
                    <div class="bubble">
                        <h3>@<?php echo $htmlData->user->screen_name; ?></h3>
                        <h4><?php echo $htmlData->user->name; ?></h4>
                        <?php echo $htmlData->text; ?>

                    </div>
                    <div class="arrow"></div>
                </div>
            </li>

            <?php endforeach; ?>

        </ul>

        </div>
</body>
</html>
