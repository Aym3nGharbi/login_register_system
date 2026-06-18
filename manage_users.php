<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: index.php");
    exit();
}

include 'config.php';

if (isset($_POST['change_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];
    $conn->query("UPDATE users SET role = '$new_role' WHERE id = '$user_id'");
    header("Location: manage_users.php");
    exit();
}

$result = $conn->query("SELECT id, name, email, role FROM users");
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Manage Users</title>
</head>

<body class="dashboard-body">
    <div class="dashboard">

        <div class="dashboard-header">
            <div class="dashboard-welcome">
                <h1>Manage <span>Users</span></h1>
                <p>Promote or demote user accounts</p>
            </div>
            <button onclick="window.location.href='admin_page.php'">Back to Dashboard</button>
        </div>

        <div class="search-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Current Role</th>
                        <th>Change Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id']; ?></td>
                            <td><?= $user['name']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <td><span class="badge badge-<?= $user['role']; ?>"><?= $user['role']; ?></span></td>
                            <td>
                                <form action="" method="POST" style="display:flex; gap:8px; margin:0;">
                                    <input type="hidden" name="user_id" value="<?= $user['id']; ?>">
                                    <select name="new_role">
                                        <option value="individual" <?= $user['role'] === 'individual' ? 'selected' : ''; ?>>
                                            Individual</option>
                                        <option value="organisation" <?= $user['role'] === 'organisation' ? 'selected' : ''; ?>>Organisation</option>
                                        <option value="superadmin" <?= $user['role'] === 'superadmin' ? 'selected' : ''; ?>>
                                            Super Admin</option>
                                    </select>
                                    <button type="submit" name="change_role">Save</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>