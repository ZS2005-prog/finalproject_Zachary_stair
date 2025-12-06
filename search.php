<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/main.css">
    <script src="scripts/main.js"></script>
</head>
<body>
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "student_directory";
    $conn = new mysqli($servername, $username, $password, $dbname); 
    if ($conn->connect_error) {
        die("Connection has failed: ". $conn->connect_error);
    }
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastNameParam = $_POST['IName'] ?? '';
    $sql = "CALL search_students(?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $lastNameParam);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>"; 
            echo "<td>" . htmlspecialchars($row['student_id']) . "</td>"; 
            echo "<td>" . htmlspecialchars($row['first_name']) . "</td>"; 
            echo "<td>" . htmlspecialchars($row['last_name']) . "</td>"; 
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "</tr>";
        }
   } else {
    echo "<p>No students were found.</p>";
   }
}
    ?>
    <h1>Search Results</h1> 
    <a href="index.php">Go back to the home page</a>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th> 
</tr>
</thead>
<tbody>

</tbody>
</table>
</body>
</html>