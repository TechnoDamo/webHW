<!DOCTYPE html>
<?php
$xmlString = '';
$xml = '';
$firstName = '';
$lastName = '';
$phoneNumber = '';
$email = '';
$birthdate = '';
$gender = '';
$langs = array();
$bio = '';

function isValidDate($dateString) {
    $date = DateTime::createFromFormat('Y-m-d', $dateString);
    return $date && $date->format('Y-m-d') === $dateString;
}
$allowedLanguages = array("Pascal", "C", "C++", "JavaScript", "PHP", "Python", "Java", "Haskel", "Clojure", "Prolog", "Scala");
function validateProgrammingLanguages($array) {
    global $allowedLanguages;
    foreach ($array as $language) {
        if (!in_array($language, $allowedLanguages)) {
            return false;
        }
    }
    return true;
}
function isValidForm() {
    $f = 1;
    $firstName = $_POST['first_name']; 
    if (!preg_match("/^[a-zA-Z]{1,30}$/", $firstName)) {
        return 0;
    }

    $lastName = $_POST['last_name']; 
    if (!preg_match("/^[a-zA-Z]{1,30}$/", $lastName)) {
        return 0;
    }

    $phoneNumber = $_POST['phone'];
    if (!preg_match("/^\+7\d{10}$/", $phoneNumber)) {
        return 0;
    }

    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 0;
    }

    $birthdate = $_POST['birthdate'];
    if (!isValidDate($birthdate)) {
        return 0;
    }

    $gender = $_POST['gender'];
    if ($gender != 'male' && $gender != 'female') {
        return 0;
    }

    $langs = $_POST['programming-languages'];
    if (!validateProgrammingLanguages($langs)) {
        return 0;
    }


    return 1;
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    session_start();
    $contentType = $_SERVER['CONTENT_TYPE'];
    if ($contentType == 'application/json') {
        $jsonString = file_get_contents($_FILES['formData']['tmp_name']);

        $data = json_decode($jsonString, true);

        if ($data === null) {
            echo "Failed decoding JSON: " . json_last_error_msg();
        } else {
            $firstName = $data['first_name'];
            $lastName = $data['last_name'];
            $phoneNumber = $data['phone'];
            $email = $data['email'];
            $birthdate = date('Y-m-d', strtotime($data['birthdate']));
            $gender = $data['gender'];
            $programmingLanguages = $data['programming-language'];
            $bio = $data['bio'];
            $response = array('message' => 'Data received successfully');
            header('Content-Type: application/json');
            echo json_encode($response);
        }


    }
    else if ($contentType == 'application/xml') {
        $xmlString = file_get_contents('php://input');
        $xml = simplexml_load_string($xmlString);
        echo $xml;
        if ($xml === false) {
            echo "Failed loading XML: ";
            foreach(libxml_get_errors() as $error) {
                echo "<br>", $error->message;
            }
        } else {
            print_r($xml);
        }

        $xml = simplexml_load_string($xmlString);
        $firstName = (string) $xml->first_name;
        $lastName = (string) $xml->last_name;
        $phoneNumber = (string) $xml->phone;
        $email = (string) $xml->email;
        $dateString = (string)$xml->birthdate;
        $dateObject = new DateTime($dateString);
        $birthdate = $dateObject->format('Y-m-d');$gender = (string) $xml->gender;
        $gender = (string) $xml->gender;
        foreach ($xml->{'programming-language'} as $language) {
            $langs[] = (string)$language;
        }
        $bio = (string) $xml->bio;

                if (!isValidForm()) {
                    exit(0);
                }

    }
    else if ($contentType == 'application/x-www-form-urlencoded') {
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $phoneNumber = $_POST['phone'];
        $email = $_POST['email'];
        $birthdate = $_POST['birthdate'];
        $gender = $_POST['gender'];
        $langs = $_POST['programming-language'];
        $bio = $_POST['bio'];
        if (!isValidForm()) {
            exit(0);
        }
    }
    $userId = $_SESSION['userid'];
    if ($_SESSION['loggedinA']) {
        $userId = $_SESSION['user_id'];
    }
    echo $userId;
    $conn = '';
    try {
        require_once 'db_connection.php';
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully<br/>";

        $sql = "UPDATE data 
SET first_name = :first_name, 
    last_name = :last_name, 
    phone = :phone, 
    email = :email, 
    birthdate = :birthdate, 
    gender = :gender, 
    bio = :bio 
WHERE user_id = :user_id;
";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':phone', $phoneNumber);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':birthdate', $birthdate);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':bio', $bio);
        $stmt->execute();

        $sql = "DELETE FROM users_langs WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        for ($i = 0; $i < count($langs); $i++) {
            $sql = "select language_id from prog_langs where language_name = :langName";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':langName', $langs[$i]);
            $stmt->execute();
            $result = $stmt->fetch();

            $sql = "INSERT INTO users_langs (user_id, language_id) VALUES (:userId, :langId)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':langId', $result['language_id']);
            $stmt->execute();
        }
        echo nl2br("\nNew record created successfully");
        if ($_SESSION['loggedinA']) {
            header("Location: admin.php");
            exit;
        }
        header("Location: response.php");
        exit;
    }
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}


