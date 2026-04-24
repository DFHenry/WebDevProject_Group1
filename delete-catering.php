<?php 
    $pageTitle = "Delete Catering Order";
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
$query = 'SELECT order_id FROM catering_orders WHERE order_id = ? LIMIT 1';
$stmt = $db->prepare($query); 
$userId = intval($_SESSION['id']);
$orderId = intval($_GET['id']);
$stmt->bind_param('i', $orderId);
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

// end of catering order authentication and retrieval logic

$order = $orders[0]; // Extract the single catering order from the array

if(isset($_POST['submit']))
{
    $query = "DELETE FROM catering_orders WHERE order_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i',
        $orderId
    );
    if($stmt->execute() == false)
        {
            echo "Execute failed: " . $stmt->error;
        }
    else
        {
            $_SESSION['success'] = "Catering order has been deleted successfully!"; // Set a success message in the session
            header("Location: dashboard.php");
            exit(); // Redirect to dashboard page after successful deletion and ensure no further code is executed after the redirect
        }
}
?>

<h1>Delete Catering Order</h1>


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="catering-details.php?id=<?= $order['order_id'] ?>">Order #<?= $order['order_id'] ?></a></li>
    <li class="breadcrumb-item active" aria-current="page">Delete</li>
  </ol>
</nav>

<div class="mb-3">
  <p>Use the form below to delete your catering order. This action cannot be undone.</p>
</div>
<form action="delete-catering.php?id=<?= $order['order_id'] ?>" method="post">

  <div class="alert alert-danger" role="alert"> 
    Are you sure you want to delete the catering order by id: "<?= htmlspecialchars($order['order_id']) ?>"? This action cannot be undone.
  </div>

  <a href="catering-details.php?id=<?= $order['order_id'] ?>" class="btn btn-secondary">Cancel</a>
  <input type="submit" class="btn btn-danger" value="Delete" name="submit">
</form>

<?php require_once('components/footer.php'); ?>