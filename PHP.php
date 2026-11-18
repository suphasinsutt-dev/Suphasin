
<?php
$config = require '/etc/my-online-store/config.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4",
        $config['username'],
        $config['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $stmt = $pdo->query(
        "SELECT name, price FROM products ORDER BY id"
    );

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Database connection error');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>MY ONLINE STORE</title>

<style>
* { box-sizing: border-box; }

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #faf7f2;
    color: #33281f;
}

nav {
    background: #fffdf9;
    padding: 25px 6%;
    font-size: 24px;
    font-weight: bold;
    border-bottom: 1px solid #eee6dc;
}

header {
    text-align: center;
    padding: 55px 15px 35px;
}

header h1 {
    font-size: 42px;
    margin: 0;
}

header p {
    letter-spacing: 5px;
    color: #857467;
}

.products {
    max-width: 1150px;
    margin: auto;
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}

.card {
    background: white;
    padding: 12px;
    border-radius: 18px;
    box-shadow: 0 5px 20px #00000012;
}

.photo {
    height: 300px;
    border-radius: 12px;
    background: #f7f3e9;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 72px;
}

.info { padding: 15px; }
.info h2 { margin: 5px 0; }

.price {
    color: #9b7559;
    font-size: 23px;
    font-weight: bold;
}

footer {
    text-align: center;
    padding: 35px;
    margin-top: 40px;
    background: #efe9e2;
}

@media(max-width: 700px) {
    .products {
        grid-template-columns: 1fr;
    }
    header h1 { font-size: 30px; }
}
</style>
</head>

<body>

<nav>MY ONLINE STORE</nav>

<header>
    <h1>MY ONLINE STORE</h1>
    <p>PRODUCT CATALOG</p>
</header>

<div class="products">

<?php foreach ($products as $product): ?>
    <div class="card">
        <div class="photo">👕</div>

        <div class="info">
            <h2>
                <?= htmlspecialchars(
                    $product['name'],
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </h2>

            <p class="price">
                <?= number_format($product['price'], 0) ?>
                THB
            </p>
        </div>
    </div>
<?php endforeach; ?>

</div>

<footer>
    MY ONLINE STORE |
    Powered by Amazon EC2 + RDS
</footer>

</body>
</html>
