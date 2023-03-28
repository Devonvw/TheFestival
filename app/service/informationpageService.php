<?php
require_once __DIR__ . '/../DAL/InformationPageDAO.php';

class InformationPageService {
    public function getInformationPages() {
        $dao = new InformationPageDAO();
        return $dao->getInformationPages();
    }

    public function getInformationPageUrls() {
        $dao = new InformationPageDAO();
        return $dao->getInformationPageUrls();
    }

    public function getInformationPage($id, $url) {
        if (!$id && !$url) throw new Exception("Please specify an id or url.", 1);

        $dao = new InformationPageDAO();
        return $dao->getInformationPage($id, $url);
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
        if (!$id) throw new Exception("Please specify an id.", 1);
         
        $dao = new InformationPageDAO();
        $dao->editInformationPage($id, $url, $title, $subtitle, $metaDescription, $metaTitle, $image, $sections);
    }

    public function addInformationPage() {
        $dao = new InformationPageDAO();
        $dao->addInformationPage();
    }

    public function deleteInformationPage($id) {
        if (!$id) throw new Exception("Please specify an id.", 1);

        $dao = new InformationPageDAO();
        $dao->deleteInformationPage($id);
    }

    public function addInformationSection($informationPageId) {
        if (!$informationPageId) throw new Exception("Please specify a page id.", 1);

        $dao = new InformationPageDAO();
        return $dao->addInformationSection($informationPageId);
    }

    public function deleteInformationSection($id) {
        if (!$id) throw new Exception("Please specify an id.", 1);

        $dao = new InformationPageDAO();
        return $dao->deleteInformationSection($id);
    }

    public function checkIfInformationPage($url) {
        $dao = new InformationPageDAO();
        return $dao->checkIfInformationPage($url);
    }
}
?>