<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .credentials-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .credentials-container h2 {
            margin-bottom: 20px;
        }
        .credentials {
            margin-bottom: 15px;
        }
        .credentials p {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
            display: inline-block;
        }
        .eye-icon {
            cursor: pointer;
        }
        .show-password-btn {
            padding: 16px 30px;
            border: none;
            border-radius: 10px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .show-password-btn:hover {
            background-color: #45a049;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form h2 {
            text-align: center;
        }

        form div {
            margin-bottom: 10px;
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input, form select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
        }

        form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        form button:hover {
            background-color: #45a049;
        }
    </style>
    <title>Username and Password</title>
</head>
<body>
<div class="credentials-container">
    <h2>User Credentials</h2>
    <div class="credentials">
        <p>Username: <?php session_start(); echo "user".$_SESSION['user_id']?></p>
    </div>
    <div class="credentials">
        <p>Password: <span id="password">****</span></p>
        <noscript>
            <br/>
            <?php session_start(); echo "Password: ".$_SESSION['password']?>
            <br/>
            <p style="color: red; font-weight: bold; text-align: center; margin-top: 20px;">Please enable JavaScript in your browser, some features may not work properly.</p>
        </noscript>
    </div>
    <button class = "show-password-btn" onclick = "togglePassword()">show/hide password</button>
    <div style = "margin-top: 10px">
        <form action = "signin.html">
            <button type="submit">Sign In</button>
        </form>
    </div>
</div>


<script>
    function togglePassword() {
        var passwordField = document.getElementById('password');
        if (passwordField.innerHTML === '****') {
            // Use AJAX to retrieve the password from the server
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    passwordField.innerHTML = this.responseText;
                }
            };
            xhr.open('GET', 'get_password.php', true);
            xhr.send();
        } else {
            passwordField.innerHTML = '****';
        }
    }
</script>
</body>
</html>
