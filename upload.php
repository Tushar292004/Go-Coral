<?php
echo "image not found!";
if(isset($_FILES['imageToUpload'])){
  move_uploaded_file($_FILES['imageToUpload']['tmp_name'], "images/". $_FILES['imageToUpload']['name']);
}
else{
    echo "image not found!";
}
?>