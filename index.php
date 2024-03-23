<?php

$status_desc = array(
    "1" => "ok",
    "-1" => "Enter correct name",
    "-2" => "Enter correct phone",
    "-3" => "Enter correct email",
    "-4" => "Select b-date",
    "-5" => "Choose sex",
    "-6" => "Choose favorite pl",
    "-7"=> "Fill acception",
);

header('Content-Type: text/html; charset=UTF-8');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(!empty($_GET['status'])){
        print(sprintf("<script>alert('%s');</script>", $status_desc[$_GET['status']]));
    }
    include('./form.html');
    exit();
}

$status = 1;

$errors = FALSE;
if(empty($_POST['name'])){
    $status = -1;
}

if(empty($_POST['tel']) || !preg_match('/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/', $_POST['tel'])){
    $status = $status == 1 ? -2: $status;
}

if(empty($_POST['email']) || !preg_match('/[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/', $_POST['email'])){
    $status = $status == 1 ? -3: $status;
}

if(empty($_POST['bday'])){
    $status = $status == 1 ? -4: $status;
}

if(empty($_POST['sex'])){
    $status = $status == 1 ? -5: $status;
}

if(empty($_POST['pl'])){
    $status = $status == 1 ? -6: $status;
}

if(empty($_POST['acception'])){
    $status = $status == 1 ? -7: $status;
}

if($status != 1){
    header(sprintf('Location: /web-2-task-3/?status=%d', $status));
    exit();
}

header('Location: /web-2-task-3/?status=1');