<?php 
require __DIR__ . '/../model/InformationPage.php';
require_once __DIR__ . '/../DAL/Database.php';

    class InformationPageDAO {
       public $DB;
       
       function __construct() {
         $this->DB = new DB();
       }

       function getInformationPages() {
        //Maybe better check for home page
          $stmt = $this->DB::$connection->prepare("SELECT information_page.*, JSON_ARRAYAGG(information_section.json) as sections from information_page left join (select id, information_page_id, JSON_MERGE(JSON_OBJECTAGG('id', information_section.id), JSON_OBJECTAGG('text', information_section.text)) as json from information_section group by information_section.id order by information_section.id) as information_section on information_page.id = information_section.information_page_id where information_page.id != 1 group by information_page.id;");

          $stmt->execute();
          $data = $stmt->fetchAll();

          $pages = [];

          foreach ($data as $row) {
            array_push($pages, new InformationPage($row['id'], $row['url'], $row['title'], $row['subtitle'], $row['meta_title'], $row['meta_description'], $row['image'] ? base64_encode($row['image']) : null, $row['sections'] == '[null]' ? [] :json_decode($row['sections'])));
          }

          return $pages;
        }

        function getInformationPage($id, $url) {
          $data = null;

          if ($id) {
            $stmt = $this->DB::$connection->prepare("SELECT information_page.*, JSON_ARRAYAGG(information_section.json) as sections from information_page left join (select id, information_page_id, JSON_MERGE(JSON_OBJECTAGG('id', information_section.id), JSON_OBJECTAGG('text', information_section.text)) as json from information_section group by information_section.id order by information_section.id) as information_section on information_page.id = information_section.information_page_id where information_page.id = :id group by information_section.information_page_id LIMIT 1;");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  
            $stmt->execute();
            $data = $stmt->fetch();
          } else if ($url) {
            $stmt = $this->DB::$connection->prepare("SELECT information_page.*, JSON_ARRAYAGG(information_section.json) as sections from information_page left join (select id, information_page_id, JSON_MERGE(JSON_OBJECTAGG('id', information_section.id), JSON_OBJECTAGG('text', information_section.text)) as json from information_section group by information_section.id order by information_section.id) as information_section on information_page.id = information_section.information_page_id where information_page.url = :url group by information_section.information_page_id LIMIT 1;");
            $stmt->bindValue(':url', $url, PDO::PARAM_STR);
  
            $stmt->execute();
            $data = $stmt->fetch();
          }

          if (!$data) return;

          return new InformationPage($data['id'], $data['url'], $data['title'], $data['subtitle'], $data['meta_title'], $data['meta_description'], $data['image'] ? base64_encode($data['image']) : null, $data['sections'] == '[null]' ? [] :json_decode($data['sections']));
        }

        function getHomePage() {
          $stmt = $this->DB::$connection->prepare("SELECT information_page.*, JSON_ARRAYAGG(information_section.json) as sections from information_page left join (select id, information_page_id, JSON_MERGE(JSON_OBJECTAGG('id', information_section.id), JSON_OBJECTAGG('text', information_section.text)) as json from information_section group by information_section.id order by information_section.id) as information_section on information_page.id = information_section.information_page_id where information_page.id = 1 group by information_section.information_page_id LIMIT 1;");

          $stmt->execute();
          $data = $stmt->fetch();

          if (!$data) return;

          return new InformationPage($data['id'], $data['url'], $data['title'], $data['subtitle'], $data['meta_title'], $data['meta_description'], $data['image'] ? base64_encode($data['image']) : null, $data['sections'] == '[null]' ? [] :json_decode($data['sections']));
        }

        function editHomePage($title, $subtitle, $metaDescription, $metaTitle, $sections, $image) {
          //if (!$image) throw new Exception("Please enter an image url", 1);
          if ($image && $image["size"] == 0) throw new Exception("This image is bigger than 2MB", 1);
          if ($image && !is_uploaded_file($image['tmp_name'])) throw new Exception("This is not the uploaded file", 1);

          $this->DB::$connection->beginTransaction();

          if ($image) {
            $img_data = file_get_contents($image['tmp_name']);
            $img_type = $image['type'];

            $stmt = $this->DB::$connection->prepare("UPDATE information_page SET image = :image where id = :id");
            $stmt->bindValue(':id', 1, PDO::PARAM_INT);
            $stmt->bindValue(':image', $img_data);
            $stmt->execute();
          }

          $stmt = $this->DB::$connection->prepare("UPDATE information_page SET title = :title, subtitle = :subtitle, meta_title = :meta_title, meta_description = :meta_description where id = :id");
          $stmt->bindValue(':id', 1, PDO::PARAM_INT);
          $stmt->bindValue(':title', trim(htmlspecialchars($title)), PDO::PARAM_STR);
          $stmt->bindValue(':subtitle', trim(htmlspecialchars($subtitle)), PDO::PARAM_STR);
          $stmt->bindValue(':meta_description', trim(htmlspecialchars($metaDescription)), PDO::PARAM_STR);
          $stmt->bindValue(':meta_title', trim(htmlspecialchars($metaTitle)), PDO::PARAM_STR);
          $stmt->execute();

          foreach ($sections as $value) {
            $sections_stmt = $this->DB::$connection->prepare("UPDATE information_section SET text = :text where id = :id");
            $sections_stmt->bindValue(':id', $value->id, PDO::PARAM_INT);
            //Security check ??
            $sections_stmt->bindValue(':text', $value->text, PDO::PARAM_STR);
            $sections_stmt->execute();
          }

          $this->DB::$connection->commit();
        }

        function editInformationPage($id, $url, $title, $subtitle, $metaDescription, $metaTitle, $sections, $image) {
            if (!preg_match('/^[-a-zA-Z]+$/D', $url)) throw new Exception("Url can only contain letters and dashes (-)", 1);
            //if (!$image) throw new Exception("Please enter an image url", 1);
            if ($image && $image["size"] == 0) throw new Exception("This image is bigger than 2MB", 1);
            if ($image && !is_uploaded_file($image['tmp_name'])) throw new Exception("This is not the uploaded file", 1);
 
          $this->DB::$connection->beginTransaction();

          if ($image) {
            $img_data = file_get_contents($image['tmp_name']);
            $img_type = $image['type'];

            $stmt = $this->DB::$connection->prepare("UPDATE information_page SET image = :image where id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':image', $img_data);
            $stmt->execute();
          }

          $stmt = $this->DB::$connection->prepare("UPDATE information_page SET url = :url, title = :title, subtitle = :subtitle, meta_title = :meta_title, meta_description = :meta_description where id = :id");
          $stmt->bindValue(':id', trim(htmlspecialchars($id)), PDO::PARAM_INT);
          $stmt->bindValue(':url', trim(htmlspecialchars($url)), PDO::PARAM_STR);
          $stmt->bindValue(':title', trim(htmlspecialchars($title)), PDO::PARAM_STR);
          $stmt->bindValue(':subtitle', trim(htmlspecialchars($subtitle)), PDO::PARAM_STR);
          $stmt->bindValue(':meta_description', trim(htmlspecialchars($metaDescription)), PDO::PARAM_STR);
          $stmt->bindValue(':meta_title', trim(htmlspecialchars($metaTitle)), PDO::PARAM_STR);

          $stmt->execute();

          foreach ($sections as $value) {
            $sections_stmt = $this->DB::$connection->prepare("UPDATE information_section SET text = :text where id = :id");
            $sections_stmt->bindValue(':id', $value->id, PDO::PARAM_INT);
            //Security check ??
            $sections_stmt->bindValue(':text', $value->text, PDO::PARAM_STR);
            $sections_stmt->execute();
          }

          $this->DB::$connection->commit();
        }

        function addInformationPage() {
            //Check if title only contains letters
            //if (!preg_match('/^[-a-zA-Z]+$/D', $url)) throw new Exception("Url can only contain letters and dashes (-)", 1);

            $stmt = $this->DB::$connection->prepare("INSERT INTO information_page (url, meta_title, meta_description, title, subtitle) VALUES ('', '', '', '', '');");
  
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

          function checkIfInformationPage($url) {
            $stmt = $this->DB::$connection->prepare("SELECT * FROM information_page where url = :url");
            $stmt->bindValue(':url', $url, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch();

            if (!$data) return false;
            return true;
          }
     }
?>