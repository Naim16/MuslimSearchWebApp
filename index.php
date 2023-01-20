<?php 
include("includes/header.php");

if(isset($_POST['post'])){

    $uploadOk = 1;
    $imageName = $_FILES['fileToUpload']['name'];   
    $errorMessage = "";

    if($imageName != ""){
        $targetDir = "assets/images/posts/";
        $imageName = $targetDir . uniqid() . basename($imageName);
        $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

        if($_FILES['fileToUpload']['size'] > 1000000){
            $errorMessage = "File is too large";
            $uploadOk = 0;
        }

        if(strtolower($imageFileType) != "pdf" && strtolower($imageFileType) != "docx"){
            $errorMessage = "Only pdf and docs files are allowed";
            $uploadOk = 0;
        }

        if($uploadOk){
            if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)){

            }
            else{
                $uploadOk = 0;
            }
        }
    }

    if($uploadOk){
        $post = new Post ($con, $userLoggedIn);
        $post->submitPost($_POST['post_text'], 'none', $imageName);
    }
    else{
        echo "<div style='text-align:center;' class='alert alert-danger'>
                $errorMessage
            </div>";
    }

}

?>

    <div class="user_details column">
        <a href="<?php echo $userLoggedIn; ?>"> <img src="<?php echo $user['profile_pic']; ?>"></a>

        <div class="user_details_left_right">
            <a href="<?php echo $userLoggedIn; ?>">
            <?php
            echo $user ['first_name'] . " " . $user['last_name'];
            ?>
            </a>
            <br>
            <?php echo "Posts: " . $user['num_posts']. "<br>";
            echo "Likes: " . $user['num_likes'];

            ?>
        </div>
    </div>

    <div class="main_column column">

        <form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload">
            <textarea name="post_text" id="post_text" placeholder="say something"></textarea>
            <input type="submit" name="post" id="post_button" value="Post">
            <hr>
        </form>


    <?php

    $post = new Post ($con, $userLoggedIn);
    $post->loadPostsFriends();

    ?>

    </div>

</body>
</html>