<?php
if ($_FILES["pic"]["error"] > 0)
{
    echo "Error: " . $_FILES["pic"]["error"] . "<br />";
}
else
{
    echo "Upload: " . $_FILES["pic"]["name"] . "<br />";
    echo "Type: " . $_FILES["pic"]["type"] . "<br />";
    echo "Size: " . ($_FILES["pic"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["pic"]["tmp_name"];
    $dir = $_SERVER['DOCUMENT_ROOT'].'/upload/';
    move_uploaded_file($_FILES["pic"]["tmp_name"], $dir.$_FILES["pic"]["name"]);
}