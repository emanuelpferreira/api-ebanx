<?php
    class ResetController extends BaseController
    {
        public function process()
        {
            $this->unlinkFileData();
            $this->returnResponse(
                '',
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
    }