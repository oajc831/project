<?php
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$gender = $_POST['gender'];

if (!empty($username) || !empty($password) || !empty($email) || !empty($gender)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "login";

    //create connection
    $conn = new msqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error()) {
        die ('Connect Error('. mysqli_connect_errno().')' mysqli_connect_error());

    }  else {
        $SELECT = "SELECT email From register Where email = ? Limit 1";
        $INSERT = "INSERT Into register (username, password, gender, email) values(?, ?, ?, ?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT)
            $stmt->bind_param("ssss", $username, $password, $gender, $email);
            $stmt->execute();
            echo "New record inserted successfully";
        } else {
            echo "This email is already in use";
        }
        $stmt->close();
        $conn->close();

    }

}  else {
    echo "All fields are required";
    die();
}




?>