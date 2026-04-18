<?php 
    session_start();
    if(!isset($_SESSION['id']))
    {
        header("Location: login.php"); // Redirect to login page if the user is not authenticated
        exit();
    }
    
    if(!isset($_GET['id']) || !is_numeric($_GET['id']))
    {
        header("Location: dashboard.php"); // Redirect to dashboard if the menu item ID is not provided or is not a valid number
        exit();
    }

    $pageTitle = "Delete Menu Item";
?>
<?php require_once('components/header.php'); ?>

<?php

// get menu items for the logged-in user from database
$query = 'SELECT id, name FROM menu_items WHERE user_id = ? AND id = ? LIMIT 1';
$stmt = $db->prepare($query); 
$stmt->bind_param('ii', $_SESSION['id'], $_GET['id']);
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

if(isset($_POST['submit']))
{
    $query = "DELETE FROM menu_items WHERE id = ? AND user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ii',
        $_GET['id'],
        $_SESSION['id']
    );
    if($stmt->execute() == false)
        {
            echo "Execute failed: " . $stmt->error;
        }
    else
        {
            $_SESSION['success'] = "Menu item has been deleted successfully!"; // Set a success message in the session
            header("Location: dashboard.php");
            exit(); // Redirect to dashboard page after successful deletion and ensure no further code is executed after the redirect
        }
}
?>

<h1>Delete Menu Item</h1>


<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="item-details.php?id=<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></a></li>
    <li class="breadcrumb-item active" aria-current="page">Delete</li>
  </ol>
</nav>

<div class="mb-3">
    <p>Use the form below to delete your menu item. This action cannot be undone.</p>
</div>
<form action="delete-item.php?id=<?= $item['id'] ?>" method="post">

    <div class="alert alert-danger" role="alert"> 
        Are you sure you want to delete the menu item titled "<?= htmlspecialchars($item['name']) ?>"? This action cannot be undone.
    </div>

    <a href="item-details.php?id=<?= $item['id'] ?>" class="btn btn-secondary">Cancel</a>
    <input type="submit" class="btn btn-danger" value="Delete" name="submit">
</form>

<?php require_once('components/footer.php'); ?>