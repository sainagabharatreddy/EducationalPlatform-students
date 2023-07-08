<?php
 $username = $_POST['username'];
 $password = $_POST['password'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   

    
    $validUsername = 'admin';
    $validPassword = 'kits123';

    if ($username === $validUsername && $password === $validPassword) {
       
       include('eduweb-master/index.html');
        exit;
    } else {
        
        echo 'Invalid username or password.';
    }
}
?>
