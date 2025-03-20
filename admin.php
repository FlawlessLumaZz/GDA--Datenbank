<?php
session_start();
include "db.php";

if ($_SESSION["role"] !== "admin") {
    die("Zugriff verweigert!");
}

// Benutzer hinzufügen
if (isset($_POST["add_user"])) {
    $username = $_POST["username"];
    $password = hash("sha256", $_POST["password"]);
    $permissions = json_encode($_POST["permissions"]);
    
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role, permissions) VALUES (?, ?, 'user', ?)");
    $stmt->execute([$username, $password, $permissions]);
}

// Benutzer löschen
if (isset($_POST["delete_user"])) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_POST["user_id"]]);
}

$users = $pdo->query("SELECT * FROM users")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><title>Admin-Bereich</title></head>
<body>
    <h2>Benutzerverwaltung</h2>
    
    <h3>Neuen Benutzer hinzufügen</h3>
    <form method="post">
        <input type="text" name="username" placeholder="Benutzername" required>
        <input type="password" name="password" placeholder="Passwort" required>
        <label>Seiten-Zugriff:</label>
        <select name="permissions[]" multiple>
            <option value="fraktionen.html">Fraktionen</option>
            <option value="razzien.html">Routen & Cooldowns</option>
        </select>
        <button type="submit" name="add_user">Hinzufügen</button>
    </form>

    <h3>Benutzer löschen</h3>
    <form method="post">
        <select name="user_id">
            <?php foreach ($users as $user) { ?>
                <option value="<?= $user["id"] ?>"><?= $user["username"] ?></option>
            <?php } ?>
        </select>
        <button type="submit" name="delete_user">Löschen</button>
    </form>

    <a href="logout.php">Logout</a>
</body>
</html>
