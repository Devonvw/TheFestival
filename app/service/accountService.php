<?php
require_once __DIR__ . '/../DAL/AccountDAO.php';

class AccountService {
    public function logoutUser() {
        $dao = new AccountDAO();
        $dao->logoutUser();
    }

    public function loginUser($username, $password) {
        $dao = new AccountDAO();
        $dao->loginUser($username, $password);
    }

    public function createUser($username, $password) {
        $dao = new AccountDAO();
        $dao->createUser($username, $password);
    }

    public function getAllAccounts() {
        $dao = new AccountDAO();
        $dao->getAllAccounts();
    }

    public function deleteAccount($id) {
        $dao = new AccountDAO();
        $dao->deleteAccount($id);
    }

    public function updateAccount($id, $firstName, $lastName, $email) {
        $dao = new AccountDAO();
        $dao->updateAccount($id, $firstName, $lastName, $email);
    }
}
?>