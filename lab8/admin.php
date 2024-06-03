<?php
session_start();

if (!isset($_SESSION['loggedinA']) || $_SESSION['loggedinA'] !== true) {
    header("Location: signin.html");
    exit();
}
$_SESSION['loggedin'] = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Table with Stylish Logout Button</title>
    <style>/* Styling for the table */
        /* Styling for the table */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            font-size: 0.9em;
            font-family: sans-serif;
        }

        .styled-table thead {
            background-color: #3D9970; /* Green background for the table header */
            color: #fff; /* White text color for the table header */
        }

        .styled-table th, .styled-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        /* Hover effect for table rows */
        .styled-table tbody tr:hover {
            background-color: #f2f2f2; /* Darken the row when hovering over it */
        }

        /* Styling for the logout button */
        .logout-button {
            background-color: #3D9970; /* Green background for the button */
            color: #fff; /* White text color for the button */
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .logout-button:hover {
            background-color: #39CCCC; /* Lighter green background on hover */
        }
    </style>
</head>
<body>
    <?php
    $conn = '';
    require_once 'db_connection.php';
    $stmt = $conn->prepare("SELECT user_id, first_name, last_name, email, birthdate, gender, bio, phone FROM data");

    $stmt->execute();

    $sqlQueryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<table class="styled-table">';
    echo '<thead>';
    echo '<tr>';
    foreach ($sqlQueryResult[0] as $key => $value) {
        echo '<th>' . ucfirst(str_replace('_', ' ', $key)) . '</th>';
    }
    echo '</tr>';
    echo '</thead>';

    echo '<tbody>';
    foreach ($sqlQueryResult as $row) {
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>' . $cell . '</td>';
        }
        echo  '<td>' . '
    <form action = "userEditAdmin.php" method="POST">
        <input type="hidden" name="user_id" value="' . $row['user_id'] . '">
        <button class="logout-button" type = "submit">Edit</button>
    </form>' . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';



    $stmt = $conn->prepare("SELECT d.user_id, d.first_name, d.last_name, u.language_name
FROM data d
JOIN (
    SELECT ul.user_id, pl.language_name
    FROM users_langs ul
    JOIN prog_langs pl ON ul.language_id = pl.language_id
) u ON d.user_id = u.user_id;
");

    $stmt->execute();

    $sqlQueryResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<table class="styled-table">';
    echo '<thead>';
    echo '<tr>';
    foreach ($sqlQueryResult[0] as $key => $value) {
        echo '<th>' . ucfirst(str_replace('_', ' ', $key)) . '</th>';
    }
    echo '</tr>';
    echo '</thead>';

    echo '<tbody>';
    foreach ($sqlQueryResult as $row) {
        echo '<tr>';
        foreach ($row as $cell) {
            echo '<td>' . $cell . '</td>';
        }
        echo  '<td>' . '
    <form action = "userEditAdmin.php" method="POST">
        <input type="hidden" name="user_id" value="' . $row['user_id'] . '">
        <button class="logout-button" type = "submit">Edit</button>
    </form>' . '</td>';        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

    ?>

    <form action = "logout.php">
        <button class="logout-button" type = "submit">Logout</button>
    </form>
</body>
</html>

