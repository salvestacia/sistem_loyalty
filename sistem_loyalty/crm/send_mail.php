<?php
session_start();
include '../koneksi.php'; // Include your database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

// Check if the customer ID is set from the table action
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Query to get data from the database
    $query = "SELECT username, email, poin_loyalty, membership
          FROM user
          WHERE id_user = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param('s', $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    mysqli_stmt_close($stmt); // Close the prepared statement

    // Ensure we have a valid result
    if ($user) {
        $email = $user['email'];
        $username = $user['username'];
        $poin_loyalty = $user['poin_loyalty'];
        $membership = $user['membership'];

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // SMTP server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'darrenchrist2@gmail.com'; // Replace with your email
            $mail->Password = 'xitlwwxvtkndsmee'; // App-specific password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Email settings
            $mail->setFrom('darrenchrist2@gmail.com', 'Sistem Informasi Loyalty');
            $mail->addAddress($email); // Send email to the customer's email

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Ayo Belanja';
            $mail->Body = "Halo $username! Saat ini status membership kamu adalah $membership dan sisa poin loyalty yang kamu miliki adalah: $poin_loyalty points. Jangan lupa cek kembali dan tukarkan poinmu supaya tidak hangus yaa!"; // Customize your email body

            // Send the email
            if ($mail->send()) {
                echo "<script>
                alert('Email terikirim kepada customer!!!');
                window.location.href='http://localhost/sistem_loyalty/crm/halaman_crm.php';
                </script>";
                exit();
            } else {
                echo "Error sending Mail: " . $mail->ErrorInfo;
            }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        // Clear the variables after email is sent
        unset($email, $nama, $item);
    } else {
        echo "Customer email not found.";
    }
} else {
    echo "No customer ID provided.";
}
?>
