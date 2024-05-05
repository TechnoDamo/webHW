<?php
require 'pass.php';
global $username, $password, $dbname, $servername;
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    header('Location: form.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errorFlag = FALSE;

    function checkLangs($langs, $langs_check)
    {
        if (count($langs) == 0) return FALSE;
        for ($i = 0; $i < count($langs); $i++) {
            $isTrue = FALSE;
            for ($j = 0; $j < count($langs_check); $j++) {
                if (htmlentities($langs[$i]) === $langs_check[$j]) {
                    $isTrue = TRUE;
                    break;
                }
            }
            if ($isTrue === FALSE) return FALSE;
        }
        return TRUE;
    }

    $name = htmlentities($_POST['name']);
    $phone = htmlentities($_POST['phone']);
    $email = htmlentities($_POST['email']);
    $date = htmlentities($_POST['date']);
    $gender = "";
    $contract = htmlentities($_POST['contract']);
    if (empty(htmlentities($_POST['gender']))) {
        $errorFlag = TRUE;
    }
    else if (htmlentities($_POST['gender']) == 'male' || htmlentities($_POST['gender'] == 'female')) {
        $gender = htmlentities($_POST['gender']);
    }
    else {
        $gender = 'other';
    }
    $bio = htmlentities($_POST['bio']);
    $langs = $_POST['progLang'];
    $langs_check = ['c', 'c++', 'js', 'java', 'clojure', 'pascal', 'python', 'haskel', 'scala', 'php', 'prolog'];
    if (empty($name)) {
        $errorFlag = TRUE;
        setcookie('name_error', 'name field cannot be left blank', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    }
    else if (!preg_match('/^[A-Za-z]+$/', $name) || strlen($name) >= 100) {
        $errorFlag = TRUE;
        setcookie('name_error', 'please, enter a valid name', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    } else {
        if (isset($_COOKIE['name_error'])) {
            setcookie('name_error', '', time() - 360000, '/hw4', '', true, true);
        }
        setcookie('name_value', $name, time() + 30 * 24 * 60 * 60,  '/hw4', '', true, true);
    }

    if (empty($phone)) {
        $errorFlag = TRUE;
        setcookie('phone_error', 'phone field cannot be left blank', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    }
    else if (!preg_match('/^[0-9+]+$/', $phone) || (strlen($phone) != 11 && strlen($phone) != 12)) {
        $errorFlag = TRUE;
        setcookie('phone_error', 'please, enter a valid phone number', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    } else {
        // Сохраняем ранее введенное в форму значение на месяц.
        if (isset($_COOKIE['phone_error'])) {
            setcookie('phone_error', '', time() - 360000, '/hw4', '', true, true);
        }
        setcookie('phone_value', $phone, time() + 30 * 24 * 60 * 60,  '/hw4', '', true, true);
    }

    if (empty($email)) {
        $errorFlag = TRUE;
        setcookie('email_error', 'email field cannot be left blank', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorFlag = TRUE;
        setcookie('email_error', 'please, enter a valid email address', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    } else {
        if (isset($_COOKIE['email_error'])) {
            setcookie('email_error', '', time() - 360000, '/hw4', '', true, true);
        }
        setcookie('email_value', $email, time() + 30 * 24 * 60 * 60,  '/hw4', '', true, true);
    }

    $dateObject = DateTime::createFromFormat('Y-m-d', $date);

    if(empty($date)) {
        $errorFlag = TRUE;
        setcookie('date_error', 'birthdate field cannot be left blank', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    }
    else if ($dateObject->format('Y-m-d') !== $date) {
        $errorFlag = TRUE;
        setcookie('date_error', 'birthdate does not match the conditions', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    } else {
        if (isset($_COOKIE['date_error'])) {
            setcookie('date_error', '', time() - 360000, '/hw4', '', true, true);
        }
        setcookie('date_value', $date, time() + 30 * 24 * 60 * 60,  '/hw4', '', true, true);
    }

    if(empty($gender)) {
        $errorFlag = TRUE;
        setcookie('gender_error', 'gender cannot be left blank', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    }
    else if ($gender == 'other') {
        $errorFlag = TRUE;
        setcookie('gender_error', 'gender must be male or female', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    }
    else {
        if (isset($_COOKIE['gender_error'])) {
            setcookie('gender_error', '', time() - 360000, '/hw4', '', true, true);
        }
        setcookie('gender_value', $gender, time() + 30 * 24 * 60 * 60,  '/hw4', '', true, true);
    }

    if(empty($langs)) {
        $errorFlag = TRUE;
        setcookie('langs_error', 'you should choose at least one language from the list', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    }
    else if (!checkLangs($langs, $langs_check)) {
        $errorFlag = TRUE;
        setcookie('langs_error', 'every language should be from the given list', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    } else {
        if (isset($_COOKIE['langs_error'])) {
            setcookie('langs_error', '', time() - 360000, '/hw4', '', true, true);
        }
        setcookie('langs_value', serialize($langs), time() + 30 * 24 * 60 * 60,  '/hw4', '', true, true);
    }

    if (empty($contract)) {
        $errorFlag = TRUE;
        setcookie('contract_value', '', time() - 360000, '/hw4', '', true, true);
        setcookie('contract_error', 'you should accept the conditions in order to proceed', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    }
    else {
        setcookie('contract_error', '', time() - 360000, '/hw4', '', true, true);
        setcookie('contract_value', '1', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    }

    if (empty($bio)) {
        $errorFlag = TRUE;
        setcookie('bio_error', 'bio field cannot be left blank', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    }
    else if (preg_match("/<[^>]*>/", $bio)) {
        $errorFlag = TRUE;
        setcookie('bio_error', 'bio should not contain html tags', time() + 24 * 60 * 60,  '/hw4', '', true, true);
    } else {
        if (isset($_COOKIE['bio_error'])) {
            setcookie('bio_error', '', time() - 360000, '/hw4', '', true, true);
        }
        setcookie('bio_value', $bio, time() + 30 * 24 * 60 * 60,  '/hw4', '', true, true);
    }

    if ($errorFlag) {
        if (isset($_COOKIE['save'])) {
            setcookie('save', '', time() - 360000, '/hw4', '', true, true);
        }
        setcookie('save_error', 'can not save due to mistakes');
        header('Location: form.php');
        exit();
    }
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully ";
        $sql = "INSERT INTO request (name, phone, email, birthdate, gender, bio) 
        VALUES (:name, :phone, :email, :birthdate, :gender, :bio)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':birthdate', $date);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':bio', $bio);
        $stmt->execute();
        $lastId = $conn->lastInsertId();

        for ($i = 0; $i < count($langs); $i++) {
            $sql = "SELECT lang_id FROM progLang WHERE lang_name = :langName";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':langName', $langs[$i]);
            $stmt->execute();
            $result = $stmt->fetch();
            $lang_id = $result['lang_id'];

            $sql = "INSERT INTO requestToLang (id, lang_id) VALUES (:lastId, :langId)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':lastId', $lastId);
            $stmt->bindParam(':langId', $lang_id);
            $stmt->execute();
        }

        echo nl2br("\nNew record created successfully");
    }
    catch (PDOException $e) {
        if (isset($_COOKIE['save'])) {
            setcookie('save', '', time() - 360000, '/hw4', '', true, true);
        }
        setcookie('save_error', $e->getMessage());
        header('Location: form.php');
        exit();
    }
    $conn = null;

    if (isset($_COOKIE['save_error'])) {
        setcookie('save_error', '', time() - 360000, '/hw4', '', true, true);
    }
    setcookie('save', 'your response has been saved', time() + 30 * 24 * 60 * 60,  '/hw4', '', true, true);

    header('Location: form.php');
    exit();

}
