<?php 
require __DIR__ . '/../model/InformationPage.php';
require_once __DIR__ . '/../DAL/Database.php';

    class InformationPageDAO {
       public $DB;
       
       function __construct() {
         $this->DB = new DB();
       }

       function getInformationPages() {
          $stmt = $this->DB::$connection->prepare("SELECT information_page.*, JSON_ARRAYAGG(information_section.text) as sections from information_section left join information_page on information_page.id = information_section.information_page_id group by information_section.information_page_id;");

          $stmt->execute();
          $data = $stmt->fetchAll();

          $pages = [];

          foreach ($data as $row) {
            array_push($pages, new InformationPage($row['id'], $row['title'], $row['description'], $row['sections']));
          }

          return $pages;
        }

        function addInformationPage($url, $title, $description) {
            if ((isset($_SESSION["type"]) ? $_SESSION["type"] : 0) == 3) throw new Exception("Only admins can add information pages", 1);

            //Check if title only contains letters
            if (!preg_match('/^[-a-zA-Z]+$/D', $url)) throw new Exception("Url can only contain letters and dashes (-)", 1);

            $stmt = $this->DB::$connection->prepare("INSERT INTO information_page (title, description) VALUES (:title, :description);");
  
            $stmt->bindParam(':title', trim(htmlspecialchars($title)));            
            $stmt->bindParam(':description', trim(htmlspecialchars($description)));  
             
            $stmt->execute();
          }

          function deleteInformationPage($id) {
            if ((isset($_SESSION["type"]) ? $_SESSION["type"] : 0) == 3) throw new Exception("Only admins can delete information pages", 1);

            //Delete all rows associated with this page
            $del_stmt = $this->DB::$connection->prepare("DELETE FROM information_section where information_section_id = :information_section_id");
            $del_stmt->bindValue(':information_section_id', $id, PDO::PARAM_INT);
            $del_stmt->execute();

            $del_stmt = $this->DB::$connection->prepare("DELETE FROM information_page where id = :id");
            $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $del_stmt->execute();
          }

          function addInformationSection($informationPageId) {
            if ((isset($_SESSION["type"]) ? $_SESSION["type"] : 0) == 3) throw new Exception("Only admins can add information sections", 1);

            $stmt = $this->DB::$connection->prepare("INSERT INTO information_section (information_page_id) VALUES (:information_page_id);");
            $stmt->bindParam(':information_page_id', $informationPageId);            
            $stmt->execute();
          }

          function deleteInformationSection($id) {
            if ((isset($_SESSION["type"]) ? $_SESSION["type"] : 0) == 3) throw new Exception("Only admins can delete information sections", 1);

            $del_stmt = $this->DB::$connection->prepare("DELETE FROM information_section where id = :id");
            $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $del_stmt->execute();
          }
     }
?>