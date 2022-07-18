<!DOCTYPE HTML>
<html>

    <head>
        <link rel="stylesheet" href="styles/News.css"></link>
        <meta name="viewport" content="width=device-width, intital-scale=1.0">
    </head>

    <body>
        
        <?php
            SESSION_START();
            include("connection.php");
            $currentChannel = $_GET["channel"];
            
            
        ?>
        <div class="topnav" id="myTopnav">
            <a href="HomePage.php" style="color: #ff9f1c"><b>Prodat</b></a>

            <form method="post" action="">
                <input class="search" type="text" name="ChannelInput" placeholder="channel...">
                    
                    <button name="searchChannel" id="searchButton">
                        <svg fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="30px" height="30px"><path d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z"/></svg>
                    </button>
                </input>
                
                
            </form>

            <?php
                if (EMPTY($_SESSION['Username'])){
                    echo 
                    "<input type='button' class='signInButton' id='SignInButton' value='sign in'></input>";
                    // dont forget to put other session 
                }
                else{
                    $currentUsername = $_SESSION["Username"];
                    echo "<button id='profile' class='profileButton'>".$currentUsername[0]."</button>";
                }
            
            ?>
        </div>
        <div class="sideContainer">
        
            
            
            <ul class="list">
                <li><a href="HomePage.php" style="font-size: 18px">Home</a></li>
                <li><input type="button" value="Joined Channels" onclick="toggleChannels()" style="font-size: 18px; text-align: center;"></input></li>
                <?php
                    $currentUsername = $_SESSION["Username"];
                    $UserChannels = "SELECT Channels_Joined FROM people WHERE Username='$currentUsername'";
                    $channels = mysqli_query($connect1, $UserChannels);
                    if($channels){
                        
                        while($channel = mysqli_fetch_assoc($channels)){
                            if($channel["Channels_Joined"] != ""){
                                $joinedChannels = explode(",", $channel["Channels_Joined"]);
                            
                                for ($i=0; $i < count($joinedChannels); $i++) { 
                                    $getChannelID = "SELECT ID FROM channels WHERE Channel_Name = '$joinedChannels[$i]'";
                                    $channelIDs = mysqli_query($connect1, $getChannelID);
                                    while($channel = mysqli_fetch_assoc($channelIDs))
                                    {
                                        $channelID = $channel["ID"];
                                        echo "<li>".
                                            "<input type='button' class='channelBtn' value='$joinedChannels[$i]' id='$channelID'></input>".
                                        "</li>";
                                    }
                                    
                                }
                            }
                            
                            
                            
                            
                        }
                    
                        
                        
                        
                            
                    }
                    
                
                ?>
            </ul>
    
        </div>
        <div class="bodyContainer">
            <div class="newsPanel">
                <a href="News.php?channel=<?php echo $currentChannel;?>">Stream</a>
                <a href="people.php?channel=<?php echo $currentChannel;?>">People</a>
                <a class="selected" href="notifications.php?channel=<?php echo $currentChannel;?>">Notifications</a>
            </div>
            
            <h1 class="heading" >Notifications</h1>
            <div class="notificationDiv">
            <?php
                
                
                $notificationFile = fopen("./$currentChannel/"."notification.txt", "r");
                while($line = fgets($notificationFile)){
                    echo "<div class='singleNotificationDiv'>".$line." requested to join"."</div>";
                    echo "<form action='' method='POST'>";
                    echo "<button class='optionBtn' value='$line' type='submit' name='option'>Accept</button>";
                    echo "<button class='optionBtn' value='Reject' type='submit' name='option'>Reject</button>";
                    echo "</form>";
                }
                
                
                
                if(isset($_POST["option"])){
                    $selected = $_POST["option"];
                    if($selected != "Reject"){
                        $joinChannel = "INSERT INTO $currentChannel (Users, Type) VALUES ('$selected', 'member')";
                        mysqli_query($connect1, $joinChannel);
                        $getChannelName = "SELECT Channel_Name FROM channels WHERE ID = '$currentChannel'";
                        $getCurrentJoinedChannels = "SELECT Channels_Joined FROM people WHERE Username = '$selected'";
                        $getJoinedChannels = mysqli_query($connect1, $getCurrentJoinedChannels);
                        $joinedChannels = mysqli_fetch_assoc($getJoinedChannels);
                        $joinedChannel = $joinedChannels["Channels_Joined"];
                        $channelName = mysqli_query($connect1, $getChannelName);
                        while($name = mysqli_fetch_assoc($channelName)){
                            $nameOfChannel = $name['Channel_Name'];
                            $channelsToAdd .= "$joinedChannel".",".$nameOfChannel;
                            
                            $addJoinedChannel = "UPDATE people SET Channels_Joined = '$channelsToAdd' WHERE Username = '$selected'";
                            mysqli_query($connect1, $addJoinedChannel);
                        }

                        mysqli_close($connect1);
                    
                        $contentsUpdated = str_replace($selected, '', fgets($notificationFile));
                        file_put_contents("./$currentChannel/"."notification.txt", $contentsUpdated);
                        header("Location: notifications.php?channel=$currentChannel");
                    }else{
                        $contentsUpdated = str_replace($selected, '', fgets($notificationFile));
                        file_put_contents("./$currentChannel/"."notification.txt", $contentsUpdated);
                        header("Location: notifications.php?channel=$currentChannel");
                    }
                    
                    
                    
                
                    
                }

                if(isset($_POST['searchChannel'])){
                
                    $searchInput = $_POST['ChannelInput'];
                    header("Location: search.php?search=$searchInput");
                    
                }
            ?>
        </div>
    </body>
</html>