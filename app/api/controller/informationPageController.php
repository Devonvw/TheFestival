<?php
require __DIR__ . '/../../service/informationPageService.php';

class APIInformationPageController
{
    private $informationPageService;

    // initialize services
    function __construct()
    {
        $this->informationPageService = new InformationPageService();
    }

    public function getInformationPages()
    {
        try {
            session_start();

            return json_encode($this->informationPageService->getInformationPages());
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function getInformationPage($id, $url)
    {
        try {
            session_start();

            return json_encode($this->informationPageService->getInformationPage($id, $url));
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function getHomePage()
    {
        try {
            session_start();

            return json_encode($this->informationPageService->getHomePage());
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function editHomePage()
    {
        try {
            $image = $_FILES ? ($_FILES["image"]["name"] ? $_FILES["image"] : false) : false;

            $this->informationPageService->editHomePage($_POST["title"], $_POST["subtitle"], $_POST["meta_description"], $_POST["meta_title"], json_decode($_POST["sections"]), $image);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function editInformationPage($id)
    {
        try {
            $image = $_FILES ? ($_FILES["image"]["name"] ? $_FILES["image"] : false) : false;

            $this->informationPageService->editInformationPage($id, $_POST["url"], $_POST["title"], $_POST["subtitle"], $_POST["meta_description"], $_POST["meta_title"], json_decode($_POST["sections"]), $image);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function addInformationPage()
    {
        try {
            $this->informationPageService->addInformationPage();
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function deleteInformationPage($id)
    {
        try {
            $this->informationPageService->deleteInformationPage($id);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function addInformationSection($informationPageId)
    {
        try {
            $this->informationPageService->addInformationSection($informationPageId);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }

    public function deleteInformationSection($id)
    {
        try {
            $this->informationPageService->deleteInformationSection($id);
        } catch (Exception $ex){
            http_response_code(500);
            if($ex->getCode() != 0) echo json_encode([ 'msg' => $ex->getMessage() ]);
        }
    }
}
?>