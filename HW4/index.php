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
    // Массив для временного хранения сообщений пользователю.
    $messages = array();

    // В суперглобальном массиве $_COOKIE PHP хранит все имена и значения куки текущего запроса.
    // Выдаем сообщение об успешном сохранении.
    if (!empty($_COOKIE['save'])) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('save', '', 100000);
        // Если есть параметр save, то выводим сообщение пользователю.
        $messages[] = 'Спасибо, результаты сохранены.';
    }

    // Складываем признак ошибок в массив.
    $errors = array();
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['phone'] = !empty($_COOKIE['phone_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['birthdate'] = !empty($_COOKIE['birthdate_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['progLang[]'] = !empty($_COOKIE['progLang[]_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);
    $errors['contract'] = !empty($_COOKIE['contract_error']);

    // Выдаем сообщения об ошибках.
    if ($errors['fio']) {
        // Удаляем куку, указывая время устаревания в прошлом.
        setcookie('fio_error', '', 100000);
        // Выводим сообщение.
        $messages[] = '<div class="error">Заполните имя.</div>';
    }
    // TODO: тут выдать сообщения об ошибках в других полях.
    if ($errors['phone']) {
        setcookie('phone_error', '', 100000);
        $messages[] = '<div class="error">Заполните телефон.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        $messages[] = '<div class="error">Заполните email.</div>';
    }
    if ($errors['birthdate']) {
        setcookie('birthdate_error', '', 100000);
        $messages[] = '<div class="error">Заполните birthdate.</div>';
    }
    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        $messages[] = '<div class="error">Заполните gender.</div>';
    }
    if ($errors['progLang[]']) {
        setcookie('progLang[]_error', '', 100000);
        $messages[] = '<div class="error">Заполните progLang[].</div>';
    }
    if ($errors['bio']) {
        setcookie('bio_error', '', 100000);
        $messages[] = '<div class="error">Заполните bio.</div>';
    }
    if ($errors['contract']) {
        setcookie('contract_error', '', 100000);
        $messages[] = '<div class="error">Заполните contract.</div>';
    }

    // Складываем предыдущие значения полей в массив, если есть.
    $values = array();
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
    $values['phone'] = empty($_COOKIE['phone_value']) ? '' : $_COOKIE['phone_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['birthdate'] = empty($_COOKIE['birthdate_value']) ? '' : $_COOKIE['birthdate_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['progLang[]'] = empty($_COOKIE['progLang[]_value']) ? '' : $_COOKIE['progLang[]_value'];
    $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
    $values['contract'] = empty($_COOKIE['contract_value']) ? '' : $_COOKIE['contract_value'];
    //require('/var/www/html/hw4/index.php');
    // Включаем содержимое файла form.php.
    // В нем будут доступны переменные $messages, $errors и $values для вывода
    // сообщений, полей с ранее заполненными данными и признаками ошибок.
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

    xdebug_var_dump($_POST);
    var_dump($_POST);
    $fio = $_POST['fio'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $gender = $_POST['gender'];
    $bio = $_POST['bio'];
    $langs = $_POST['progLang'];
    $langs_check = ['c', 'c++', 'js', 'java', 'clojure', 'pascal', 'python', 'haskel', 'scala', 'php', 'prolog'];
    if (empty($fio) || !preg_match('/^[A-Za-z]+$/', $fio) || strlen($fio) >= 100) {
        $errors = TRUE;
        // Выдаем куку на день с флажком об ошибке в поле fio.
        setcookie('fio_error', '1', time() + 24 * 60 * 60);
        echo nl2br("fio doesn't match the conditions (only Latin letters and size < 100)\n");
    } else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($phone) || !preg_match('/^[0-9+]+$/', $phone) || (strlen($phone) != 11 && strlen($phone) != 12)) {
        $errors = TRUE;
        setcookie('phone_error', '1', time() + 24 * 60 * 60);
        echo nl2br(" phone doesn't match the conditions\n");
    } else {
        // Сохраняем ранее введенное в форму значение на месяц.
        setcookie('phone_value', $_POST['phone'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors = TRUE;
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        echo nl2br(" email doesn't match the conditions\n");
    } else {
        setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    }

    $dateObject = DateTime::createFromFormat('Y-m-d', $birthdate);
    if ($dateObject === false || $dateObject->format('Y-m-d') !== $birthdate) {
        $errors = TRUE;
        setcookie('birthdate_error', '1', time() + 24 * 60 * 60);
        echo nl2br(" birthdate doesn't match the conditions\n");
    } else {
        setcookie('birthdate_value', $_POST['birthdate'], time() + 30 * 24 * 60 * 60);
    }

    if (!isset($gender) || ($gender != 'male' && $gender != 'female')) {
        $errors = TRUE;
        setcookie('gender_error', '1', time() + 24 * 60 * 60);
        echo nl2br(" gender doesn't match the conditions\n");
    } else {
        setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
    }

    if (!isset($gender) || !checkLangs($langs, $langs_check)) {
        $errors = TRUE;
        setcookie('checkLangs[]_error', '1', time() + 24 * 60 * 60);
        echo nl2br(" langs do not match the conditions\n");
    } else {
        setcookie('checkLangs[]_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
    }

    if (empty($bio) || preg_match("/<[^>]*>/", $bio)) {
        $errors = TRUE;
        setcookie('bio_error', '1', time() + 24 * 60 * 60);
        echo nl2br(" bio shouldn't contain html tags\n");
    } else {
        setcookie('bio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
    }

    if ($errors) {
        // При наличии ошибок перезагружаем страницу и завершаем работу скрипта.
        header('Location: index.php');
        exit();
    } else {
        // Удаляем Cookies с признаками ошибок.
        setcookie('fio_error', '', 100000);
        setcookie('phone_error', '', 100000);
        setcookie('email_error', '', 100000);
        setcookie('birthday_error', '', 100000);
        setcookie('gender_error', '', 100000);
        setcookie('progLang[]_error', '', 100000);
        setcookie('bio_error', '', 100000);
        setcookie('contract_error', '', 100000);
    }
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully ";
        $fio = $_POST['fio'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $birthdate = $_POST['birthdate'];
        $gender = $_POST['gender'];
        $bio = $_POST['bio'];
        $langs = $_POST['progLang'];
        $sql = "INSERT INTO request (fio, phone, email, birthdate, gender, bio) 
        VALUES (:fio, :phone, :email, :birthdate, :gender, :bio)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fio', $fio);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':birthdate', $birthdate);
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

    setcookie('save', '1');

// Делаем перенаправление.
    header('Location: form.php');
    exit();

}