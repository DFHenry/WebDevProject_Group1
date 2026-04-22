<?php 
  $pageTitle = "Catering Order Details | Three Dudes Bakery";
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
    header("Location: dashboard.php"); // Redirect to dashboard if the catering order ID is not provided or is not a valid number
    exit();
  }
?>

<?php
// get catering orders for the logged-in user from database
$query = 'SELECT id, event_date, guest_count, event_type, is_delivery, delivery_address, special_instructions, order_status FROM catering_orders WHERE user_id = ? AND id = ? LIMIT 1';
$stmt = $db->prepare($query); 
$userId = intval($_SESSION['id']);
$orderId = intval($_GET['id']);
$stmt->bind_param('ii', $userId, $orderId);
if($stmt->execute() == false)
  {
    echo "Execute failed: " . $stmt->error;
  }
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);

if(empty($items)) {
    header("Location: dashboard.php"); // Redirect to dashboard if the catering order is not found
    exit();
}

$item = $items[0]; // Extract the single catering order from the array
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $item['id'] ?></li>
  </ol>
</nav>

<h1 class="mb-3"><?= $item['id'] ?></h1>

<div class="d-flex gap-2 mb-3 flex-wrap">
  <a href="update-catering.php?id=<?= $item['id'] ?>" class="btn btn-secondary">Edit Catering Order</a>
  <a href ="delete-catering.php?id=<?= $item['id'] ?>" class="btn btn-danger">Delete Catering Order</a>
</div>


<?php require_once('components/footer.php'); ?>