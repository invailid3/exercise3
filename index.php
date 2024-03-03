<?php
header('Content-Type: text/html; charset=UTF-8');

if($_SERVER['$_REQUEST_METHOD'] == 'GET'){
    if(!empty($_GET['save'])){
        print('Thanks, the data has saved');
    }
    include('form.php');
    exit();
}

$errors = FALSE;
if(empty($_POST['name'])){
    print('Fill the name.<br>');
    $errors = TRUE;
}

if(empty($_POST['tel']) || !preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $_POST['tel'])){
    print('Fill  phone.<br/>');
    $errors = TRUE;
}

if(empty($_POST['email']) || !preg_match('/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/', $_POST['email'])){
    print('Fill email.<br/>');
    $errors = TRUE;
}

if(empty($_POST['data']) || !preg_match('/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/', $_POST['date'])){
    print('Fill the date of birth day.<br/>');
    $errors = TRUE;
}

if(empty($_POST['sex'])){
    print('Choose sex.<br/>');
    $errors = TRUE;
}



if(empty($_POST['pl'])){
    print('Choose favorite programming language.<br/>');
    $errors = TRUE;
}

if(empty($_POST['acception'])){
    print('Fill ');
    $errors = TRUE;
}

if($errors){
    exit();
}
?>