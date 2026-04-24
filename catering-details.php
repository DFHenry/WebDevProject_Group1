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
// get catering orders from database catering_orders table
$query = 'SELECT id, event_date, guest_count, event_type, 
        is_delivery, delivery_address, special_instructions, order_status 
        FROM catering_orders WHERE user_id = ? AND id = ? LIMIT 1';
$stmt = $db->prepare($query); 
$userId = intval($_SESSION['id']);
$orderId = intval($_GET['id']);
$stmt->bind_param('ii', $userId, $orderId);
if($stmt->execute() == false)
  {
    echo "Execute failed: " . $stmt->error;
  }
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);

if(empty($orders)) {
    header("Location: dashboard.php"); // Redirect to dashboard if the catering order is not found
    exit();
}

$order = $orders[0]; // Extract the single catering order from the array


// get catering items for the order from database catering_order_items table
$query = 'SELECT * FROM catering_order_items 
          INNER JOIN menu_items ON catering_order_items.item_id = menu_items.id
          WHERE order_id = ?';
$stmt = $db->prepare($query);
$stmt->bind_param('i', $orderId);
if($stmt->execute() == false)
  {
    echo "Execute failed: " . $stmt->error;
  }
$result = $stmt->get_result();
$cateringItems = $result->fetch_all(MYSQLI_ASSOC);

?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?= $order['id'] ?></li>
  </ol>
</nav>

<h1 class="mb-3">Order #<?= $order['id'] ?></h1>

<h2>Catering Items</h2>

<?php if(empty($cateringItems)) : ?>
  <p>No items have been added to this catering order yet.</p>
<?php else : ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Menu Item Name</th>
        <th>Price @ Booking</th>
        <th>Quantity</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($cateringItems as $cateringItem) : ?>
        <tr>
          <td><?= htmlspecialchars($cateringItem['name']) ?></td>
          <td>$<?= htmlspecialchars(number_format($cateringItem['price_at_booking'], 2)) ?></td>
          <td><?= htmlspecialchars($cateringItem['quantity']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

  <a href="add-catering-items.php?id=<?= $_GET['id'] ?>" class="btn btn-success">Add Catering Items</a>


<h2>Order Details</h2>
<table>
  <tr>
    <th>Event Date</th>
    <td><?= htmlspecialchars(date('F j, Y, g:i A', strtotime($order['event_date']))) ?></td>
  </tr>
  <tr>
    <th>Guest Count</th>
    <td><?= htmlspecialchars($order['guest_count']) ?></td>
  </tr>
  <tr>
    <th>Event Type</th>
    <td><?= htmlspecialchars($order['event_type']) ?></td>
  </tr>
  <tr>
    <th>Delivery</th>
    <td><?= $order['is_delivery'] ? 'Yes' : 'No' ?></td>
  </tr>
  <?php if($order['is_delivery']): ?>
  <tr>
    <th>Delivery Address</th>
    <td><?= htmlspecialchars($order['delivery_address']) ?></td>
  </tr>
  <?php endif; ?>
  <tr>
    <th>Special Instructions</th>
    <td><?= nl2br(htmlspecialchars($order['special_instructions'])) ?></td>
  </tr>
  <tr>
    <th>Order Status</th>
    <td><?= htmlspecialchars($order['order_status']) ?></td>
  </tr>
</table>

<div class="d-flex gap-2 mb-3 flex-wrap">
  <a href="update-catering.php?id=<?= $order['id'] ?>" class="btn btn-secondary">Edit Catering Order</a>
  <a href ="delete-catering.php?id=<?= $order['id'] ?>" class="btn btn-danger">Delete Catering Order</a>
</div>


<?php require_once('components/footer.php'); ?>