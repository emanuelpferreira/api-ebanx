<?php
    class ResetController extends BaseController
    {
        public function process()
        {
            $this->unlinkFileData();
            $this->returnResponse(
                'OK',
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        }
    }