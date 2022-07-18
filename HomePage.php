<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/HomePageCss.css" >
    <meta name="viewport" content="width=device-width, intital-scale=1.0">
    <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
    
    <link rel="stylesheet" href="https://cdnjs.cloudfare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Prodat</title>

</head>

<?php
        include ('connection.php');
        SESSION_START();
        $usernameError = "";
        $currentUsername = $_SESSION["Username"];
        $_SESSION["CurrentChannel"] = "";
        $channelList = "";
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

        
        function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

        if(isset($_POST['makeChannel'])){
            
            $id = generateRandomString();
            $name = $_POST['ChannelName'];
            $security = $_POST['ChannelSecurity'];
            $categories = $_POST['Categories'];
            $checkName = "SELECT * FROM channels WHERE Channel_Name = '$name'";
            if($result = mysqli_query($connect1, $checkName)){
                $lines = mysqli_num_rows($result);
                if($lines > 0){
                    echo "<script>window.alert('this channel is not available');</script>";

                    exit();
                }
                else{
                    $properCategories = strtolower(str_replace(" ", "", $categories));
                    $insertChannel = "INSERT INTO channels (ID, Channel_name, Security, Categories) VALUES ('$id', '$name', '$security', '$properCategories')";
                    $currentJoinedChannels = "SELECT Channels_Joined FROM people WHERE Username='$currentUsername'";
                    $checkChannels = mysqli_query($connect1, $currentJoinedChannels);
                    while($channel = mysqli_fetch_assoc($checkChannels)){
                        $channelList .= $channel["Channels_Joined"].","."$name";
                    }
                    
                    $joinChannel = "UPDATE people SET Channels_Joined='$channelList' WHERE Username='$currentUsername'";
                    if($result = mysqli_query($connect1, $insertChannel)){
                        $query = "CREATE TABLE $id (
                            Users VARCHAR(200) NOT NULL,
                            Type TEXT(15) NOT NULL,
                            PRIMARY KEY(Users)
                            )";
                           
                        if (mysqli_query($connect1, $query)) {
                            $insertUser = "INSERT INTO $id (Users, Type) VALUES ('$currentUsername', 'admin')";
                            mkdir("$id");
                            fopen("./$id/"."notification.txt", "w");
                            mysqli_query($connect1, $joinChannel);
                            if(mysqli_query($connect1, $insertUser)){
                                mysqli_close($connect1);
                                header("Location: HomePage.php");
                            }
                            
                        } else {
                            echo "Error creating table: " . mysqli_error($connect1);
                        }
                            
                            
                        
                    }
                }
            }
           
        }


        
        
        
        
    
        
?>

<body>
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
    <div class="centerContent">
        <!-- <h1 id="title">Prodat</h1> -->
        

        <div class="profileBox" id="profileBox">
            <ul>
                <li><a href="ChangeProfilePicture.php">Change Profile Picture</a></li>
                <li><button id="makeChannelButton" onclick="document.getElementById('id04').style.display='block'">Make Channel</button></li>
                <li><a href="logOut.php" class="signOutButton" style="color: red">Sign Out</a></li>
            </ul>
        </div>
        
        
        
        <?php
            
            if(isset($_POST['searchChannel'])){
                
                $searchInput = $_POST['ChannelInput'];
                header("Location: search.php?search=$searchInput");
                
            }
        
        ?>
        
        
    </div>
   

    
    <!-- <div id="id01" class="modal">

      <form class="modal-content animate" action="SignUpPage" method="POST">

          <div class="imgcontainer">
              <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
              <label><h2>SIGN UP</h2></label>
              
          </div>

            <div class="container">
                <label for="ID"><b>ID</b></label>
                <input type="text" placeholder="Enter ID" name="ID" required>
                <br><br>
                <label for="name"><b>Name</b></label>
                <input type="text" placeholder="Name" name="name" required>
                <br><br>
                <input type="radio" name="occupation" value="student"required>
                <label for="student"><b>Student</b></label>
                <input type="radio" name="occupation" value="teacher" required>
                <label for="teacher"><b>Teacher</b></label><br><br>
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>
                <br><br>
                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <button type="submit">Sign Up</button>
                <label>
                    <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
            </div>

        <div class="container" style="background-color:#f1f1f1">
          <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
        </div>
      </form>
    </div>

    <div id="id02" class="modal">

      <form class="modal-content animate" action="JoinChannel" method="POST">

          <div class="imgcontainer">
              <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
              <label><h2>CHANNEL</h2></label>
          </div>

            <div class="container">
                <label for="Channel"><b>Channel</b></label>
                <input type="text" placeholder="Enter Channel Code" name="Channel" required>

                <button type="submit">Join</button>
                <h4 id="CheckChannel"></h4>

            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
            </div>
      </form>
    </div> -->

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
                    <label><h2>CHANNEL</h2></label>
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
    


    <!-- <button onclick="document.getElementById('id02').style.display='block'" style="width:auto; float: right;">Join Channel</button>
    <button onclick="document.getElementById('id03').style.display='block'" style="width:auto; float: right; right: 100px;" id="SignInButton">Sign In</button>
    
    <a class="channelCode" href="{{url_for('PeopleList')}}"><b>{{roomName}}</b></a> -->
    


    <!-- <a href="#" class="notification">
        <span>Inbox</span>
        <span class="badge">3</span>
    </a> -->
    

        

    </div>  
        


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(".search").on("keyup", function(e){
            if(e.key === 'Enter' || e.keyCode === 13){
                alert("This is working!")

            }
        });
        
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

        const signInButton = document.querySelector("#SignInButton");
        if (signInButton !== null){
            signInButton.addEventListener("click", () => {
                document.getElementById('id03').style.display="block";
                
            })
        }
    
        $(".channelBtn").click(function(evt){ 
            var channelBtnID = this.id || "No ID!";
            window.location.href = "News.php?channel=" + channelBtnID;
        })
            
        function myFunction(){
            var x = document.getElementById("myTopnav");
            if(x.className === "topnav"){
                x.className += "responsive";
            }else{
                x.className = "topnav";
            }
        }
        
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
        

    </script>




</body>
</html>