<?php
include 'includes/auth.php'; // Ensure the user is authenticated
include 'config.php'; // Include database connection

// Check if the 'id' parameter is provided in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request. No file ID provided.");
}

$file_id = intval($_GET['id']);

// Fetch the file details from the database
$query = $conn->prepare("SELECT * FROM files WHERE id = ?");
$query->bind_param("i", $file_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    die("File not found.");
}

$file = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category = $_POST['category'];
    $new_filename = $file['filename']; // Default to the current filename

    // Check if a new file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $new_filename = time() . '_' . basename($_FILES['file']['name']);
        $upload_path = $upload_dir . $new_filename;

        // Move the uploaded file to the uploads directory
        if (!move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
            die("Failed to upload the file.");
        }

        // Optionally, delete the old file
        $old_file_path = $upload_dir . $file['filename'];
        if (file_exists($old_file_path)) {
            unlink($old_file_path);
        }
    }

    // Update the database with the new details
    $update_query = $conn->prepare("UPDATE files SET title = ?, category = ?, filename = ? WHERE id = ?");
    $update_query->bind_param("sssi", $title, $category, $new_filename, $file_id);

    if ($update_query->execute()) {
        header("Location: dashboard.php?success=File updated successfully");
        exit;
    } else {
        die("Failed to update the file.");
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <h3>Update File</h3>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>File Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($file['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Category</label>
            <select name="category" class="form-select" required>
                <option value="">Select Category</option>
                <option value="Registration Documents" <?= $file['category'] === 'Registration Documents' ? 'selected' : '' ?>>Registration Documents</option>
                <option value="Standard Agreement Drafts" <?= $file['category'] === 'Standard Agreement Drafts' ? 'selected' : '' ?>>Standard Agreement Drafts</option>
                <option value="Forms" <?= $file['category'] === 'Forms' ? 'selected' : '' ?>>Forms</option>
                <option value="Others" <?= $file['category'] === 'Others' ? 'selected' : '' ?>>Others</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Current File</label>
            <p><?= htmlspecialchars($file['filename']) ?></p>
        </div>
        <div class="mb-3">
            <label>Upload New File (optional)</label>
            <input type="file" name="file" class="form-control">
        </div>
        <button class="btn btn-primary">Update</button>
        <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

