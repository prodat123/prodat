<?php
    include ('connection.php');
    SESSION_START();
    $id = rand(1, 10000000000);

    
    $querycheck2 = "SELECT * FROM people WHERE Username = $username";
    
    if($result = mysqli_query($connect1, $querycheck2)){
        $cek2 = mysqli_num_rows($result);
    }
    // $run = mysqli_query($connect1,$querycheck);
    
    $querycheck1 = "SELECT * FROM people WHERE ID = $id";
    if($result = mysqli_query($connect1, $querycheck1)){
        $cek = mysqli_num_rows($result);
        while($cek>0){
            echo "It already exist in database";
            $id = rand(1, 10000000000);
        }
    }
    $occ = $_POST['Occupation'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $email = $_POST['Email'];

    $query = "INSERT INTO people (ID, Occupation, Username, Password, Email) VALUES ('$id', '$occ', '$username', '$password', '$email')";
    $running = mysqli_query($connect1, $query);
    
    
    if($running){
        
        $_SESSION['Username'] = "$username";
        $_SESSION['Channel'] = "$channel";
        echo "Success";
        header("Location: HomePage.php");
    }
    else{
        echo "Error";
    }

    
   
            
        

    
  ?>   