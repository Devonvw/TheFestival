<?php
require_once __DIR__ . '/../model/Password_resets.php';
require_once __DIR__ . '/../DAL/Database.php';
require_once __DIR__ . '/../DAL/AccountDAO.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class PasswordResetDAO
{
    public $DB;

    function __construct()
    {
        $this->DB = new DB();
    }
    function sendConfirmationMail($email)
    {
        $_SESSION['email'] = $email;
        session_write_close();
        if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address", 1);
        }
        if (empty(trim($email))) {
            throw new Exception("Please enter an email.", 1);
        }
        // Step 2: Generate a unique token for the user
        $token = uniqid();

        // Step 3: Hash the token
        $hashed_token = hash('sha256', $token);

        // Step 4: Store the hashed token and the user's email in the database
        $stmt = $this->DB::$connection->prepare("INSERT INTO password_resets (email, token, expiration) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))");
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $hashed_token);
        $stmt->execute();


        $reset_link = "localhost/login/reset/password?token=$hashed_token";
        $mail = new PHPMailer(true);

        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'festivalteamhaarlem@gmail.com'; //SMTP username
        $mail->Password = 'yfrjxpbwjpxuuvnd'; //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587; //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('festivalteamhaarlem@gmail.com', 'Festival Team');
        $mail->addAddress($email, $email); //Add a recipient


        //Content
        $mail->isHTML(true); //Set email format to plain text
        $mail->Subject = 'Password reset link';
        $mail->Body = "Please click the following link to reset your password: <a href='" . $reset_link . "'>" . $reset_link . "</a>";


        $mail->send();
        $mail->smtpClose();
    }
    function resetPassword($password, $password_confirm)
    {
        $dao = new AccountDAO;
        if (empty(trim($password)) || empty(trim($password))) {
            throw new Exception("Please enter all fields", 1);
        }
        if (empty(trim($password)) !== empty(trim($password_confirm))) {
            throw new Exception("Passwords do not match", 1);
        }
        if (strlen(trim($password)) < 6) {
            throw new Exception("New password must have at least 6 characters", 1);
        }
        $email = $_SESSION['email'];

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update the user's password in the database
        $stmt = $this->DB::$connection->prepare("UPDATE account SET password = ? WHERE email = ?");
        $stmt->bindParam(1, $hashed_password);
        $stmt->bindParam(2, $email);
        $stmt->execute();
        $dao->updateAndSendConfirmationEmail($stmt, $email, $email, 'Password');

        $this->tokenRemover($email);
    }

    function tokenRemover($email)
    {
        $stmt = $this->DB::$connection->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->bindParam(1, $email);
        $stmt->execute();
    }
}
