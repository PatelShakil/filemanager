<?php include 'config.php'; include 'includes/header.php'; ?>
<div class="container mt-4">
    <h3>Public Files</h3>
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label>Category</label>
            <select name="category" class="form-select mt-2">
                <option value="">Select Category</option>
                <option value="Standard Agreement Drafts">Standard Agreement Drafts</option>
                <option value="Forms">Forms</option>
            </select>
        </div>
        <button class="btn btn-primary">Filter</button>
        <a href="public.php" class="btn btn-secondary">Reset</a>
    </form>
<table class="table table-striped">
    <thead><tr><th>#</th><th>Title</th><th>File</th><th>Category</th><th>Download</th></tr></thead>
    <tbody>
        <?php
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    if ($category) {
        $query = "SELECT * FROM files WHERE category = ? AND (category = 'Standard Agreement Drafts' OR category = 'Forms') ORDER BY id DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $category);
    } else {
        $query = "SELECT * FROM files WHERE category IN ('Standard Agreement Drafts', 'Forms') ORDER BY id DESC";
        $stmt = $conn->prepare($query);
    }
    $stmt->execute();
    $res = $stmt->get_result();
        if ($category) {
            echo "<h5>Showing results for: $category</h5>";
        }
        if ($res->num_rows == 0) {
            echo "<tr><td colspan='5' class='text-center'>No files found.</td></tr>";
        }
                while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['filename']}</td>
                    <td>{$row['category']}</td>
                    <td><a href='uploads/{$row['filename']}' class='btn btn-primary btn-sm' download>Download</a></td>
                  </tr>";
        }
        ?>
    </tbody>
</table>

</div>
