<?php
require 'includes/init.php';

if(isset($_SESSION['user_id']) && isset($_SESSION['email'])){
    $user_data = $user_obj->find_user_by_id($_SESSION['user_id']);
    if($user_data ===  false){
        header('Location: logout.php');
        exit;
    }
}
else{
    header('Location: logout.php');
    exit;
}
// TOTAL REQUESTS
$get_req_num = $frnd_obj->request_notification($_SESSION['user_id'], false);
// TOTAL FRIENDS
$get_frnd_num = $frnd_obj->get_all_friends($_SESSION['user_id'], false);
$get_all_req_sender = $frnd_obj->request_notification($_SESSION['user_id'], true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo  $user_data->username;?></title>
    <link rel="stylesheet" href="./stylefordraw.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<body style="background-color: white;">
    <div class="profile_container">
        
        <div class="inner_profile">
            <div class="img">
                <img src="profile_images/<?php echo $user_data->user_image; ?>" alt="Profile image">
            </div>
            <h1><?php echo  $user_data->username;?></h1>
        </div>
        <nav>
            <ul>
                <li><a href="profile.php" rel="noopener noreferrer">Home</a></li>
                <li><a href="notifications.php" rel="noopener noreferrer">Requests<span class="badge <?php
                if($get_req_num > 0){
                    echo 'redBadge';
                }
                ?>"><?php echo $get_req_num;?></span></a></li>
                <li><a href="friends.php" rel="noopener noreferrer">Friends<span class="badge"><?php echo $get_frnd_num;?></span></a></li>
                <li><a href="draw.php" rel="noopener noreferrer" class="active">Draw</a></li>
                <li><a href="logout.php" rel="noopener noreferrer">Logout</a></li>  
            </ul>
        </nav>
        <div class="draw">
            <h3>Draw</h3>
            <p>Input the brush's size</p>
            <input type="text" id="note_text" />

<canvas id = "cnv" width="1000" height="600">
<script type = "text/javascript">

    var md = false;
    var canvas = document.getElementById('cnv');

    canvas.addEventListener('mousedown', down);
    canvas.addEventListener('mouseup', toggledraw);
    canvas.addEventListener('mousemove',

    function(evt){
        var mousePos = getMousePos(canvas, evt);
        var posx = mousePos.x;
        var posy = mousePos.y;
        draw(canvas, posx, posy);
    });

    function down(){
        md = true;

    }
    function toggledraw(){
        md = false;
        canvas.style.cursor = "default";    
    }
    function getMousePos(canvas, evt){
        var rect = canvas.getBoundingClientRect();
        return{
            x:evt.clientX - rect.left,
            y:evt.clientY - rect.top     
        };
    }
    function draw(canvas, posx, posy){
        var context = canvas.getContext('2d');
        if(md){
            canvas.style.cursor = "pointer";
            context.fillStyle= document.getElementById("colorPicker").value;
            context.fillRect(posx, posy, document.getElementById("note_text").value, document.getElementById("note_text").value);
        }
    }
            window.onload=function(){
                var el = document.getElementById("button1");
                el.addEventListener("click", setColor);
            }
                function setColor() {
                alert(document.getElementById("colorPicker").value);
            }

</script>
</canvas>
<input type="color" name="colorPicker" id="colorPicker">
<button onclick = "window.location.reload()">reset</button>
<button onclick="download_image()">
        Download
    </button>   
<script>

        function download_image(){
            var canvas = document.getElementById("cnv");
            image = canvas.toDataURL("image/png").replace("image/png", "image/octet-stream");
            var link = document.createElement('a');
            link.download = "my-image.png";
            link.href = image;
            link.click();
        }
</script>

</body>
</html>