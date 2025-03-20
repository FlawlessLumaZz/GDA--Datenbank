<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username == "admin" && $password == "passwort123") { // Testzugang
        $_SESSION["user"] = $username;
        header("Location: startseite.html");
        exit();
    } else {
        $error = "Falsche Login-Daten!";
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Benutzername" required><br>
        <input type="password" name="password" placeholder="Passwort" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
<?php
session_start();
include "db.php"; // Verbindung zur Datenbank

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && hash("sha256", $password) == $user["password"]) {
        $_SESSION["user"] = $user["username"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["permissions"] = json_decode($user["permissions"], true);
        header("Location: startseite.html");
        exit();
    } else {
        $error = "Falsche Login-Daten!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Benutzername" required><br>
        <input type="password" name="password" placeholder="Passwort" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
