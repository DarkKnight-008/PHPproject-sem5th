<?php
require 'db.php';

$msg = "";
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === "added") $msg = "Note added successfully.";
    elseif ($_GET['msg'] === "updated") $msg = "Note updated successfully.";
    elseif ($_GET['msg'] === "deleted") $msg = "Note deleted successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>iNotes CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//cdn.datatables.net/2.3.3/css/dataTables.dataTables.min.css" />
</head>
<body>
<!-- navbar starts -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">i-Notes</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" disabled>
                <button class="btn btn-outline-primary" type="submit" disabled>Search</button>
            </form>
        </div>
    </div>
</nav>
<!-- navbar ends -->

<div class="container mt-4">
    <?php if ($msg): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($msg); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Add Note Form -->
    <div class="card mb-4">
        <div class="card-header">Add a New Note</div>
        <div class="card-body">
            <form action="process.php" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Note Title</label>
                    <input required class="form-control" id="title" name="notetitle" />
                </div>
                <div class="mb-3">
                    <label for="desc" class="form-label">Note Description</label>
                    <textarea required class="form-control" id="desc" name="notedesc" rows="3"></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Add Note</button>
            </form>
        </div>
    </div>

    <!-- Notes Table -->
    <table class="table table-striped" id="notesTable">
        <thead>
            <tr><th>Sno</th><th>Title</th><th>Description</th><th>Actions</th></tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        $result = $conn->query("SELECT * FROM notes");
        while ($row = $result->fetch_assoc()):
        ?>
            <tr>
                <th><?php echo $i++; ?></th>
                <td><?php echo htmlspecialchars($row['note title']); ?></td>
                <td><?php echo htmlspecialchars($row['note description']); ?></td>
                <td>
                    <button class="btn btn-success btn-sm editBtn" data-id="<?php echo $row['sno']; ?>" data-title="<?php echo htmlspecialchars($row['note title']); ?>" data-desc="<?php echo htmlspecialchars($row['note description']); ?>">Edit</button>
                    <button class="btn btn-danger btn-sm delBtn" data-id="<?php echo $row['sno']; ?>">Delete</button>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editNoteModal" tabindex="-1" aria-labelledby="editNoteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="process.php" method="post" class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editNoteModalLabel">Edit Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="snoedit" id="editSno" />
            <div class="mb-3">
                <label for="editTitle" class="form-label">Note Title</label>
                <input required type="text" id="editTitle" name="notetitleEdit" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="editDesc" class="form-label">Note Description</label>
                <textarea required id="editDesc" name="notedescEdit" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Update Note</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.datatables.net/2.3.3/js/dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#notesTable').DataTable();

    // Use delegated event handlers for pagination compatibility
    $('#notesTable tbody').on('click', '.editBtn', function() {
        const sno = $(this).data('id');
        const title = $(this).data('title');
        const desc = $(this).data('desc');

        $('#editSno').val(sno);
        $('#editTitle').val(title);
        $('#editDesc').val(desc);
        var editModal = new bootstrap.Modal(document.getElementById('editNoteModal'));
        editModal.show();
    });

    $('#notesTable tbody').on('click', '.delBtn', function() {
        const sno = $(this).data('id');
        if (confirm("Are you sure you want to delete this note?")) {
            window.location.href = 'process.php?delete=' + sno;
        }
    });
});
</script>
</body>
</html>
