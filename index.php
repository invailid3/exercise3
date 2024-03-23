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
if(empty($_POST['name']) || strlen($_POST['name'])>150 || !preg_match("/^[\p{Cyrillic}a-zA-Z-' ]*$/u", $_POST['name'] )){
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

if(empty($_POST['pl']) || count($_POST['pl'])<1){
    $status = $status == 1 ? -6: $status;
}

if(empty($_POST['acception'])){
    $status = $status == 1 ? -7: $status;
}

if($status != 1){
    header(sprintf('Location: /exercise3/?status=%d', $status));
    exit();
}

$user = 'u67353';
$pass = '8375108';
$db = new PDO('mysql:host=localhost;dbname=u67353', $user, $pass,
    [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$stmt = $db->prepare("INSERT INTO application (name, tel, email, bday, sex, bio) VALUES (:name, :tel, :email, :bday, :sex, :bio)");
$stmt->bindParam(':name', $name);
$stmt->bindParam(':tel', $tel);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':bday', $bday);
$stmt->bindParam(':sex', $sex);
$stmt->bindParam(':bio', $bio);
$name = $_POST['name'];
$tel = $_POST['tel'];
$email = $_POST['email'];
$bday = $_POST['bday'];
$sex = $_POST['sex'] == "on" ? "1" : "0";
$bio = $_POST['bio'];
$stmt->execute();

$parent_id = $db->lastInsertId();
$stmt = $db->prepare("INSERT INTO favoritelang (parent_id, pl) VALUES(:parent_id, :pl)");
$stmt->bindParam(':parent_id',$parent_id);
foreach ($_POST['pl'] as $pl){
    $stmt->bindParam(':pl', $pl);
    $stmt->execute();
}


header('Location: /exercise3/?status=1');
