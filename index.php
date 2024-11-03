<?php
include 'db_connect.php';

$fields_result = $conn->query("SELECT * FROM phonebook_fields");
$dynamic_columns = [];
while ($field = $fields_result->fetch_assoc()) {
    $dynamic_columns[] = $field;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Phonebook</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
  
        .header-title {
            font-size: 2.5rem; 
            font-weight: bold; 
            color: #fff; 
            background-color: #007bff; 
            padding: 20px; 
            border-radius: 5px; 
            text-align: center; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
            margin-bottom: 30px; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="header-title mb-4">Phonebook</h1>

        <div class="d-flex justify-content-between mb-4">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPhonebookModal">
                Add Phonebook Entry
            </button>

            <form action="manage_columns.php" method="get">
                <button type="submit" class="btn btn-primary">Manage Columns</button>
            </form>
        </div>

        <!-- Modal adding phonebook-->
        <div class="modal fade" id="addPhonebookModal" tabindex="-1" aria-labelledby="addPhonebookModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPhonebookModalLabel">Add Phonebook Entry</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="process.php" method="post">
                            <input type="hidden" name="id" value="">
                            
                            <?php foreach ($dynamic_columns as $column) { ?>
                                <div class="form-group">
                                    <label for="<?php echo strtolower(str_replace(' ', '_', $column['field_name'])); ?>">
                                        <?php echo $column['field_name']; ?>:
                                    </label>
                                    <input type="<?php echo $column['field_type']; ?>" 
                                           class="form-control" 
                                           name="dynamic_data[<?php echo strtolower(str_replace(' ', '_', $column['field_name'])); ?>]" 
                                           placeholder="Enter <?php echo $column['field_name']; ?>" required>
                                </div>
                            <?php } ?>

                            <button type="submit" name="save" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display phonebook-->
        <h2 class="mb-4">Phonebook Entries</h2>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <?php foreach ($dynamic_columns as $column) { ?>
                        <th><?php echo $column['field_name']; ?></th>
                    <?php } ?>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM phonebook");
                while ($row = $result->fetch_assoc()) {
                    $dynamic_data = json_decode($row['data'], true); 
                    echo "<tr>";
                    
                    foreach ($dynamic_columns as $column) {
                        $column_key = strtolower(str_replace(' ', '_', $column['field_name']));
                        echo "<td>" . ($dynamic_data[$column_key] ?? '') . "</td>";
                    }
                    echo "<td>
                            <button class='btn btn-warning btn-sm' data-toggle='modal' data-target='#editPhonebookModal' 
                                    data-id='" . $row['id'] . "' 
                                    data-dynamicdata='" . htmlspecialchars(json_encode($dynamic_data)) . "'>
                                Edit
                            </button>
                            <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="editPhonebookModal" tabindex="-1" aria-labelledby="editPhonebookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPhonebookModalLabel">Edit Phonebook Entry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="process.php" method="post" id="editForm">
                        <input type="hidden" name="id" id="edit-id" value="">

                        <?php foreach ($dynamic_columns as $column) { ?>
                            <div class="form-group">
                                <label for="<?php echo strtolower(str_replace(' ', '_', $column['field_name'])); ?>">
                                    <?php echo $column['field_name']; ?>:
                                </label>
                                <input type="<?php echo $column['field_type']; ?>" 
                                       class="form-control" 
                                       id="<?php echo strtolower(str_replace(' ', '_', $column['field_name'])); ?>" 
                                       name="dynamic_data[<?php echo strtolower(str_replace(' ', '_', $column['field_name'])); ?>]" 
                                       value="">
                            </div>
                        <?php } ?>

                        <button type="submit" name="save" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>

        $('#editPhonebookModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var id = button.data('id'); 
            var dynamicData = button.data('dynamicdata');
            
            $('#edit-id').val(id);
            for (const [key, value] of Object.entries(dynamicData)) {
                $('#' + key).val(value);
            }
        });
    </script>
</body>
</html>
