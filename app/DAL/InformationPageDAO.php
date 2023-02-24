<?php 
require __DIR__ . '/../model/InformationPage.php';
require_once __DIR__ . '/../DAL/Database.php';

    class InformationPageDAO {
       public $DB;
       
       function __construct() {
         $this->DB = new DB();
       }

       function getInformationPages() {
          $stmt = $this->DB::$connection->prepare("SELECT information_page.*, JSON_ARRAYAGG(information_section.json) as sections from information_page left join (select id, information_page_id, JSON_MERGE(JSON_OBJECTAGG('id', information_section.id), JSON_OBJECTAGG('text', information_section.text)) as json from information_section group by information_section.id) as information_section on information_page.id = information_section.information_page_id group by information_section.information_page_id;");

          $stmt->execute();
          $data = $stmt->fetchAll();

          $pages = [];

          foreach ($data as $row) {
            array_push($pages, new InformationPage($row['id'], $row['title'], $row['subtitle'], $row['meta_title'], $row['meta_description'], json_decode(stripslashes($row['sections']))));
          }

          return $pages;
        }

        function getHomePage() {
          $stmt = $this->DB::$connection->prepare("SELECT information_page.*, JSON_ARRAYAGG(information_section.json) as sections from information_page left join (select id, information_page_id, JSON_MERGE(JSON_OBJECTAGG('id', information_section.id), JSON_OBJECTAGG('text', information_section.text)) as json from information_section group by information_section.id) as information_section on information_page.id = information_section.information_page_id where information_page.id = 1 group by information_section.information_page_id LIMIT 1;");

          $stmt->execute();
          $data = $stmt->fetch();

          if (!$data) return;

          return new InformationPage($data['id'], $data['title'], $data['subtitle'], $data['meta_title'], $data['meta_description'], json_decode(stripslashes($data['sections'])));
        }

        function editHomePage($title, $subtitle, $metaDescription, $metaTitle, $sections) {
          $this->DB::$connection->beginTransaction();

          $stmt = $this->DB::$connection->prepare("UPDATE information_page SET title = :title, subtitle = :subtitle, meta_title = :meta_title, meta_description = :meta_description where id = :id");
          $stmt->bindValue(':id', 1, PDO::PARAM_INT);
          $stmt->bindValue(':title', trim(htmlspecialchars($title)), PDO::PARAM_STR);
          $stmt->bindValue(':subtitle', trim(htmlspecialchars($subtitle)), PDO::PARAM_STR);
          $stmt->bindValue(':meta_description', trim(htmlspecialchars($metaDescription)), PDO::PARAM_STR);
          $stmt->bindValue(':meta_title', trim(htmlspecialchars($metaTitle)), PDO::PARAM_STR);

          $stmt->execute();

          foreach ($sections as $value) {
            $sections_stmt = $this->DB::$connection->prepare("UPDATE information_section SET text = :text where id = :id");
            $sections_stmt->bindValue(':id', $value["id"], PDO::PARAM_INT);
            //Security check ??
            $sections_stmt->bindValue(':text', $value["text"], PDO::PARAM_STR);
            $sections_stmt->execute();
          }

          $this->DB::$connection->commit();
        }

        function editInformationPage($id, $url, $title, $subtitle, $metaDescription, $metaTitle, $sections) {
          $this->DB::$connection->beginTransaction();

          $stmt = $this->DB::$connection->prepare("UPDATE information_page SET url = :url, title = :title, subtitle = :subtitle, meta_title = :meta_title, meta_description = :meta_description where id = :id");
          $stmt->bindValue(':id', trim(htmlspecialchars($id)), PDO::PARAM_INT);
          $stmt->bindValue(':url', trim(htmlspecialchars($url)), PDO::PARAM_STR);
          $stmt->bindValue(':title', trim(htmlspecialchars($title)), PDO::PARAM_STR);
          $stmt->bindValue(':subtitle', trim(htmlspecialchars($subtitle)), PDO::PARAM_STR);
          $stmt->bindValue(':meta_description', trim(htmlspecialchars($metaDescription)), PDO::PARAM_STR);
          $stmt->bindValue(':meta_title', trim(htmlspecialchars($metaTitle)), PDO::PARAM_STR);

          $stmt->execute();

          $this->DB::$connection->commit();
        }

        function addInformationPage($url, $title, $description) {
            //Check if title only contains letters
            if (!preg_match('/^[-a-zA-Z]+$/D', $url)) throw new Exception("Url can only contain letters and dashes (-)", 1);

            $stmt = $this->DB::$connection->prepare("INSERT INTO information_page (title, description) VALUES (:title, :description);");
  
            $stmt->bindParam(':title', trim(htmlspecialchars($title)));            
            $stmt->bindParam(':description', trim(htmlspecialchars($description)));  
             
            $stmt->execute();
          }

          function deleteInformationPage($id) {
            //Delete all rows associated with this page
            $del_stmt = $this->DB::$connection->prepare("DELETE FROM information_section where information_section_id = :information_section_id");
            $del_stmt->bindValue(':information_section_id', $id, PDO::PARAM_INT);
            $del_stmt->execute();

            $del_stmt = $this->DB::$connection->prepare("DELETE FROM information_page where id = :id");
            $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $del_stmt->execute();
          }

          function addInformationSection($informationPageId) {
            $stmt = $this->DB::$connection->prepare("INSERT INTO information_section (information_page_id) VALUES (:information_page_id);");
            $stmt->bindParam(':information_page_id', $informationPageId);            
            $stmt->execute();
          }

          function deleteInformationSection($id) {
            $del_stmt = $this->DB::$connection->prepare("DELETE FROM information_section where id = :id");
            $del_stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $del_stmt->execute();
          }
     }
?>