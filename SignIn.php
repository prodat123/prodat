<?php
    include ('connection.php');
    SESSION_START();

    $username = $_POST['Username'];
    $password = $_POST['Password'];

    $querycheck = "SELECT Password From people WHERE Username = '$username'";
    $result = mysqli_query($connect1, $querycheck);
    if(mysqli_num_rows($result) > 0){
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
        echo '<script type="text/javascript" src="homePageJavascript.js">
                console.log("This is currently working!")
                WrongUsername()

        
            </script>';
        header("Location: HomePage.php");
        
        echo "This username does not exist";
    }
    // $run = mysqli_query($connect1,$querycheck);
    
    
    // if($running){
        
    //     $_SESSION['Username'] = "$username";
    //     $_SESSION['Channel'] = "$channel";
    //     echo "Success";
    //     header("Location: HomePage.php");
    // }
    // else{
    //     echo "Error";
    // }

    
   
            
        

    
  ?>   