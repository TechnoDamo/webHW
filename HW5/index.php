<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
<?php if (isset($user)): ?>

    <h1>Admin: <?= htmlspecialchars($user["name"]) ?></h1>
    <form action="index1.php" method="post">
        <div class = "row">
            <div class = "col-25">
                <label for="name" >Name:</label>
            </div>
            <div class = "col-75">
                <input
                        type="text"
                        name = "name"
                        placeholder="your name"
                        class="input input-alt"
                        type="text"
                        value = "<?php
                        if (isset($_COOKIE['name_value'])) {
                            print $_COOKIE["name_value"];
                        }
                        ?>"
                />
                <span class="input-border input-border-alt"></span>
                <?php
                if (isset($_COOKIE['name_error'])) {
                    echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
                    echo $_COOKIE['name_error'];
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-25">
                <label for="phone">Phone:</label>
            </div>
            <div class="col-75">
                <input
                        type="text"
                        placeholder="your phone"
                        class="input input-alt"
                        type="text" name="phone"  value =
                        "<?php
                        if (isset($_COOKIE['phone_value'])) {
                            print $_COOKIE["phone_value"];
                        }
                        ?>"
                />
                <span class="input-border input-border-alt"></span>
                <?php
                if (isset($_COOKIE['phone_error'])) {
                    echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
                    echo $_COOKIE['phone_error'];
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <br><br>

        <div class="row">
            <div class="col-25">
                <label for="email">E-mail:</label>
            </div>
            <div class="col-75">
                <input
                        type="text"
                        class="input input-alt"
                        name="email" type="text" placeholder="your email" value =
                        "<?php
                        if (isset($_COOKIE['email_value'])) {
                            print $_COOKIE["email_value"];
                        }
                        ?>"
                />
                <?php
                if (isset($_COOKIE['email_error'])) {
                    echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
                    echo $_COOKIE['email_error'];
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <br><br>

        <div class="row">
            <div class="col-25">
                <label for="birthdate">Birthday date:</label>
            </div>
            <div class="col-75">
                <input type="date" name="date" value =
                "<?php
                if (isset($_COOKIE['date_value'])) {
                    print $_COOKIE["date_value"];
                }
                ?>" />
                <?php
                if (isset($_COOKIE['date_error'])) {
                    echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
                    echo $_COOKIE['date_error'];
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <br><br>

        <div class="row">
            <div class="col-25">
                <label>Gender:</label><br>
            </div>
            <div class="col-75">
                <input type="radio" name="gender" value = "male" <?php if (!empty($_COOKIE['gender_value']) && $_COOKIE['gender_value'] == 'male') { echo 'checked'; } ?>>
                <label for="male">Male</label><br>
                <input type="radio" name="gender" value = "female" <?php if (!empty($_COOKIE['gender_value']) && $_COOKIE['gender_value'] == 'female') { echo 'checked'; } ?>>
                <label for="female">Female</label><br>
            </div>
        </div>
        <?php
        if (isset($_COOKIE['gender_error'])) {
            echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
            echo $_COOKIE['gender_error'];
            echo '</div>';
        }
        ?>
        <br><br>

        <div class="row">
            <div class="col-25">
                <label for="progLang">Favourite programming languages:</label><br>
            </div>
            <div class="col-75">
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
            </div>
        </div>

        <br><br>

        <div class="row">
            <div class="col-25">
                <label for="bio">Bio:</label><br>
            </div>
            <div class = 'form-control'>
                <div class="col-75">
                    <textarea  class="input input-alt"  name="bio" placeholder="tell about yourself" rows="5" cols="40"><?php if (isSet($_COOKIE['bio_value'])) {print $_COOKIE["bio_value"];} ?></textarea>
                    <?php
                    if (isset($_COOKIE['bio_error'])) {
                        echo '<div style="font-size: small; color: red; margin-bottom: -20px; ">';
                        echo $_COOKIE['bio_error'];
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>

        </div>

        <br><br>


        <div class="row">
            <div class = "col-25"></div>
            <div class = "col-75">
                <label for="contract">Accept the conditions</label><br>
                <input name = "contract"  type="checkbox" <?php if (isset($_COOKIE['contract_value'])) {print 'checked';} ?>>
                <div class="checkmark"></div>
                <?php
                if (isset($_COOKIE['contract_error'])) {
                    echo '<div style="font-size: small; color: red; margin-top: 1px; margin-bottom: 10px; ">';
                    echo $_COOKIE['contract_error'];
                    echo '</div>';
                }
                ?>
            </div>

        </div>

        <div class="row">
            <div class = "col-75"></div>
            <div class = "col-25">
                <button type = "submit" value = "Save">Save</button>
                <!--<input type="submit" value="Save"> -->
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
            </div>
        </div>

    </form>
<p><a href="logout.php">Log out</a></p>
<?php else: ?>
    <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
<?php endif; ?>

</body>
</html>










