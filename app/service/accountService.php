<?php
require_once __DIR__ . '/../DAL/AccountDAO.php';

class AccountService {
    public function logoutUser() {
        $dao = new AccountDAO();
        $dao->logoutUser();
    }

    public function loginUser($email, $password) {
        $dao = new AccountDAO();
        $dao->loginUser($email, $password);
    }

    public function createUser($email, $password, $first_name, $last_name, $type_id) {
        $dao = new AccountDAO();
        $dao->createUser($email, $password, $first_name, $last_name, $type_id);
    }

    public function getAllAccounts() {
        $dao = new AccountDAO();
        return $dao->getAllAccounts();
    }

    public function getAccount($userId){
        $dao = new AccountDAO();
        return $dao->getAccount($userId);
    }

    public function getUserAccount($userId){
        $dao = new AccountDAO();
        return $dao->getUserAccount($userId);
    }

    public function deleteAccount($id) {
        $dao = new AccountDAO();
        $dao->deleteAccount($id);
    }

    public function updateAccount($id, $firstName, $lastName, $email) {
        $dao = new AccountDAO();
        $dao->updateAccount($id, $firstName, $lastName, $email);
    }
    public function updateAccountCustomer($firstName, $lastName, $profile_picture) {
        $dao = new AccountDAO();
        $dao->updateAccountCustomer($firstName, $lastName, $profile_picture);
    }
    public function updateEmailCustomer($email, $new_email, $password){
        $dao = new AccountDAO();
        $dao->updateEmailCustomer($email, $new_email, $password);
    }

}