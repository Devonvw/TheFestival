<?php 
require_once __DIR__ . '/../model/Account.php';
require_once __DIR__ . '/../model/Post.php';
require_once __DIR__ . '/../DAL/Database.php';

    class AccountDAO {
       public $DB;
       
       function __construct() {
         $this->DB = new DB();
       }

       function logoutUser() {
          if (isset($_SESSION["loggedin"])){
            session_destroy();
          }
       }

       function loginUser($username, $password) {
        if(empty(trim($username))){
            throw new Exception("Please enter a username.", 1);
        }
        if(empty(trim($password))){
            throw new Exception("Please enter a password.", 1);
        }

        $stmt = $this->DB::$connection->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $username_param = trim(htmlspecialchars($username));
        $stmt->bindValue(':username', $username_param, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetchObject("User");

        if(!$user) throw new Exception("This user does not exist", 1);

        if(password_verify($password, $user->password)){

            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user->id;
            $_SESSION["username"] = $user->username;  

            session_write_close();
        } else throw new Exception("Password is not correct", 1);
       }

       function createUser($username, $password) {
        if(empty(trim($username))){
            throw new Exception("Please enter a username", 1);
        } 
        
        if(!preg_match('/^[a-zA-Z0-9_]+$/', trim($username))){
            throw new Exception("Username can only contain letters, numbers, and underscores", 1);
        } 

        if($stmt = $this->DB::$connection->prepare("SELECT id FROM users WHERE username = :username")){
            $username_param = trim(htmlspecialchars($username));
            $stmt->bindParam(':username', $username_param);  
            $stmt->execute();
            if($stmt->fetchColumn() > 1){
                throw new Exception("This username is already taken", 1);
            } 
        }
        
        // Validate password
        if(empty(trim($password))){
            throw new Exception("Please enter a password", 1);
        } 
        if(strlen(trim($password)) < 6){
            throw new Exception("Password must have atleast 6 characters", 1);
        } 
        
        if($stmt = $this->DB::$connection->prepare("INSERT INTO users (username, password) VALUES (:username, :password)")){
            $username_param = trim(htmlspecialchars($username));
            $password_param = password_hash(trim(htmlspecialchars($password)),PASSWORD_DEFAULT);
            
            $stmt->bindParam(':username', $username_param);            
            $stmt->bindParam(':password', $password_param);            
            
            $stmt->execute();
        }
       }

       function getAllAccounts() {
        if ((isset($_SESSION["type"]) ? $_SESSION["type"] : 0) == 3) throw new Exception("Only admins can retrieve all accounts", 1);

        $stmt = $this->DB::$connection->prepare("SELECT * from account where type_id is not 3 order by id;");

        $stmt->execute();
        $accounts = $stmt->fetchAll(PDO::FETCH_CLASS, 'Account');;

        return $accounts;
      }

      function deleteAccount($id) {
        if ((isset($_SESSION["type"]) ? $_SESSION["type"] : 0) == 3) throw new Exception("Only admins can retrieve all accounts", 1);

        $del_stmt = $this->DB::$connection->prepare("UPDATE account SET active = false where id = :id");
        $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $del_stmt->execute();
      }

      function updateAccount($id, $firstName, $lastName, $email) {
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
     }
?>