<?php
include "db.php";

/* ADD STUDENT */
if (isset($_POST['add'])) {
    $stmt = $conn->prepare(
        "INSERT INTO students (name, email, course) VALUES (?, ?, ?)"
    );
    $stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['course']
    ]);
    header("Location: index.php");
    exit;
}

/* DELETE STUDENT */
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->execute([$_GET['delete']]);
    header("Location: index.php");
    exit;
}

/* FETCH STUDENTS */
$stmt = $conn->query("SELECT * FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student CRUD</title>
</head>
<body>

<h2>Add Student</h2>
<form method="post">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Course: <input type="text" name="course" required><br><br>
    <button type="submit" name="add">Add</button>
</form>

<hr>

<h2>Student List</h2>
<table border="1" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Course</th>
    <th>Action</th>
</tr>

<?php foreach ($students as $s): ?>
<tr>
    <td><?= $s['id']; ?></td>
    <td><?= $s['name']; ?></td>
    <td><?= $s['email']; ?></td>
    <td><?= $s['course']; ?></td>
    <td>
        <a href="edit.php?id=<?= $s['id']; ?>">Edit</a> |
        <a href="index.php?delete=<?= $s['id']; ?>"
           onclick="return confirm('Are you sure?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>

</table>
</body>
</html>
