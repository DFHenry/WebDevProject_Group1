<?php
    $pageTitle = "Dashboard";
?>

<?php 
    require_once('components/header.php'); 
?>

<?php
if(!isset($_SESSION['id']))
{
    header("Location: login.php");
    exit();
}

$query = "SELECT id, name, category, price FROM menu_items WHERE user_id = ? ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $_SESSION['id']);
if($stmt->execute() == false)
{
    echo "Execute failed: " . $stmt->error;
}
$result = $stmt->get_result();
$menuItems = $result->fetch_all(MYSQLI_ASSOC);
?>


<!-- end of header -->

<h2>Dashboard</h2>

<p>Welcome, <?=$_SESSION['email']?><p>

<h3>Menu Items</h3>

<a href="add-item.php" class="btn btn-primary mb-3">Add New Menu Item</a>

<div class="itemGrid" id="menuItems">
    <?php if(empty($menuItems)) : ?>
        <p>No menu items yet. Add your first one.</p>
    <?php else : ?>
        <ul>
            <?php foreach($menuItems as $item) : ?>
                <li>
                    <a href="item-details.php?id=<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></a>
                    - <?= htmlspecialchars($item['category']) ?>
                    - $<?= number_format($item['price'], 2) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<h3>Catering Options</h3>

<div class="itemGrid" id="cateringItems">
    
</div>

<div id="logout">
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</div>

<!-- beginning of footer -->
<?php include_once('components/footer.php'); ?>