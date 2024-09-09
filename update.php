<?php
// update.php
include('connect.php');

$id = $_GET['updateid'];

// Retrieve existing data from database
$stmt = $con->prepare("SELECT * FROM crud WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $con->prepare("UPDATE crud SET name=?, email=?, mobile=?, password=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $email, $mobile, $password, $id);

    if ($stmt->execute()) {
        header("Location:display.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}
?>

<!-- update.html -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</head>
<body>
    <div class="container my-5">
    <form method = "post">
  <div class="form-group">
    <label>Name</label>
    <input type="text" class="form-control" placeholder= "Enter your name" name="name" value="<?php echo $row['name']; ?>" autocomplete="off" >
</div>
<div class="form-group">
    <label>Email</label>
    <input type="email" class="form-control" placeholder= "Enter your email" name="email" value="<?php echo $row['email']; ?>" autocomplete="off">
</div>
<div class="form-group">
    <label>Mobile</label>
    <input type="number" class="form-control" placeholder= "Enter your mobile" name="mobile" value="<?php echo $row['mobile']; ?>" autocomplete="off">
</div>
<div class="form-group">
    <label>Password</label>
    <input type="password" class="form-control" placeholder= "Enter your password" name="password" value="<?php echo $row['password']; ?>" >
</div>
  <button type="submit" class="btn btn-primary" name="submit">Update</button>
</form>
    </div>
</body>
</html>