<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <meta name="viewport" content="width=device-width, intital-scale=1.0">
    <?xml version="1.0" encoding="iso-8859-1"?>
    <link rel="stylesheet" href="styles/News.css"></link>
    
</head>
<body>
    
    <div class="topnav" id="myTopnav">
    
        <a href="HomePage.php" style="color: #ff9f1c"><b>Prodat</b></a>
        <?php   
            ob_start();
            session_start();
            include("connection.php");
            $currentChannel = $_GET["channel"];
            
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
                            $currentLink = $_SERVER["REQUEST_URL"];
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
        <a>
            <form method="POST" name="AddNews" action="" class="AddNewsMobile">
                <input class="addNewsMobile" type="submit" name="addNewsMobile" value="+"></input>
            </form>
        </a>
        <a href="ChannelList.php"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="28" height="28" viewBox="0 0 24 24" style=" fill:#ffffff;"><path d="M 4 4 C 2.9057453 4 2 4.9057453 2 6 L 2 18 C 2 19.094255 2.9057453 20 4 20 L 20 20 C 21.094255 20 22 19.094255 22 18 L 22 8 C 22 6.9057453 21.094255 6 20 6 L 12 6 L 10 4 L 4 4 z M 4 6 L 9.171875 6 L 11.171875 8 L 20 8 L 20 18 L 4 18 L 4 6 z"></path></svg></a>
    </div>
    <div class="imgContainer">
        <img id="imgEnlarge" src="">
        <button onclick="closeimg()">x</button>
    </div>
    <div class="bodyContainer">
        <div class="newsPanel">
            <a class="selected" href="News.php?channel=<?php echo $currentChannel;?>">Stream</a>
            <a href="people.php?channel=<?php echo $currentChannel;?>">People</a>
            <a href="notifications.php?channel=<?php echo $currentChannel;?>">Notifications</a>
        </div>
        
        <div class="profileBox" id="profileBox">
            <ul>
                <li><button id="makeChannelButton" onclick="document.getElementById('id04').style.display='block'">Make Channel</button></li>
                <li><a href="logOut.php" class="signOutButton" style="color: red">Sign Out</a></li>
            </ul>
        </div>     
        
        <form action="" id="categoryPicker" name="Categories" method="POST">
            <label>Display: </label>
            <select name="CategorySorting" onchange = "chooseCategory()" id="categorySort">
                <option value="important" id="important">important</option>
                <option value="random" id="random">random</option>
                <option value="all" id="all">all</option>
                
            </select>
            <label>Order by: </label>
            <select name="OrderSorting" onchange= "chooseCategory()">
                <option value="recent">recent</option>
            </select>
        </form>
        <form method="POST" action="" class="AddNewsDesktop">
            <input class="addNews" type="submit" name="addNewsDesktop" value="+"></input>
        </form>
        
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

        <div id="id04" class="modal">

            <form class="modal-content animate" method="POST">
                <div class="container">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
                        <label style="text-align: center;"><h2>CHANNEL</h2></label>
                    </div>

                
                    <label><b>Channel Name</b></label>
                    <input type="text" placeholder="Channel name..." name="ChannelName"></input>
                    <label><b>Categories</b>(split the categories using ',')</label>
                    <input type="text" placeholder="Categories..." name="Categories"></input>
                    <label><b>Private</b></label>
                    <input type="radio" value="private" name="ChannelSecurity"></input>
                    <label><b>Public</b></label>
                    <input type="radio" value="public" name="ChannelSecurity"></input>
                    <br>
                    <div class="clearfix">
                        <button type="button" class="cancelbtn" onclick="document.getElementById('id04').style.display='none';">Cancel</button>
                        <button type="submit" name="makeChannel" class="makeChannelBtn">Publish</button>
                    </div>
                    
                </div>
                <!-- <div class="container" style="background-color:#f1f1f1">
                    <button type="button" onclick="document.getElementById('id04').style.display='none'" class="cancelbtn">Cancel</button>
                </div> -->
            </form>
        </div>
        <div id="joinChannelDisplay" class="modal" style="display: none; z-index: 3;">

            <form class="modal-content animate" method="POST">

                <div class="container">
                

                
                    <h1><b>Join Channel</b></h1>
                    
                    
                    <br><br><br>
                    <div class="clearfix">
                        <button type="submit" name ="button" class="cancelbtn" value="cancel" >Cancel</button>
                        <button type="submit" name="button" class="makeChannelBtn" value="join" onclick="window.location.href='joinChannel.php?channel=<?php echo $currentChannel ?> '">Join</button>
                    </div>
                    
                </div>
            </form>
        </div>
        <?php
            
            $_SESSION["Category"] = "";
            $category = $_SESSION["Category"];
            if(isset($_GET["channel"])){
                $currentChannel = $_GET["channel"];
                $_SESSION["Channel"] = $currentChannel;   
            }
            
            $currentUsername = $_SESSION["Username"];

            

            if(isset($_POST['CategorySorting'])){
                $categorySelected = $_POST['CategorySorting'];
                if ($categorySelected == "all"){
                    $category = "";
                    $_SESSION["Category"] = "";
                    $sql = "SELECT * FROM news WHERE Channel = '$currentChannel'";
                }else{
                    $_SESSION["Category"] = $categorySelected;
                    $category = $_SESSION["Category"];
                    $sql = "SELECT * FROM news WHERE Category = '$category' AND Channel = '$currentChannel'";
                }
                
            }
            else{
                $sql = "SELECT * FROM news WHERE Channel = '$currentChannel'";
            }
            
            if(isset($_POST['OrderSorting'])){
                $orderSelected = $_POST["OrderSorting"];
                if($orderSelected == "recent"){
                    if($category != ""){
                        $sql = "SELECT * FROM news WHERE Channel = '$currentChannel' AND Category='$category' ORDER BY TimePublished DESC";
                    }else{
                        $sql = "SELECT * FROM news WHERE Channel = '$currentChannel' ORDER BY TimePublished DESC";
                    }
                }
                
            }else{
                if($category != ""){
                    $sql = "SELECT * FROM news WHERE Channel = '$currentChannel' AND Category='$category' ORDER BY DatePublished DESC";
                }else{
                    $sql = "SELECT * FROM news WHERE Channel = '$currentChannel' ORDER BY DatePublished DESC";
                }
            }
            $result = mysqli_query($connect1, $sql);
            while($a= mysqli_fetch_assoc($result)){
                $author=$a["Author"];
                $publishedDate = $a["DatePublished"];
                $title=$a["Title"];
                $content=$a["Content"];
                $externalMedia = $a["ExternalMedia"];
                $medias = explode(",", $externalMedia);
                
                echo "<style>.'$currentChannel/' {display: none}</style>";

                
                echo "<div class='newsContainer'>";
                echo "<div class='newsButton'>";
                echo "<div class='publisherName'> " .$author."</div>";
                echo "<div class='newsDate'> " . $publishedDate."</div><br>";
                $count = count($medias);       
                echo "<div class='NewsHeading'>" . $title."</div>";
                echo "<div class='newsBody'>" . $content."</div>";
                for ($j=0; $j < count($medias) - 1 ; $j++) {  
                    echo "<input class='imgButton' type='image' style='width: 100px; height: 100px; padding: 18px 0px; padding-right: 10px;' src='$currentChannel/$medias[$j]' id='$currentChannel/$medias[$j]'>";
                }
                        
                echo "</div>";
                echo "</div>";
                
            }

            if(isset($_POST['addNewsDesktop']) || isset($_POST['addNewsMobile'])){
                echo "<script>console.log($currentUsername)</script>";
                if(EMPTY($_SESSION["Username"])){
                    echo "<script>alert('You need to sign in to post')</script>";
                }else{
                    $checkUser = "SELECT * FROM $currentChannel WHERE Users = '$currentUsername'";
                
                    if($user = mysqli_query($connect1, $checkUser)){
                        $cek = mysqli_num_rows($user);
                        if($cek > 0){
                            header("Location: MakeNewNews.php?channel=$currentChannel");
                            
                        }else{
                            //echo "<script>document.getElementById('joinChannelDisplay').style.display = 'block';</script>";
                        }
                        
                    }
                }
                
            }

            if(isset($_POST['searchChannel'])){
                
                $searchInput = $_POST['ChannelInput'];
                header("Location: search.php?search=$searchInput");
                
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="static/Javascript/NewsJs.js"></script>
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
        $(".channelBtn").click(function(evt){ 
            var channelBtnID = this.id || "No ID!";
            window.location.href = "News.php?channel=" + channelBtnID;
        })

        const signInButton = document.querySelector("#SignInButton");
        if (signInButton !== null){
            signInButton.addEventListener("click", () => {
                document.getElementById('id03').style.display="block";
                
            })
        }
    </script>
</body>
</html>