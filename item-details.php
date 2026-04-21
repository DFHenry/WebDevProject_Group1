<?php 
    $pageTitle = "Menu Item Details | Three Dudes Bakery";
?>
<?php require_once('components/header.php'); ?>

<?php
if(!isset($_SESSION['id']))
    {
        header("Location: login.php"); // Redirect to login page if the user is not authenticated
        exit();
    }

if(!isset($_GET['id']) || !is_numeric($_GET['id']))
    {
        header("Location: dashboard.php"); // Redirect to dashboard if the blog post ID is not provided or is not a valid number
        exit();
    }
?>

<?php
// get menu items for the logged-in user from database
$query = 'SELECT id, name, description, price, category, image_href, date_created FROM menu_items WHERE user_id = ? AND id = ? LIMIT 1';
$stmt = $db->prepare($query); 
$userId = intval($_SESSION['id']);
$itemId = intval($_GET['id']);
$stmt->bind_param('ii', $userId, $itemId);
if($stmt->execute() == false)
    {
        echo "Execute failed: " . $stmt->error;
    }
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);

if(empty($items)) {
    header("Location: dashboard.php"); // Redirect to dashboard if the menu item is not found
    exit();
}

$item = $items[0]; // Extract the single menu item from the array
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($item['name']) ?></li>
  </ol>
</nav>

<h1 class="mb-3"><?= htmlspecialchars($item['name']) ?></h1>
<ul class="list-group list-group-flush mb-3">
    <li>Date Added: <?= $item['date_created'] ?></li>
    <li>Category: <?= htmlspecialchars($item['category']) ?></li>
    <li>Price: $<?= number_format($item['price'], 2) ?></li>
</ul>

<div class="d-flex gap-2 mb-3 flex-wrap">
    <a href="update-item.php?id=<?= $item['id'] ?>" class="btn btn-secondary">Edit Menu Item</a>
    <a href ="delete-item.php?id=<?= $item['id'] ?>" class="btn btn-danger">Delete Menu Item</a>
</div>


<hr />

<?php if(!empty($item['image_href'])) : ?>
    <img src="<?= htmlspecialchars($item['image_href']) ?>" alt="Menu Item Thumbnail" class="img-fluid rounded shadow-sm" style="max-width: 100%; height: auto; max-height: 500px; display: block;">

<?php endif; ?>

<p class="mt-3"><?= nl2br(htmlspecialchars($item['description'])) ?></p>

<?php require_once('components/footer.php'); ?>