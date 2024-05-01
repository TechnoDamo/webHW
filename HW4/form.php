<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HW4</title>
</head>
<body>

<form action="index.php" method="post">
    <label for="name" >Name:</label>
    <input name="name" value =
    "<?php
    if (isSet($_COOKIE['name_value'])) {
        print $_COOKIE["name_value"];
    }
    ?>">
    <?php
    if (isSet($_COOKIE['name_error'])) {
        echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
        echo $_COOKIE['name_error'];
        echo '</div>';
    }
    ?>
    <br><br>
    <label for="phone">Phone:</label>
    <input type = "tel" name="phone" value =
    "<?php
    if (isSet($_COOKIE['phone_value'])) {
        print $_COOKIE["phone_value"];
    }
    ?>">
    <?php
    if (isSet($_COOKIE['phone_error'])) {
        echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
        echo $_COOKIE['phone_error'];
        echo '</div>';
    }
    ?>
    <br><br>

    <label for="email">E-mail:</label>
    <input name="email" value =
    "<?php
    if (isSet($_COOKIE['email_value'])) {
        print $_COOKIE["email_value"];
    }
    ?>">
    <?php
    if (isSet($_COOKIE['email_error'])) {
        echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
        echo $_COOKIE['email_error'];
        echo '</div>';
    }
    ?>
    <br><br>

    <label for="birthdate">Birthday date:</label>
    <input type="date" name="date" value =
    "<?php
    if (isSet($_COOKIE['date_value'])) {
        print $_COOKIE["date_value"];
    }
    ?>" />
    <?php
    if (isSet($_COOKIE['date_error'])) {
        echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
        echo $_COOKIE['date_error'];
        echo '</div>';
    }
    ?>
    <br><br>

    <label>Gender:</label><br>
    <input type="radio" name="gender" value = "male" <?php if (!empty($_COOKIE['gender_value']) && $_COOKIE['gender_value'] == 'male') { echo 'checked'; } ?>>
    <label for="male">Male</label><br>
    <input type="radio" name="gender" value = "female" <?php if (!empty($_COOKIE['gender_value']) && $_COOKIE['gender_value'] == 'female') { echo 'checked'; } ?>>
    <label for="female">Female</label><br>
    <?php
    if (isSet($_COOKIE['gender_error'])) {
        echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
        echo $_COOKIE['gender_error'];
        echo '</div>';
    }
    ?>
    <br><br>

    <label for="progLang">Favourite programming languages:</label><br>
    <select name="progLang[]" multiple>
        <option value="pascal" <?php if (!empty($_COOKIE['langs_value']) && in_array('pascal', unserialize($_COOKIE['langs_value']))) { echo 'selected'; } ?>>Pascal</option>
        <option value="c"<?php if (!empty($_COOKIE['langs_value']) && in_array('c', unserialize($_COOKIE['langs_value']))) { echo 'selected'; } ?>>C</option>
        <option value="c++"<?php if (!empty($_COOKIE['langs_value']) && in_array('c++', unserialize($_COOKIE['langs_value']))) { echo 'selected'; } ?>>C++</option>
        <option value="js"<?php if (!empty($_COOKIE['langs_value']) && in_array('js', unserialize($_COOKIE['langs_value']))) { echo 'selected'; } ?>>JavaScript</option>
        <option value="php"<?php if (!empty($_COOKIE['langs_value']) && in_array('php', unserialize($_COOKIE['langs_value']))) { echo 'selected'; } ?>>PHP</option>
        <option value="python"<?php if (!empty($_COOKIE['langs_value']) && in_array('python', unserialize($_COOKIE['langs_value']))) { echo 'selected'; } ?>>Python</option>
        <option value="java"<?php if (!empty($_COOKIE['langs_value']) && in_array('java', unserialize($_COOKIE['langs_value']))) { echo 'selected'; } ?>>Java</option>
        <option value="haskel"<?php if (!empty($_COOKIE['langs_value']) && in_array('haskel', unserialize($_COOKIE['langs_value']))) { echo 'selected'; } ?>>Haskel</option>
        <option value="clojure"<?php if (!empty($_COOKIE['langs_value']) && in_array('clojure', unserialize($_COOKIE['langs_value']))) { echo 'selected'; } ?>>Clojure</option>
        <option value="prolog"<?php if (!empty($_COOKIE['langs_value']) && in_array('prolog', unserialize($_COOKIE['langs_value']))) { echo 'selected'; } ?>>Prolog</option>
        <option value="scala"<?php if (!empty($_COOKIE['langs_value']) && in_array('scala', unserialize($_COOKIE['langs_value']))) { echo 'selected'; } ?>>Scala</option>
    </select>
    <?php
    if (isSet($_COOKIE['langs_error'])) {
        echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
        echo $_COOKIE['langs_error'];
        echo '</div>';
    }
    ?>
    <br><br>

    <label for="bio">Bio:</label><br>
    <textarea name="bio" rows="5" cols="40"><?php if (isSet($_COOKIE['bio_value'])) {print $_COOKIE["bio_value"];} ?></textarea>
    <?php
    if (isSet($_COOKIE['bio_error'])) {
        echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
        echo $_COOKIE['bio_error'];
        echo '</div>';
    }
    ?>
    <br><br>


    <input type="checkbox" name="contract" <?php if (isset($_COOKIE['contract_value'])) {print 'checked';} ?>>
    <label for="contract">Accept the conditions</label><br><br>
    <?php
    if (isset($_COOKIE['contract_error'])) {
        echo '<div style="font-size: small; color: red; margin-top: -20px; margin-bottom: 10px; ">';
        echo $_COOKIE['contract_error'];
        echo '</div>';
    }
    ?>
    <input type="submit" value="Save">
    <?php
    if (isset($_COOKIE['save_error'])) {
        echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
        echo $_COOKIE['save_error'];
        echo '</div>';
    }
    else if (isset($_COOKIE['save'])){
        echo '<div style="font-size: small; color: green; margin-bottom: -20px; ">';
        echo $_COOKIE['save'];
        echo '</div>';
    }
    ?>
</form>

</body>
</html>
