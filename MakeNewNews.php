<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles/MakeNews.css">
    <meta name="viewport" content="width=device-width, intital-scale=1.0">
    <meta charset="UTF-8">
    <title>Make News</title>
</head>
<body>
    <?php
        ob_start();
        include("connection.php");
        $currentChannel = $_GET["channel"];

        if(isset($_POST['submit'])){
            SESSION_START();
            $id = rand(1, 1000000000000000);
            $author = $_SESSION['Username'];
            $publishDate = date("Y-m-d");
            $publishTime = date("H:i:s");
            $title = $_POST['Heading'];
            $content = $_POST['Content'];
            $category = $_POST['Category'];
            $channel = $_SESSION['Channel'];
            $upload_dir = "$channel".DIRECTORY_SEPARATOR;
            $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
            $uploadedFiles = "";
            // Define maxsize for files i.e 2MB
            $maxsize = 2 * 1024 * 1024;
            
            if(!empty(array_filter($_FILES['uploadFile']['name']))) {
 
                // Loop through each file in files[] array
                foreach ($_FILES['uploadFile']['tmp_name'] as $key => $value) {
                     
                    $file_tmpname = $_FILES['uploadFile']['tmp_name'][$key];
                    $file_name = $_FILES['uploadFile']['name'][$key];
                    $file_size = $_FILES['uploadFile']['size'][$key];
                    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
                    $uploadedFile = rand(100, 10000000000).".".$file_ext;
                    // Set upload file path
                    $filepath = $upload_dir.$uploadedFile;
         
                    // Check file type is allowed or not
                    if(in_array(strtolower($file_ext), $allowed_types)) {
         
                        // Verify file size - 2MB max
                        if ($file_size > $maxsize)        
                            echo "Error: File size is larger than the allowed limit.";
         
                        // If file with name already exist then append time in
                        // front of name of the file to avoid overwriting of file
                        if(file_exists($filepath)) {
                            $filepath = $upload_dir.time().$uploadedFile;
                             
                            if( move_uploaded_file($file_tmpname, $filepath)) {
                                echo "{$file_name} successfully uploaded <br />";
                                $uploadedFiles .= $uploadedFile.",";
                            }
                            else {                    
                                echo "Error uploading {$file_name} <br />";
                            }
                        }
                        else {
                         
                            if( move_uploaded_file($file_tmpname, $filepath)) {
                                echo "{$file_name} successfully uploaded <br />";
                                $uploadedFiles .= $uploadedFile.",";
                            }
                            else {                    
                                echo "Error uploading {$file_name} <br />";
                            }
                        }
                    }
                    else {
                         
                        // If file extension not valid
                        echo "Error uploading {$file_name} ";
                        echo "({$file_ext} file type is not allowed)<br / >";
                    }
                    
                }
            }
            else {
                 
                // If no files selected
                echo "No files selected.";
            }
            
            $query = "INSERT INTO news (ID, DatePublished, TimePublished, Author, Title, Content, Channel, ExternalMedia, Category) VALUES ('$id', '$publishDate', '$publishTime', '$author', '$title', '$content', '$channel', '$uploadedFiles', '$category')";
            $running = mysqli_query($connect1, $query);
            header("Location: News.php?channel=$currentChannel");
            
        }
        
        // if($running){
        //     echo "Success";
        //     header("Location: News.php");
        // }
        // else{
        //     echo "Error";
        // }
    
    ?>
    <div class="modal">
        <form class="modal-content" method="POST" enctype="multipart/form-data">
            <div class="container">
                <h1>Make News</h1>
                <hr>
                <label for="Heading"><b>Title</b></label>
                <input type="text" name="Heading" required>
                <label for="Content"><b>Body</b></label><br>
                <textarea style="font-family: Arial;" rows="6" cols="7" name="Content" class="contentText"></textarea>
                <input type="text" name="Category" list="category-list" required>
                <datalist id="category-list">
                    <option value="important"></option>
                    <option value="random"></option>
                </datalist>
                <input type="file" name="uploadFile[]" multiple></input>
                
                <div class="clearfix">
                    <button type="button" class="cancelbtn" onclick="window.location = 'News.php?channel=<?php echo $currentChannel?>';">Cancel</button>
                    <button type="submit" value="Submit" class="postbtn" name="submit">Post</button>
                </div>

            </div>

        </form>
    </div>

    

</body>
</html>