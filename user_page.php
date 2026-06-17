<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

include 'config.php';

$search = $_GET['search'] ?? '';
$products = [];

if (!empty($search)) {
    $result = $conn->query("SELECT id, name, price, stock FROM products WHERE name LIKE '%$search%'");
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>
</head>

<body class="dashboard-body">
    <div class="dashboard">

        <div class="dashboard-header">
            <div class="dashboard-welcome">
                <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>
                <p>Account type: <span><?= $_SESSION['role']; ?></span></p>
            </div>
            <button onclick="window.location.href='logout.php'">Logout</button>
        </div>

        <div class="search-container">
            <h3 style="margin-bottom:16px; color:#333;">Search Products</h3>
            <form action="" method="GET">
                <input type="text" name="search" placeholder="Search for a product..."
                    value="<?= isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit">Search</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($search)): ?>
                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= $product['id']; ?></td>
                                    <td><?= $product['name']; ?></td>
                                    <td>$<?= $product['price']; ?></td>
                                    <td><?= $product['stock']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="no-results">No products found</td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>

</html>