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

    public function editInformationPage($id, $url, $title, $subtitle, $metaDescription, $metaTitle, $image, $sections) {
        $dao = new InformationPageDAO();
        $dao->editInformationPage($id, $url, $title, $subtitle, $metaDescription, $metaTitle, $image, $sections);
    }

    public function addInformationPage() {
        $dao = new InformationPageDAO();
        $dao->addInformationPage();
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

    public function checkIfInformationPage($url) {
        $dao = new InformationPageDAO();
        return $dao->checkIfInformationPage($url);
    }
}
?>