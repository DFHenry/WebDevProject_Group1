<?php 
    $pageTitle = "Update Catering Order | Three Dudes Bakery";
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
// get catering orders for the logged-in user from database
$query = 'SELECT order_id, event_date, 
          guest_count, event_type, 
          is_delivery, delivery_address, 
          special_instructions, order_status 
          FROM catering_orders WHERE order_id = ? LIMIT 1';
$stmt = $db->prepare($query); 
$userId = intval($_SESSION['id']);
$orderId = intval($_GET['id']);
$stmt->bind_param('i', $orderId);
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

// end of menu item authentication and retrieval logic

$item = $items[0]; // Extract the single menu item from the array

//var_dump($item);

if(isset($_POST['submit']))
{

  $isValid = true;
  if(empty($_POST['event_date']) || empty($_POST['guest_count']) || empty($_POST['event_type']) || empty($_POST['order_status']))
  {
    $isValid = false;
  }


  if($isValid)
  {
    $orderId = intval($_GET['id']);
    $eventDate = trim($_POST['event_date']);
    $guestCount = intval($_POST['guest_count']);
    $eventType = trim($_POST['event_type']);
    $isDelivery = intval($_POST['is_delivery']) ? 1 : 0;
    $deliveryAddress = trim($_POST['delivery_address']);
    $specialInstructions = trim($_POST['special_instructions']);
    $orderStatus = trim($_POST['order_status']);
    $query = "UPDATE catering_orders 
            SET event_date = ?, 
            guest_count = ?, event_type = ?, is_delivery = ?, 
            delivery_address = ?, special_instructions = ?, 
            order_status = ? WHERE order_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sisisssi',
      $eventDate,
      $guestCount,
      $eventType,
      $isDelivery,
      $deliveryAddress,
      $specialInstructions,
      $orderStatus,
      $orderId
    );
  if($stmt->execute() == false)
    {
      echo "Execute failed: " . $stmt->error;
    }
  else
    {
      $_SESSION['success'] = "Catering order has been updated successfully!"; // Set a success message in the session
      header("Location: catering-details.php?id=" . $_GET['id']);
      exit();
    }
  }
}
?>

<h1 class="mb-3">Update Catering Order</h1>


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="catering-details.php?id=<?= $item['order_id'] ?>">Order #<?= htmlspecialchars($item['order_id']) ?></a></li>
    <li class="breadcrumb-item active" aria-current="page">Update</li>
  </ol>
</nav>

<div class="mb-3">
  <?php if(isset($isValid) && $isValid == false) : ?>
    <div class="alert alert-danger" role="alert"> <!-- Bootstrap alert class for error messages -->
      Please fill in all required fields correctly.
    </div>
  <?php endif; ?>

  <p>Use the form below to update your catering order.</p>
</div>

<div class="addEditMenuItemBox">
  <form class="card border-0 shadow-sm rounded-3" action="update-catering.php?id=<?= $item['order_id'] ?>" method="post">
    <div>
      <label for="event_date" class="form-label">Event Date:</label>
      <input type="datetime-local" class="form-control" id="event_date" name="event_date" required value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($item['event_date']))) ?>">
    </div>  
    <div>
      <label for="event_type" class="form-label">Event Type:</label> 
      <input type="text" class="form-control" id="event_type" name="event_type" required value="<?= htmlspecialchars($item['event_type']) ?>">
    </div>
    <div>
      <label for="guest_count" class="form-label">Guest Count:</label>
      <input type="number" class="form-control" id="guest_count" name="guest_count" step="1" min="1" required value="<?= htmlspecialchars($item['guest_count']) ?>">
    </div>

    <div>
      <label for="order_status" class="form-label">Order Status:</label>
      <input type="text" class="form-control" id="order_status" name="order_status" required value="<?= htmlspecialchars($item['order_status']) ?>">
    </div>
      <input type="hidden" name="is_delivery" value="0">
      <label for="is_delivery" class="form-label">Requires Delivery?</label>
      <input type="checkbox" class="form-check-input" id="is_delivery" name="is_delivery" value="1">
    <div>
      <label for="delivery_address" class="form-label mt-2">Delivery Address (if applicable):</label>
      <input type="text" class="form-control" id="delivery_address" name="delivery_address" value="<?= $item['delivery_address'] ?>">
    </div>
    <div>
      <label for="special_instructions" class="form-label">Special Instructions:</label>
      <textarea class="form-control" id="special_instructions" name="special_instructions" rows="5"><?= htmlspecialchars($item['special_instructions']) ?></textarea>
    </div>
    <div>
      <input type="submit" class="btn btn-primary" value="Update Catering Order" name="submit">
    </div>
  </form>
</div>

<?php require_once('components/footer.php'); ?>