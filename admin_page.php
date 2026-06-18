<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'superadmin') {
    header("Location: index.php");
    exit();
}

include 'config.php';

$search = $_GET['search'] ?? '';
$users = [];

if (!empty($search)) {
    $result = $conn->query("SELECT id, name, email, role FROM users WHERE name LIKE '%$search%' OR email LIKE '%$search%'");
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Admin Dashboard</title>
</head>

<body class="dashboard-body">
    <div class="dashboard">

        <div class="dashboard-header">
            <div class="dashboard-welcome">
                <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>
                <p>You are logged in as <span>Super Admin</span></p>
            </div>
            <div style="display:flex; gap:10px;">
                <button onclick="window.location.href='manage_users.php'">Manage Users</button>
                <button onclick="window.location.href='logout.php'">Logout</button>
            </div>
        </div>

        <div class="search-container">
            <h3 style="margin-bottom:16px; color:#333;">Search Users</h3>
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Search by name or email..."
                    value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit">Search</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Account Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($search)): ?>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user['id']; ?></td>
                                    <td><?= $user['name']; ?></td>
                                    <td><?= $user['email']; ?></td>
                                    <td><span class="badge badge-<?= $user['role']; ?>"><?= $user['role']; ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="no-results">No users found</td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>