<?php
include 'db_connect.php';

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM phonebook WHERE id='$id'");
$entry = $result->fetch_assoc();

$fields_result = $conn->query("SELECT * FROM phonebook_fields");
$dynamic_columns = [];
while ($field = $fields_result->fetch_assoc()) {
    $dynamic_columns[] = $field;
}
$dynamic_data = json_decode($entry['data'], true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Phonebook Entry</title>
</head>
<body>
    <h1>Edit Phonebook Entry</h1>

    <form action="process.php" method="post">
        <input type="hidden" name="id" value="<?php echo $entry['id']; ?>">

        <?php foreach ($dynamic_columns as $column) { ?>
            <label for="<?php echo strtolower(str_replace(' ', '_', $column['field_name'])); ?>">
                <?php echo $column['field_name']; ?>:
            </label>
            <input type="<?php echo $column['field_type']; ?>" 
                   name="dynamic_data[<?php echo strtolower(str_replace(' ', '_', $column['field_name'])); ?>]" 
                   value="<?php echo htmlspecialchars($dynamic_data[strtolower(str_replace(' ', '_', $column['field_name']))] ?? ''); ?>">
        <?php } ?>

        <input type="submit" name="save" value="Update">
    </form>

    <p><a href="index.php">Cancel</a></p>
</body>
</html>
