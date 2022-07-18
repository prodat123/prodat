<link rel="stylesheet" href="https://cdnjs.cloudfare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="styles/HomePageCss.css" >
<meta name="viewport" content="width=device-width, intital-scale=1.0">

<div href="javascript:void(0)" class="bottomNav">
    <a href="HomePage.php"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="28" height="28" viewBox="0 0 24 24" style=" fill:#ffffff;">    <path d="M 12 2.0996094 L 1 12 L 4 12 L 4 21 L 10 21 L 10 14 L 14 14 L 14 21 L 20 21 L 20 12 L 23 12 L 12 2.0996094 z"></path></svg></a>
    <a href="ChannelList.php"><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="28" height="28" viewBox="0 0 24 24" style=" fill:#ffffff;"><path d="M 4 4 C 2.9057453 4 2 4.9057453 2 6 L 2 18 C 2 19.094255 2.9057453 20 4 20 L 20 20 C 21.094255 20 22 19.094255 22 18 L 22 8 C 22 6.9057453 21.094255 6 20 6 L 12 6 L 10 4 L 4 4 z M 4 6 L 9.171875 6 L 11.171875 8 L 20 8 L 20 18 L 4 18 L 4 6 z"></path></svg></a>
</div>
<div class="channelContainer">
    <ul class="list">
        
        <li><input type="button" value="Joined Channels" onclick="toggleChannels()" style="font-size: 18px; text-align: center; color: black;"></input></li>
        <?php
            include("connection.php");
            session_start();
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
                                    "<input type='button' class='channelBtn' value='$joinedChannels[$i]' id='$channelID' style='color: black; text-align: center;'></input>".
                                "</li>";
                            }
                            
                        }
                    }
                    
                    
                    
                    
                }
            
                
                
                
                
            }
            
        
        ?>
    </ul>
    <button onclick="history.go(-1)">Back</button>
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