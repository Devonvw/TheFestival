<?php
require_once __DIR__ . '/../DAL/UserDAO.php';

class UserService {
    public function logoutUser() {
        $dao = new UserDAO();
        $dao->logoutUser();
    }

    public function loginUser($email, $password) {
        $dao = new UserDAO();
        $dao->loginUser($email, $password);
    }

    public function createUser($email, $password) {
        $dao = new UserDAO();
        $dao->createUser($email, $password);
    }

    public function getMyPosts() {
        $dao = new UserDAO();
        return $dao->getMyPosts();
    }
}
?>