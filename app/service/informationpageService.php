<?php
require_once __DIR__ . '/../DAL/InformationPageDAO.php';

class InformationPageService {
    public function getInformationPages() {
        $dao = new InformationPageDAO();
        return $dao->getInformationPages();
    }

    public function getInformationPage($id) {
        $dao = new InformationPageDAO();
        return $dao->getInformationPage($id);
    }

    public function getHomePage() {
        $dao = new InformationPageDAO();
        return $dao->getHomePage();
    }

    public function editHomePage($title, $subtitle, $metaDescription, $metaTitle, $sections, $image) {
        $dao = new InformationPageDAO();
        $dao->editHomePage($title, $subtitle, $metaDescription, $metaTitle, $sections, $image);
    }

    public function addInformationPage($url, $title, $description) {
        $dao = new InformationPageDAO();
        $dao->addInformationPage($url, $title, $description);
    }

    public function deleteInformationPage($id) {
        $dao = new InformationPageDAO();
        $dao->deleteInformationPage($id);
    }

    public function addInformationSection($informationPageId) {
        $dao = new InformationPageDAO();
        return $dao->addInformationSection($informationPageId);
    }

    public function deleteInformationSection($id) {
        $dao = new InformationPageDAO();
        return $dao->deleteInformationSection($id);
    }
}
?>