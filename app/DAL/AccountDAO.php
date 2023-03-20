<?php
require_once __DIR__ . '/../model/Account.php';
require_once __DIR__ . '/../DAL/Database.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../packages/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../env/index.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class AccountDAO
{

    public $DB;

    function __construct()
    {
        $this->DB = new DB();
    }

    function logoutUser()
    {
        if (isset($_SESSION["loggedin"])) {
            session_destroy();
        }
    }

    function loginUser($email, $password)
    {
        if (empty(trim($email))) {
            throw new Exception("Please enter an email.", 1);
        }
        if (empty(trim($password))) {
            throw new Exception("Please enter a password.", 1);
        }

        $stmt = $this->DB::$connection->prepare("SELECT * FROM account WHERE email = :email LIMIT 1");
        $email_param = trim(htmlspecialchars($email));
        $stmt->bindValue(':email', $email_param, PDO::PARAM_STR);
        $stmt->execute();
        $account = $stmt->fetchObject("Account");

        if (!$account) throw new Exception("This email does not exist", 1);

        if (password_verify($password, $account->password)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $account->id;
            $_SESSION["email"] = $account->email;
            $_SESSION["first_name"] = $account->first_name;
            $_SESSION["last_name"] = $account->last_name;
            $_SESSION["type_id"] = $account->type_id;


            // $image_data = file_get_contents($_FILES["profile_picture"]["name"]);
            // $encoded_image = base64_encode($image_data);
            // $_SESSION["profile_picture"] = $encoded_image;

            session_write_close();
        } else throw new Exception("Password is not correct", 1);
    }



    function createUser($email, $password, $first_name, $last_name, $type_id)
    {
        if (empty(trim($email))) {
            throw new Exception("Please enter an email", 1);
        }

        if (!filter_var(trim($email), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address", 1);
        }

        if ($stmt = $this->DB::$connection->prepare("SELECT id FROM account WHERE email = :email")) {
            $email_param = trim(htmlspecialchars($email));
            $stmt->bindParam(':email', $email_param);
            $stmt->execute();
            if ($stmt->fetchColumn() > 1) {
                throw new Exception("This email is already taken", 1);
            }
        }

        // Validate password
        if (empty(trim($password))) {
            throw new Exception("Please enter a password", 1);
        }
        if (strlen(trim($password)) < 6) {
            throw new Exception("Password must have at least 6 characters", 1);
        }

        // Validate first name
        if (empty(trim($first_name))) {
            throw new Exception("Please enter a first name", 1);
        }

        // Validate last name
        if (empty(trim($last_name))) {
            throw new Exception("Please enter a last name", 1);
        }

        if ($stmt = $this->DB::$connection->prepare("INSERT INTO account (email, password, first_name, last_name, type_id) VALUES (:email, :password, :first_name, :last_name, :type_id)")) {
            $email_param = trim(htmlspecialchars($email));
            $password_param = password_hash(trim(htmlspecialchars($password)), PASSWORD_DEFAULT);
            $first_name_param = trim(htmlspecialchars($first_name));
            $last_name_param = trim(htmlspecialchars($last_name));
            $type_id_param = trim(htmlspecialchars($type_id));

            $stmt->bindParam(':email', $email_param);
            $stmt->bindParam(':password', $password_param);
            $stmt->bindParam(':first_name', $first_name_param);
            $stmt->bindParam(':last_name', $last_name_param);
            $stmt->bindParam(':type_id', $type_id_param);

            if ($stmt->execute()) {
                return true;
            } else {
                throw new Exception("Error: Could not create user.", 1);
            }
        }
    }

    function getAllAccounts()
    {
        if ((isset($_SESSION["type"]) ? $_SESSION["type"] : 0) == 3) throw new Exception("Only admins can retrieve all accounts", 1);

        $stmt = $this->DB::$connection->prepare("SELECT account.id, account.first_name, account.last_name, account.email, account_type.name as type_name, account.created_at, account.active from account left join account_type on account_type.id = account.type_id where type_id != 3 order by id;");

        $stmt->execute();
        $accounts = $stmt->fetchAll(PDO::FETCH_CLASS, 'Account');
        return $accounts;
    }

    function deleteAccount($id)
    {
        $del_stmt = $this->DB::$connection->prepare("UPDATE account SET active = false where id = :id");
        $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $del_stmt->execute();
    }

    function setAccountActive($id)
    {
        $del_stmt = $this->DB::$connection->prepare("UPDATE account SET active = true where id = :id");
        $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $del_stmt->execute();
    }

    function updateAccount($id, $firstName, $lastName, $email)
    {
        if ((isset($_SESSION["type"]) ? $_SESSION["type"] : 0) == 3) throw new Exception("Only admins can retrieve all accounts", 1);

        $stmt = $this->DB::$connection->prepare("SELECT * FROM account WHERE id = :id LIMIT 1");
        $stmt->bindValue(':id', trim(htmlspecialchars($id)), PDO::PARAM_INT);
        $stmt->execute();
        $account = $stmt->fetchObject("Account");

        $del_stmt = $this->DB::$connection->prepare("UPDATE account SET first_name = :first_name, last_name = :last_name, email = :email where id = :id");
        $del_stmt->bindValue(':id', trim(htmlspecialchars($id)), PDO::PARAM_INT);
        $del_stmt->bindValue(':first_name', $firstName ? trim(htmlspecialchars($firstName)) : $account->first_name, PDO::PARAM_STR);
        $del_stmt->bindValue(':last_name', $lastName ? trim(htmlspecialchars($lastName)) : $account->last_name, PDO::PARAM_STR);
        $del_stmt->bindValue(':email', $email ? trim(htmlspecialchars($email)) : $account->email, PDO::PARAM_STR);

        $del_stmt->execute();
    }
    function updateAccountCustomer($first_name, $last_name, $profile_picture)
    {

        if ($profile_picture && $profile_picture["size"] == 0) throw new Exception("This image is bigger than 2MB", 1);
        if ($profile_picture && !is_uploaded_file($profile_picture['tmp_name'])) throw new Exception("This is not the uploaded file", 1);

        if ($profile_picture && !is_null($profile_picture)) {
            $img_data = file_get_contents($profile_picture['tmp_name']);

            $stmt = $this->DB::$connection->prepare("UPDATE account SET profile_picture = :profile_picture where id = :id");
            $stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
            $stmt->bindValue(':profile_picture', $img_data);
            $stmt->execute();
        }
        $account = $this->getAccount($_SESSION['id']);
        $update_stmt = $this->DB::$connection->prepare("UPDATE account SET first_name = :first_name, last_name = :last_name where id = :id");
        $update_stmt->bindValue(':id', $_SESSION['id'], PDO::PARAM_INT);
        $update_stmt->bindValue(':first_name', trim(htmlspecialchars($first_name)));
        $update_stmt->bindValue(':last_name', trim(htmlspecialchars($last_name)));
        $update_stmt->execute();
    }
    public function updateEmailCustomer($new_email, $new_email_confirmation, $password)
    {
        $account = $this->getAccount($_SESSION['id']);

        // Check if all fields are filled in
        if (empty(trim($new_email)) || empty(trim($new_email_confirmation)) || empty(trim($password))) {
            throw new Exception("Not all fields are filled in", 1);
        }

        // Validate email address
        if (!filter_var(trim($new_email), FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email address", 1);
        }

        // Check if email and confirmation match
        if (trim($new_email) !== trim($new_email_confirmation)) {
            throw new Exception("Emails do not match", 1);
        }

        // Check if password is correct
        if (!password_verify($password, $account->password)) {
            throw new Exception("Your password was incorrect", 1);
        }
        if ($update_stmt = $this->DB::$connection->prepare("UPDATE account SET email = :email where id = :id")) {
            $update_stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
            $update_stmt->bindValue(':email', trim(htmlspecialchars($new_email)), PDO::PARAM_STR);
            if ($update_stmt->execute()) {
                $this->updateAndSendConfirmationEmail($update_stmt, $account->email, $account->first_name, 'e-mail');

                return true;
            } else {
                throw new Exception("Error: Could not update email.", 1);
            }
        }
    }
    public function updatePasswordCustomer($current_password, $new_password, $new_password_confirmation)
    {
        $account = $this->getAccount($_SESSION['id']);
        $passwordCheck = password_verify(trim($current_password), $account->password);
        // Check if password is correct
        if (!$passwordCheck) {
            throw new Exception("Current password was incorrect", 1);
        }
        // Check if all fields are filled in
        if (empty(trim($new_password)) || empty(trim($new_password_confirmation)) || empty(trim($current_password))) {
            throw new Exception("Not all fields are filled in", 1);
        }
        // Check if email and confirmation match
        if (trim($new_password) !== trim($new_password_confirmation)) {
            throw new Exception("New passwords do not match", 1);
        }
        if (strlen(trim($new_password)) < 6) {
            throw new Exception("New password must have at least 6 characters", 1);
        }
        if ($update_stmt = $this->DB::$connection->prepare("UPDATE account SET password = :password where id = :id")) {
            $password_param = password_hash(trim(htmlspecialchars($new_password)), PASSWORD_DEFAULT);
            $update_stmt->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
            $update_stmt->bindParam(':password', $password_param);
            if ($update_stmt->execute()) {
                $this->updateAndSendConfirmationEmail($update_stmt, $account->email, $account->first_name, 'password');
            } else {
                throw new Exception("Error: Could not update password.", 1);
            }
        }
    }
    function updateAndSendConfirmationEmail($update_stmt, $email, $firstName, $messageSubject)
    {
        if ($update_stmt->execute()) {
            // If the email has been updated, send a confirmation email
            $mail = new PHPMailer(true);

            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF; // Enable verbose debug output
            $mail->isSMTP(); // Send using SMTP
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'festivalteamhaarlem@gmail.com'; // SMTP username
            $mail->Password = SMPT_PASSWORD; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = 587; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            // Recipients
            $mail->setFrom('festivalteamhaarlem@gmail.com', 'Festival Team');
            $mail->addAddress($email, $firstName); // Add a recipient

            // Content
            $mail->isHTML(false); // Set email format to plain text
            $mail->Subject = $messageSubject . ' updated';
            $mail->Body = "Dear " . $firstName . ",\n\nYour " . $messageSubject . " has been updated on our website. If you did not make this change, please contact us immediately.\n\nBest regards,\nThe festival team";

            $mail->send();
            $mail->smtpClose();
        }
    }


    function getAccount($id)
    {
        $stmt = $this->DB::$connection->prepare("SELECT * from account where id = :id LIMIT 1");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $account = $stmt->fetchObject("Account");
        if ($account->profile_picture && !is_null($account->profile_picture)) {
            $profile_picture_stmt = $this->DB::$connection->prepare("SELECT profile_picture FROM account WHERE id = :id");
            $profile_picture_stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $profile_picture_stmt->execute();
            $profile_picture = base64_encode($profile_picture_stmt->fetch(PDO::FETCH_ASSOC)['profile_picture']);
            $account->profile_picture = $profile_picture;
        }
        return $account;
    }


    function getUserAccount($id)
    {
        $stmt = $this->DB::$connection->prepare("SELECT * from account where id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $account = $stmt->fetchObject("Account");
        return $account;
    }
}