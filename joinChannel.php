<?php
    include("connection.php");
    session_start();
    $search = $_SESSION["search"];

    $id = $_GET['channel'];
    $username = $_SESSION['Username'];
    if($username == " "){
        $checkPrivacy = "SELECT * FROM channels WHERE ID = '$id'";
        $checkChannel = "SELECT * FROM $id WHERE Users='$username'";
        $run = mysqli_query($connect1, $checkPrivacy);
        $run2 = mysqli_query($connect1, $checkChannel);
        if($run){
            
                while($channel = mysqli_fetch_assoc($run)){
                    $privacy = $channel["Security"];
                    $rows = mysqli_num_rows($run2);
                    echo "<script>console.log($rows)</script>";
                    if($privacy == "private" && $rows < 1){
                        echo "<script>document.getElementById('joinChannelDisplay').style.display = 'block'</script>";
                        
                        
                        $channelFile = "./$id/"."notification.txt";
                        file_put_contents($channelFile, $username);
                        header("Location: search.php?search=$search");
                            
                            
                        
                        
                    }else{
                        $channelFile = "./$id/"."notification.txt";
                        file_put_contents($channelFile, $username);
                        header("Location: search.php?search=$search");
                    }
                }
        }
        
    }else{
        echo "<script>alert('You need to sign in to join a channel')
            window.location.href = 'search.php?search=$search';
        
        </script>";
        
    }
    
    

    
    




?>