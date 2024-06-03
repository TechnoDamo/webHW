<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: signin.html");
    exit();
}
$_SESSION['loggedinA'] = false;

$conn = '';
$user_id = $_SESSION['userid'];
require_once 'db_connection.php';
$sql = "select first_name from data where user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['first_name'] = $result['first_name'];

$sql = "select last_name from data where user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['last_name'] = $result['last_name'];


$sql = "select phone from data where user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['phone'] = $result['phone'];


$sql = "select email from data where user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['email'] = $result['email'];


$sql = "select birthdate from data where user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['birthdate'] = $result['birthdate'];


$sql = "select bio from data where user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['bio'] = $result['bio'];


$sql = "select gender from data where user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION['gender'] = $result['gender'];


$sql = "SELECT pl.language_name 
        FROM users_langs ul
        JOIN prog_langs pl ON ul.language_id = pl.language_id
        WHERE user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$languages = array_column($results, 'language_name');
$_SESSION['langs'] = $languages;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
        #male {
            position: relative;
            left: 19px;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="tel"],
        input[type="email"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="radio"],
        input[type="checkbox"] {
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .checkbox-label {
            display: flex;
            align-items: center;
        }

        .checkbox-label input[type="checkbox"] {
            margin-left: 10px;
            margin-bottom: 8px;
        }
    </style>
    <script>
        function submitForm(event) {
            event.preventDefault(); 

            const formData = new FormData(event.target); 

            if (window.fetch) {
                fetch('signup.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/xml'

                    },
                    body: formDataToXml(formData) 
                })
                    .then(response => {
                        console.log('Data sent via Fetch:', response);
                    })
                    .catch(error => {
                        console.error('Error sending data via Fetch:', error);
                    });
            } else {
                event.target.submit();
            }
        }

        function formDataToJson(formData) {
            let jsonData = {};

            for (let [key, value] of formData.entries()) {
                if (key === 'programming-language') {
                    jsonData[key] = Array.from(value);
                } else {
                    jsonData[key] = value;
                }
            }

            return JSON.stringify(jsonData, null, 2);
        }

    </script>
</head>
<body>
<form>
    <h1><?php echo $_SESSION['username'] ?></h1>
</form>
<form class="form" action = "edit.php" onsubmit="return submitForm(event) method = "POST">
    <div>
        <label for="first_name">First name:</label>
        <input type="text" id="first_name" name="first_name" placeholder="Your first name" pattern = "^[a-zA-Z]{1,30}$" value = "<?php echo $_SESSION['first_name'] ?>" oninvalid="this.setCustomValidity('Input a valid first name, please(only latin characters)')" oninput="this.setCustomValidity('')" required>
    </div>

    <div>
        <label for="last_name">Last name:</label>
        <input type="text" id="last_name" name="last_name" placeholder="Your second name" pattern = "^[a-zA-Z]{1,30}$" value = "<?php echo $_SESSION['last_name'] ?>" oninvalid="this.setCustomValidity('Input a valid last name, please(only latin characters)')" oninput="this.setCustomValidity('')" required>
    </div>
    <div>
        <label for="phone">Phone number:</label>
        <input type="tel" id="phone" name="phone" placeholder="start with +7" pattern="^\+7\d{10}$"  value = "<?php echo $_SESSION['phone'] ?>" oninvalid="this.setCustomValidity('Input a valid phone number, please')" oninput="this.setCustomValidity('')" required>
    </div>
    <div>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" placeholder="your email" value = "<?php echo $_SESSION['email'] ?>" oninvalid="this.setCustomValidity('Input correct email, please')" oninput="this.setCustomValidity('')"required>
    </div>
    <div>
        <label for="birthdate">Birthdate:</label>
        <input type="date" id="birthdate" name="birthdate" value = "<?php echo $_SESSION['birthdate'] ?>" oninvalid="this.setCustomValidity('Input your birthdate, please')" oninput="this.setCustomValidity('')" required>
    </div>
    <div>
        <p>Gender:</p>
        <label for="male">
            Male
            <input type="radio" id="male" name="gender" value="male" <?php if($_SESSION['gender'] == 'male') { echo 'checked'; }  ?> required>
        </label>
        <label for="female">
            Female
            <input type="radio" id="female" name="gender" value="female" <?php if($_SESSION['gender'] == 'female') { echo 'checked'; }  ?> required>
        </label>
    </div>
    <div>
        <label for="programming-language">Favourite programming language:</label>
        <select id="programming-language" name="programming-language[]" multiple required>
            <option value="Pascal" <?php if (in_array('Pascal', $_SESSION['langs'])) { echo 'selected'; } ?>>Pascal</option>
            <option value="C" <?php if (in_array('C', $_SESSION['langs'])) { echo 'selected'; } ?>>C</option>
            <option value="C++" <?php if (in_array('C++', $_SESSION['langs'])) { echo 'selected'; } ?>>C++</option>
            <option value="JavaScript" <?php if (in_array('JavaScript', $_SESSION['langs'])) { echo 'selected'; } ?>>JavaScript</option>
            <option value="PHP" <?php if (in_array('PHP', $_SESSION['langs'])) { echo 'selected'; } ?>>PHP</option>
            <option value="Python" <?php if (in_array('Python', $_SESSION['langs'])) { echo 'selected'; } ?>>Python</option>
            <option value="Java" <?php if (in_array('Java', $_SESSION['langs'])) { echo 'selected'; } ?>>Java</option>
            <option value="Haskel" <?php if (in_array('Haskel', $_SESSION['langs'])) { echo 'selected'; } ?>>Haskel</option>
            <option value="Clojure" <?php if (in_array('Clojure', $_SESSION['langs'])) { echo 'selected'; } ?>>Clojure</option>
            <option value="Prolog" <?php if (in_array('Prolog', $_SESSION['langs'])) { echo 'selected'; } ?>>Prolog</option>
            <option value="Scala" <?php if (in_array('Scala', $_SESSION['langs'])) { echo 'selected'; } ?>>Scala</option>
        </select>
    </div>
    <div>
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" placeholder="Tell us about yourself" required><?php echo $_SESSION['bio'] ?></textarea>
    </div>
    <div class="checkbox-label">
        <label for="contract">Accept conditions</label>
        <input type="checkbox" id="contract" name="contract" oninvalid="this.setCustomValidity('Only Loninput="this.setCustomValidity('')" required>
    </div>

    <button type="submit">Save data</button>
    <noscript>
        <p style="color: red; font-weight: bold; text-align: center; margin-top: 20px;">Please enable JavaScript in your browser, some features may not work properly.</p>
    </noscript>
</form>
<form action="/lab8/logout.php">
    <button type="submit">Sign Out</button>
</form>
</body>
</html>
