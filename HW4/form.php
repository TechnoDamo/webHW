<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HW4</title>
</head>
<body>
<?php
include '/var/www/html/hw4/index.php';
global $messages, $values, $errors;
if (!empty($messages)) {
    print('<div id="messages">');
    // Выводим все сообщения.
    foreach ($messages as $message) {
        print($message);
    }
    print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>
<form action="index.php" method="post">
    <label for="fio" >FIO:</label>
    <input name="fio" <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php  print $values['fio']; ?>" ><br><br>

    <label for="phone">Phone:</label>
    <input type = "tel" name="phone" <?php if ($errors['phone']) {print 'class="error"';} ?> value="<?php  print $values['phone']; ?>"><br><br>

    <label for="email">E-mail:</label>
    <input type = "email" name="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php  print $values['email']; ?>"><br><br>

    <label for="birthdate">Birthday date:</label>
    <input type="date" name="birthdate" <?php if ($errors['birthdate']) {print 'class="error"';} ?> value="<?php  print $values['birthdate']; ?>"><br><br>

    <label>Gender:</label><br>
    <input type="radio" name="gender" />
    <label for="male">Male</label><br>
    <input type="radio" name="gender" value="female">
    <label for="female">Female</label><br><br>

    <label for="progLang">Favourite programming language:</label><br>
    <select name="progLang[]" multiple>
        <option value="pascal">Pascal</option>
        <option value="c">C</option>
        <option value="c++">C++</option>
        <option value="js">JavaScript</option>
        <option value="php">PHP</option>
        <option value="python">Python</option>
        <option value="java">Java</option>
        <option value="haskel">Haskel</option>
        <option value="clojure">Clojure</option>
        <option value="prolog">Prolog</option>
        <option value="scala">Scala</option>
    </select><br><br>

    <label for="bio">Bio:</label><br>
    <textarea name="bio" rows="5" cols="40" <?php if ($errors['bio']) {print 'class="error"';} ?> value="<?php  print $values['bio']; ?>"></textarea><br><br>

    <input type="checkbox" name="contract">
    <label for="contract">Accept the conditions</label><br><br>
    <input type="submit" value="Save">
</form>

</body>
</html>