<?php 
$ServerName = 'localhost'; 
$Username = 'root'; 
$Password = '';
$Database = 'music';
$conn = mysqli_connect($ServerName, $Username, $Password, $Database); 
// Check Connection 
if ($conn) { 
    echo "Connected to Database Successfully";
}
else { 
    echo "Connection Failed";
}
?> 