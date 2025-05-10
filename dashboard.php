<?php include 'includes/auth.php'; include 'config.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container mt-4">
    <h3>Welcome, <?= $_SESSION['user'] ?>!</h3>

    <form action="upload.php" method="POST" enctype="multipart/form-data" class="mb-4">
    <div class="mb-3">
        <label>File Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Category</label>
        <select name="category" class="form-select mt-2" required>
            <option value="">Select Category</option>
            <option value="Registration Documents">Registration Documents</option>
            <option value="Standard Agreement Drafts">Standard Agreement Drafts</option>
            <option value="Forms">Forms</option>
            <option value="Others">Others</option>
        </select>
    </div>
    <div class="mb-3">
        <label>Select file to upload</label>
        <input type="file" name="file" class="form-control" required>
    </div>
    <button class="btn btn-success">Upload</button>
</form>


   <h4>Your Uploaded Files</h4>
<table class="table table-bordered">
    <thead>
        <tr><th>#</th><th>Title</th><th>File Name</th><th>Category</th><th>Uploaded At</th>
        <?php 
        echo ($_SESSION['role'] == 'superadmin') ? '<th>Action</th>' :  ''; ?> 
    </tr>
    </thead>
    <tbody>
        <?php
        $res = $conn->query("SELECT * FROM files ORDER BY id DESC");
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['filename']}</td>
                    <td>{$row['category']}</td>
                    <td>{$row['uploaded_at']}</td>"
                    . ( $_SESSION['role'] == 'superadmin' ? "<td><a href='delete.php?id={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
                    <a href='update.php?id={$row['id']}' class='ms-2 btn btn-warning btn-sm'>Update</a>
                    <a href='uploads/{$row['filename']}' class='ms-2 btn btn-primary btn-sm' download>Download</a></td>" : "" ) .
                  "</tr>";
        }
        ?>
    </tbody>
</table>

    <a href="public.php" class="btn btn-outline-info">View Public Page</a>
    <a href="logout.php" class="btn btn-outline-secondary float-end">Logout</a>
</div>
