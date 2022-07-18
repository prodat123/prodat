<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles/News.css"></link>
        <meta name="viewport" content="width=device-width, intital-scale=1.0">
    </head>
    <body>
        <?php
            SESSION_START();
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
                
                $currentChannel = $_GET["channel"];
                
                
            
                if(isset($_POST['searchChannel'])){
                
                    $searchInput = $_POST['ChannelInput'];
                    header("Location: search.php?search=$searchInput");
                    
                }

                
            ?>

        </div>
        <div class="bodyContainer">
            
            <div class="newsPanel">
                <a href="News.php?channel=<?php echo $currentChannel;?>">Stream</a>
                <a class="selected" href="people.php?channel=<?php echo $currentChannel;?>">People</a>
                <a href="notifications.php?channel=<?php echo $currentChannel;?>">Notifications</a>
            </div>
            <h1>People</h1>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Occupation</th>
                </tr>
                <?php
                    include("connection.php");
                    $query = "SELECT * FROM $currentChannel";
                    $peopleList = mysqli_query($connect1, $query);
                    if($peopleList){
                        while($people = mysqli_fetch_assoc($peopleList)){
                            $person = $people['Users'];
                            $type = $people['Type'];
                            echo "<tr><td>$person</td><td>$type</td></tr>";
                            
                        }
                    }
                    
                
                ?>
            </table>
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
        <div href="javascript:void(0)" class="bottomNav">
            <a href="HomePage.php"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="28" height="28" viewBox="0 0 24 24" style=" fill:#ffffff;">    <path d="M 12 2.0996094 L 1 12 L 4 12 L 4 21 L 10 21 L 10 14 L 14 14 L 14 21 L 20 21 L 20 12 L 23 12 L 12 2.0996094 z"></path></svg></a>
            <a href="ChannelList.php"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="28" height="28" viewBox="0 0 24 24" style=" fill:#ffffff;"><path d="M 4 4 C 2.9057453 4 2 4.9057453 2 6 L 2 18 C 2 19.094255 2.9057453 20 4 20 L 20 20 C 21.094255 20 22 19.094255 22 18 L 22 8 C 22 6.9057453 21.094255 6 20 6 L 12 6 L 10 4 L 4 4 z M 4 6 L 9.171875 6 L 11.171875 8 L 20 8 L 20 18 L 4 18 L 4 6 z"></path></svg></a>
        </div>
    </body>
</html>