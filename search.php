<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles/SearchCss.css"></link>
        <meta name="viewport" content="width=device-width, intital-scale=1.0">
    </head>

    <body>
        <script>
            function disableJoinButton(buttonID){
                var button = document.querySelector("#"+buttonID);
                button.disabled = true;
            }



        </script>
        <?php
        include("connection.php");
        session_start();

        if (EMPTY($_SESSION['Username'])){
            echo 
            "<input type='button' class='signInButton' id='SignInButton' value='sign in'></input>";
            // dont forget to put other session 
        }
        else{
            $currentUsername = $_SESSION["Username"];
            echo "<button id='profile' class='profileButton'>".$currentUsername[0]."</button>";
        }
        if(isset($_POST['signIn'])){
            $username = $_POST['Username'];
            $password = $_POST['Password'];

            $querycheck = "SELECT Password From people WHERE Username = '$username'";
            $result = mysqli_query($connect1, $querycheck);
            if(mysqli_num_rows($result) > 0){
                $usernameError = "";
                while($row = mysqli_fetch_assoc($result)){
                    if ($row["Password"] == $password){
                        $querycheck = "SELECT Channel From people WHERE Username = '$username'";
                        $result = mysqli_query($connect1, $querycheck);
                        $row = mysqli_fetch_assoc($result);
                        $_SESSION['Username'] = $username;
                        $_SESSION['Channel'] = $row["Channel"];
                        header("Location: HomePage.php");
                    }
                }
                
            }
            else{
                //send a warning
                $usernameError = "There is an error in the username";
                echo "<script>
                    document.querySelector('#id03').style.display = 'block';
                </script>";
                
                
            }
        }
        ?>
        <div class="topnav" id="myTopnav">
            <a href="HomePage.php" style="color:#ff9f1c;"><b>Prodat</b></a>

            <form method="post" action="">
                <input class="search" type="text" name="ChannelInput" placeholder="channel...">
                    
                    <button name="searchChannel" id="searchButton">
                        <svg fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="30px" height="30px"><path d="M 13 3 C 7.4889971 3 3 7.4889971 3 13 C 3 18.511003 7.4889971 23 13 23 C 15.396508 23 17.597385 22.148986 19.322266 20.736328 L 25.292969 26.707031 A 1.0001 1.0001 0 1 0 26.707031 25.292969 L 20.736328 19.322266 C 22.148986 17.597385 23 15.396508 23 13 C 23 7.4889971 18.511003 3 13 3 z M 13 5 C 17.430123 5 21 8.5698774 21 13 C 21 17.430123 17.430123 21 13 21 C 8.5698774 21 5 17.430123 5 13 C 5 8.5698774 8.5698774 5 13 5 z"/></svg>
                    </button>
                </input>
                
                
            </form>
        </div>
        <div href="javascript:void(0)" class="bottomNav">
            <a href="HomePage.php"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="28" height="28" viewBox="0 0 24 24" style=" fill:#ffffff;">    <path d="M 12 2.0996094 L 1 12 L 4 12 L 4 21 L 10 21 L 10 14 L 14 14 L 14 21 L 20 21 L 20 12 L 23 12 L 12 2.0996094 z"></path></svg></a>
            <a href="ChannelList.php"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="28" height="28" viewBox="0 0 24 24" style=" fill:#ffffff;"><path d="M 4 4 C 2.9057453 4 2 4.9057453 2 6 L 2 18 C 2 19.094255 2.9057453 20 4 20 L 20 20 C 21.094255 20 22 19.094255 22 18 L 22 8 C 22 6.9057453 21.094255 6 20 6 L 12 6 L 10 4 L 4 4 z M 4 6 L 9.171875 6 L 11.171875 8 L 20 8 L 20 18 L 4 18 L 4 6 z"></path></svg></a>
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
        <div class="profileBox" id="profileBox">
            <a href="logOut.php" class="signOutButton">Sign Out</a>
        </div>
        <div class="searchResultContainer">
        <?php
            

            $j = 0;
            $search = strtolower($_GET['search']);
            $_SESSION["search"] = $search;
            $splitSearch = explode(" ", $search);
            $getAllCategories = "SELECT * FROM channels";
            $getAllNames = "SELECT Channel_Name FROM channels";
            $getCategories = mysqli_query($connect1, $getAllCategories);
            $names = array();
            
            $numOfChannels = mysqli_num_rows($getCategories);
            
            while($j < $numOfChannels){
                $searchResults = mysqli_fetch_assoc($getCategories);
                $name = $searchResults['Channel_Name'];
                $categories = $searchResults['Categories'];
                $splitCategories = explode(",", $categories);
                
            
                
                
                for ($i=0; $i < count($splitSearch); $i++) { 
                    if(in_array($name, $names) !== true){
                        if(in_array($splitSearch[$i], $splitCategories)){
                            
                            $querycheck1 = "SELECT * FROM channels WHERE Categories = '$categories'";
                        
                            if($result = mysqli_query($connect1, $querycheck1)){
                                
                                while($searchResults = mysqli_fetch_assoc($result)){
                                    
                                    $channelID = $searchResults["ID"];
                                    $channelName = $searchResults["Channel_Name"];
                                    $security = $searchResults["Security"];
                                    $numberOfMembers = $searchResults["Number_Of_Members"];
                                    $channelName = $searchResults['Channel_Name'];
                                    $checkIfJoining = "SELECT * FROM $channelID WHERE Users = '$currentUsername'";
                                    $joiningQuery = mysqli_query($connect1, $checkIfJoining);
                                    $checkJoin = mysqli_num_rows($joiningQuery);
                                    if($checkJoin > 0){
                                        $join = "joined";
                                        echo "<div class='SearchResultButton' id='$channelID'>".
                                            
                                                "<h1 class='publisherName'> " .$channelName."</h1>".
                                                "<h3 class='newsDate'> " . $security."</h3>".
                                                "<h4>Number of members: ".$numberOfMembers."</h4>".
                                                "<button name='joinButton' class='joinBtn' value='$channelID' id='join$channelID'>$join</button>".
                                                
                                            "</div>";
                                        echo "<script>disableJoinButton('join$channelID')</script>";
                                    }else{
                                        $join = "join";
                                        echo "<div class='SearchResultButton' id='$channelID'>".
                                            
                                                "<h1 class='publisherName'> " .$channelName."</h1>".
                                                "<h3 class='newsDate'> " . $security."</h3>".
                                                "<h4>Number of members: ".$numberOfMembers."</h4>".
                                                "<button name='joinButton' class='joinBtn' value='$channelID' id='join$channelID'>$join</button>".
                                                
                                            "</div>";
                                    }    
                                    
                                            
                                    $names[] = $searchResults['Channel_Name'];
                                    
                                }
                                
                        
                            }
                        }else{
                            if(in_array($splitSearch[$i], $names) !== true){
                                $querycheck2 = "SELECT * FROM channels WHERE Channel_Name = '$splitSearch[$i]'";
                            
                                if($result = mysqli_query($connect1, $querycheck2)){
                                    
                                    while($searchResults = mysqli_fetch_assoc($result)){
                                        $channelID = $searchResults["ID"];
                                        $channelName = $searchResults["Channel_Name"];
                                        $security = $searchResults["Security"];
                                        $numberOfMembers = $searchResults["Number_Of_Members"];
                                        $channelName = $searchResults['Channel_Name'];
                                        $checkIfJoining = "SELECT * FROM $channelID WHERE Users = '$currentUsername'";
                                        $joiningQuery = mysqli_query($connect1, $checkIfJoining);
                                        $checkJoin = mysqli_num_rows($joiningQuery);
                                        if($checkJoin > 0){
                                            $join = "joined";
                                            echo "<div class='SearchResultButton' id='$channelID'>".
                                                
                                                    "<h1 class='publisherName'> " .$channelName."</h1>".
                                                    "<h3 class='newsDate'> " . $security."</h3>".
                                                    "<h4>Number of members: ".$numberOfMembers."</h4>".
                                                    "<button name='joinButton' class='joinBtn' value='$channelID' id='join$channelID'>$join</button>".
                                                "</div>";
                                            echo "<script>disableJoinButton('join$channelID')</script>";
                                        }else{
                                            $join = "join";
                                            echo "<div class='SearchResultButton' id='$channelID'>".
                                                
                                                    "<h1 class='publisherName'> " .$channelName."</h1>".
                                                    "<h3 class='newsDate'> " . $security."</h3>".
                                                    "<h4>Number of members: ".$numberOfMembers."</h4>".
                                                    "<button name='joinButton' class='joinBtn' value='$channelID' id='join$channelID'>$join</button>".
                                                "</div>";
                                        }
                                        
                                                
                                        $names[] = $searchResults['Channel_Name'];
                                        
                                    }
                                    
                            
                                }
                            }
                        }
                        
                    }
                        
                }

                
                $j++;
            }
            
            
        
                
        ?>    
        </div>    
                
               
                
        <div class="profileBox" id="profileBox">
            <ul>
                <li><button id="makeChannelButton" onclick="document.getElementById('id04').style.display='block'">Make Channel</button></li>
                <li><a href="logOut.php" class="signOutButton" style="color: red">Sign Out</a></li>
            </ul>
        </div>     
            
            
            

        <?php
            if(isset($_POST['searchChannel'])){
                
                $searchInput = $_POST['ChannelInput'];
                $_SESSION["channel"] = $searchInput;
                header("Location: search.php?search=$searchInput");
                
            }

        ?>
        
        <div id="id03" class="modal">

            <form class="modal-content animate" method="POST">

                <div class="container">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id03').style.display='none'" class="close" title="Close Modal">&times;</span>
                        <label><h2>Sign In</h2></label>
                    </div>

                
                    <label><b>Username</b></label>
                    <input type="text" placeholder="Channel name..." name="Username"></input>
                    <label><b>Password</b></label>
                    <input type="password" placeholder="Categories..." name="Password"></input>
                    
                    <br>
                    <div class="clearfix">
                        <button type="button" class="cancelbtn" onclick="document.getElementById('id03').style.display='none';">Cancel</button>
                        <button type="submit" name="signIn" class="makeChannelBtn">Sign In</button>
                    </div>
                    
                </div>
            </form>
        </div>
        
        
       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            var profileBox = $(".profileBox");
            var profileButton = $(".profileButton");
            $(document).ready(function() {
                $(document).click(function() {
                    if($(".profileBox").is(":visible")){
                    
                        profileBox.hide();
                        
                    }
                })
                

                profileButton.click(function(e) {
                    if($(".profileBox").is(":visible")){
                        
                        profileBox.hide();
                        
                    }else{
                        
                        profileBox.show();
                        
                    }
                    e.preventDefault();
                    e.stopPropagation();
                })   
            })    
            $(".SearchResultButton").click(function(evt){ 
                
                var channelBtnID = this.id || "No ID!";
                window.location.href = "verifySecurity.php?channel="+channelBtnID;
                

                // window.location.href = "News.php?channel=" + channelBtnID;
                
                
            })

            $(".channelBtn").click(function(evt){ 
                var channelBtnID = this.id || "No ID!";
                window.location.href = "News.php?channel=" + channelBtnID;
            })

            $(".joinBtn").click(function(evt){ 
                evt.stopPropagation();
                var channelBtnID = this.id || "No ID!";
                window.location.href = "joinChannel.php?channel="+channelBtnID;
                

                // window.location.href = "News.php?channel=" + channelBtnID;
                
                
            })


            function toggleChannels(){
                const channels = document.querySelectorAll(".channelBtn");
                for (let i = 0; i < channels.length; i++) {
                    if(channels[i].style.display === "none"){
                        channels[i].style.display = "block";
                    }else{
                        channels[i].style.display = "none";
                    }
                }
            }

            const signInButton = document.querySelector("#SignInButton");
            if (signInButton !== null){
                signInButton.addEventListener("click", () => {
                    document.getElementById('id03').style.display="block";
                    
                })
            }

            
            
        </script>
    </body>
</html>

