<head>
    <link rel="stylesheet" href="styles/SearchCss.css"></link>
    <meta name="viewport" content="width=device-width, intital-scale=1.0">
</head>

<body>
    <div id="joinChannelDisplay" class="modal" style="display: none;">

        <form class="modal-content animate" method="POST">

            <div class="container">
            

            
                <h1><b>Join Channel</b></h1>
                
                
                <br><br><br>
                <div class="clearfix">
                    <button type="submit" name ="button" class="cancelbtn" value="cancel" >Cancel</button>
                    <button type="submit" name="button" class="makeChannelBtn" value="join">Join</button>
                </div>
                
            </div>
        </form>
    </div>
</body>


<?php
    include("connection.php");
    session_start();
    ob_start();

    $search = $_SESSION["search"];
    $id = $_GET['channel'];
    $username = $_SESSION['Username'];
    $checkPrivacy = "SELECT * FROM channels WHERE ID = '$id'";
    $checkChannel = "SELECT * FROM $id WHERE Users='$username'";
    $run = mysqli_query($connect1, $checkPrivacy);
    $run2 = mysqli_query($connect1, $checkChannel);
    
        
        
    if($run){
        while($channel = mysqli_fetch_assoc($run)){
            $privacy = $channel["Security"];
            $rows = mysqli_num_rows($run2);
            if($privacy == "private" && $rows < 1){
                if(EMPTY($username)){
                    echo "<script>alert('You need to sign in to join a channel')
                        window.location.href = 'search.php?search=$search';
                    
                    </script>";
                }else{
                    echo "<script>document.getElementById('joinChannelDisplay').style.display = 'block'</script>";
                
                    if(isset($_POST["button"])){
                        
                        if($_POST["button"] == "join"){
                            $channelFile = "./$id/"."notification.txt";
                            $text = $username."\n";
                            file_put_contents($channelFile, $text);
                            header("Location: search.php?search=$search");
                        }else{
                            if($_POST["button"] == "cancel"){
                                header("Location: search.php?search=$search");
                            }
                            
                        }
                        
                    }   
                }
                
                
            }else{
                header("Location: News.php?channel=$id");
            }
        }
    }
    


    
    
    
    
    


?>

