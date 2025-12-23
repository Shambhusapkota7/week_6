<?php
include "db.php";

/* CHECK ID */
if (!isset($_GET['id'])) {
    die("Student ID not found");
}

$id = $_GET['id'];

/* FETCH STUDENT */
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->execute([$id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found");
}

/* UPDATE STUDENT */
if (isset($_POST['update'])) {
    $stmt = $conn->prepare(
        "UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?"
    );
    $stmt->execute([
        $_POST['name'],
        $_POST['email'],
        $_POST['course'],
        $id
    ]);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>

<h2>Edit Student</h2>

<form method="post">
    Name:
    <input type="text" name="name"
           value="<?= htmlspecialchars($student['name']); ?>" required><br><br>

    Email:
    <input type="email" name="email"
           value="<?= htmlspecialchars($student['email']); ?>" required><br><br>

    Course:
    <input type="text" name="course"
           value="<?= htmlspecialchars($student['course']); ?>" required><br><br>

    <button type="submit" name="update">Update</button>
</form>

</body>
</html>
