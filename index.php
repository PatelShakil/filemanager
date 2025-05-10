<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = hash('sha256', $_POST['password']);
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows) {
        $_SESSION['user'] = $username;
        $role = $conn->query("SELECT role FROM users WHERE username = '$username'")->fetch_assoc();
        $_SESSION['role'] = $role['role'];
        header("Location: dashboard.php");
    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!-- HTML -->
<?php include 'includes/header.php'; ?>
<div class="container mt-5 d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-lg" style="width: 400px;">
        <div class="card-body">
            <h3 class="text-center mb-4">File Manager</h3>
            <hr />
            <h3 class="text-center mb-4">Login</h3>
            <form method="POST">
                <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Enter your username" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                </div>
                <button class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>

<!-- Include Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
