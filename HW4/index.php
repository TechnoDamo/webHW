<?php
require 'pass.php';
global $username, $password, $dbname, $servername;
global $errors, $messages, $values;
/**
 * Реализовать проверку заполнения обязательных полей формы в предыдущей
 * с использованием Cookies, а также заполнение формы по умолчанию ранее
 * введенными значениями.
 */

// Отправляем браузеру правильную кодировку,
// файл main.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');
// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Складываем признак ошибок в массив.
    /*
    $errors = array();
    $errors['name'] = !empty($_COOKIE['name_error']);
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['date'] = !empty($_COOKIE['date_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['progLang[]'] = !empty($_COOKIE['langs_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['contract'] = !empty($_COOKIE['contract_error']);

    // Складываем предыдущие значения полей в массив, если есть.
    $values = array();
    $values['name'] = empty($_COOKIE['name_value']) ? '' : $_COOKIE['name_value'];
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['date'] = empty($_COOKIE['date_value']) ? '' : $_COOKIE['date_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['progLang[]'] = empty($_COOKIE['progLang[]_value']) ? '' : $_COOKIE['progLang[]_value'];
    $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
    $values['contract'] = empty($_COOKIE['contract_value']) ? '' : $_COOKIE['contract_value'];
    require_once('/var/www/html/hw4/form.php');
    // Включаем содержимое файла form.php.
    // В нем будут доступны переменные $messages, $errors и $values для вывода
    // сообщений, полей с ранее заполненными данными и признаками ошибок.
    */
}
else {
    $errors = FALSE;

    function checkLangs($langs, $langs_check)
    {
        if (count($langs) == 0) return FALSE;
        for ($i = 0; $i < count($langs); $i++) {
            $isTrue = FALSE;
            for ($j = 0; $j < count($langs_check); $j++) {
                if ($langs[$i] === $langs_check[$j]) {
                    $isTrue = TRUE;
                    break;
                }
            }
            if ($isTrue === FALSE) return FALSE;
        }
        return TRUE;
    }

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $gender = "";
    $contract = $_POST['contract'];
    if (empty($_POST['gender'])) {
        $errors = TRUE;
    }
    else if ($_POST['gender'] == 'male' || $_POST['gender'] == 'female') {
        $gender = $_POST['gender'];
    }
    else {
        $gender = 'other';
    }
    $bio = $_POST['bio'];
    $langs = $_POST['progLang'];
    $langs_check = ['c', 'c++', 'js', 'java', 'clojure', 'pascal', 'python', 'haskel', 'scala', 'php', 'prolog'];
    if (empty($name)) {
        $errors = TRUE;
        setcookie('name_error', 'name field cannot be left blank', time() + 24 * 60 * 60);
    }
    else if (!preg_match('/^[A-Za-z]+$/', $name) || strlen($name) >= 100) {
        $errors = TRUE;
        // Выдаем куку на день с флажком об ошибке в поле name.
        setcookie('name_error', 'please, enter a valid name', time() + 24 * 60 * 60);
    } else {
        // Сохраняем введенное в форму значение на месяц.
        if (isset($_COOKIE['name_error'])) {
            setcookie('name_error', '', time() - 3600);
        }
        setcookie('name_value', $name, time() + 30 * 24 * 60 * 60);
    }

    if (empty($phone)) {
        $errors = TRUE;
        setcookie('phone_error', 'phone field cannot be left blank', time() + 24 * 60 * 60);
    }
    else if (!preg_match('/^[0-9+]+$/', $phone) || (strlen($phone) != 11 && strlen($phone) != 12)) {
        $errors = TRUE;
        setcookie('phone_error', 'please, enter a valid phone number', time() + 24 * 60 * 60);
    } else {
        // Сохраняем ранее введенное в форму значение на месяц.
        if (isset($_COOKIE['phone_error'])) {
            setcookie('phone_error', '', time() - 3600);
        }
        setcookie('phone_value', $phone, time() + 30 * 24 * 60 * 60);
    }

    if (empty($email)) {
        $errors = TRUE;
        setcookie('email_error', 'email field cannot be left blank', time() + 24 * 60 * 60);
    }
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors = TRUE;
        setcookie('email_error', 'please, enter a valid email address', time() + 24 * 60 * 60);
    } else {
        if (isset($_COOKIE['email_error'])) {
            setcookie('email_error', '', time() - 3600);
        }
        setcookie('email_value', $email, time() + 30 * 24 * 60 * 60);
    }

    $dateObject = DateTime::createFromFormat('Y-m-d', $date);

    if(empty($date)) {
        $errors = TRUE;
        setcookie('date_error', 'birthdate field cannot be left blank', time() + 24 * 60 * 60);
    }
    else if ($dateObject->format('Y-m-d') !== $date) {
        $errors = TRUE;
        setcookie('date_error', 'birthdate does not match the conditions', time() + 24 * 60 * 60);
    } else {
        if (isset($_COOKIE['date_error'])) {
            setcookie('date_error', '', time() - 3600);
        }
        setcookie('date_value', $date, time() + 30 * 24 * 60 * 60);
    }

    if(empty($gender)) {
        $errors = TRUE;
        setcookie('gender_error', 'gender cannot be left blank', time() + 24 * 60 * 60);
    }
    else if ($gender == 'other') {
        $errors = TRUE;
        setcookie('gender_error', 'gender must be male or female', time() + 24 * 60 * 60);
    }
    else {
        if (isset($_COOKIE['gender_error'])) {
            setcookie('gender_error', '', time() - 3600);
        }
        setcookie('gender_value', $gender, time() + 30 * 24 * 60 * 60);
    }

    if(empty($langs)) {
        $errors = TRUE;
        setcookie('langs_error', 'you should choose at least one language from the list', time() + 24 * 60 * 60);
    }
    else if (!checkLangs($langs, $langs_check)) {
        $errors = TRUE;
        setcookie('langs_error', 'every language should be from the given list', time() + 24 * 60 * 60);
    } else {
        if (isset($_COOKIE['langs_error'])) {
            setcookie('langs_error', '', time() - 3600);
        }
        setcookie('langs_value', serialize($langs), time() + 30 * 24 * 60 * 60);
    }

    if (empty($contract)) {
        $errors = TRUE;
        setcookie('contract_value', '', time() - 3600);
        setcookie('contract_error', 'you should accept the conditions in order to proceed', time() + 24 * 60 * 60);
    }
    else {
        setcookie('contract_error', '', time() - 3600);
        setcookie('contract_value', '1', time() + 24 * 60 * 60);
    }

    if (empty($bio)) {
        $errors = TRUE;
        setcookie('bio_error', 'bio field cannot be left blank', time() + 24 * 60 * 60);
    }
    else if (preg_match("/<[^>]*>/", $bio)) {
        $errors = TRUE;
        setcookie('bio_error', 'bio should not contain html tags', time() + 24 * 60 * 60);
    } else {
        if (isset($_COOKIE['bio_error'])) {
            setcookie('bio_error', '', time() - 3600);
        }
        setcookie('bio_value', $bio, time() + 30 * 24 * 60 * 60);
    }

    if ($errors) {
        // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
        if (isset($_COOKIE['save'])) {
            setcookie('save', '', time() - 3600);
        }
        setcookie('save_error', 'can not save due to mistakes');
        header('Location: form.php');
        exit();
    }
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully ";
        $sql = "INSERT INTO request (name, phone, email, date, gender, bio) 
        VALUES (:name, :phone, :email, :date, :gender, :bio)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':date', $date);
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
    } catch (PDOException $e) {
        echo "Connection failed: ";
    }
    $conn = null;

    if (isset($_COOKIE['save_error'])) {
        setcookie('save_error', '', time() - 3600);
    }
    setcookie('save', 'your response has been saved');

// Делаем перенаправление.
    header('Location: form.php');
    exit();

}
