<?php
require __DIR__ . '/../../service/instagramService.php';

class APIInstagramController
{
    private $instagramService;

    // initialize services
    function __construct()
    {
        $this->instagramService = new InstagramService();
    }

    public function getInstagramFeed()
    {
        try {
            return $this->instagramService->getInstagramFeed();
        } catch (Exception $ex) {
            http_response_code(500);
            if ($ex->getCode() != 0) echo json_encode(['msg' => $ex->getMessage()]);
        }
    }
}