<?php
include 'db_connect.php';

if (isset($_POST['add_field'])) {
    $field_name = $_POST['field_name'];
    $field_type = $_POST['field_type'];

    $conn->query("INSERT INTO phonebook_fields (field_name, field_type) VALUES ('$field_name', '$field_type')");
    header('Location: manage_columns.php');
    exit();
}

if (isset($_POST['edit_field'])) {
    $field_id = $_POST['field_id'];
    $field_name = $_POST['field_name'];
    $field_type = $_POST['field_type'];

    $conn->query("UPDATE phonebook_fields SET field_name='$field_name', field_type='$field_type' WHERE id='$field_id'");
    header('Location: manage_columns.php');
    exit();
}

if (isset($_GET['delete'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM phonebook_fields WHERE id='$id'");
    header('Location: manage_columns.php');
    exit();
}

$fields_result = $conn->query("SELECT * FROM phonebook_fields");
$editing_field_id = isset($_GET['edit']) ? intval($_GET['edit']) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Columns</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Manage Columns</h1>
        
        <!-- Button to trigger modal for adding a new column -->
        <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#addColumnModal">
            Add Column
        </button>

        <!-- Modal for adding new column -->
        <div class="modal fade" id="addColumnModal" tabindex="-1" aria-labelledby="addColumnModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addColumnModalLabel">Add New Column</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="manage_columns.php" method="post">
                            <div class="form-group">
                                <label for="field_name">Field Name:</label>
                                <input type="text" name="field_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="field_type">Field Type:</label>
                                <select name="field_type" class="form-control">
                                    <option value="text">Text</option>
                                    <option value="number">Number</option>
                                    <option value="date">Date</option>
                                    <option value="email">Email</option>    
                                </select>
                            </div>
                            <input type="submit" name="add_field" value="Add Column" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="mb-4">Existing Columns</h2>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Field Name</th>
                    <th>Field Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $fields_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['field_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['field_type']); ?></td>
                        <td>
                            <?php if ($editing_field_id === intval($row['id'])) { ?>
                                <form action="manage_columns.php" method="post" style="display:inline;">
                                    <input type="hidden" name="field_id" value="<?php echo $row['id']; ?>">
                                    <input type="text" name="field_name" value="<?php echo htmlspecialchars($row['field_name']); ?>" required class="form-control" style="display:inline-block; width: auto;">
                                    <select name="field_type" class="form-control" style="display:inline-block; width: auto;">
                                        <option value="text" <?php echo $row['field_type'] == 'text' ? 'selected' : ''; ?>>Text</option>
                                        <option value="number" <?php echo $row['field_type'] == 'number' ? 'selected' : ''; ?>>Number</option>
                                        <option value="date" <?php echo $row['field_type'] == 'date' ? 'selected' : ''; ?>>Date</option>
                                        <option value="email" <?php echo $row['field_type'] == 'email' ? 'selected' : ''; ?>>Email</option>
                                    </select>
                                    <input type="submit" name="edit_field" value="Edit" class="btn btn-warning btn-sm">
                                </form>
                            <?php } else { ?>
                                <a href="manage_columns.php?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="manage_columns.php?delete=1&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this column?');">Delete</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <p><a href="index.php" class="btn btn-secondary">Go back to Phonebook</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
