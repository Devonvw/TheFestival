<?php
require_once __DIR__ . '/../DAL/PasswordResetDAO.php';

class PasswordResetService {
    public function sendConfirmationMail($email) {
        $dao = new PasswordResetDAO();
        $dao->sendConfirmationMail($email);
    }
    public function resetPassword($password, $new_password) {
        $dao = new PasswordResetDAO();
        $dao->resetPassword($password, $new_password);
    }
}
?>