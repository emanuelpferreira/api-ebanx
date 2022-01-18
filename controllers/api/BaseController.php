<?php
    class BaseController
    {
        /**
         * __call default method.
         */
        public function __call($name, $arguments)
        {
            $this->returnResponse(null, array('HTTP/1.1 404 Not Found'));
        }

        /**
         * Get URI elements
         * 
         * @return array
         */
        protected function getUriElements()
        {
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $uri = explode( '/', $uri );

            return $uri;
        }

        /**
         * Get request params.
         * 
         * @return array
         */
        protected function getRequestParams()
        {
            $request_type = $_SERVER['REQUEST_METHOD'];
            if($request_type == 'GET') {
                parse_str($_SERVER['QUERY_STRING'], $query_strings);
                return $query_strings;
            } else {
                $content = trim(file_get_contents("php://input"));
                $query_strings = json_decode($content, true); 

                return $query_strings;
            }
        }

        /**
         * Return API response.
         *
         * @param mixed  $data
         * @param string $headers
         */
        protected function returnResponse($data, $headers=[])
        {
            // header_remove('Set-Cookie');

            if (is_array($headers) && count($headers)) {
                foreach ($headers as $headers) {
                    header($headers);
                }
            }

            die(json_encode($data));
        }

        /** 
         * Return DATA session
         * 
         */
        protected function getFileData()
        {
            $pathfile = __DIR__. '/../../session/balance.json';
            if(!file_exists($pathfile)) {
                return !1;
            } else {
                return json_decode(file_get_contents($pathfile));
            }
        }

        /** 
         * SET DATA session
         * 
         */
        protected function setFileData($data)
        {
            $pathfile = __DIR__. '/../../session/balance.json';
            file_put_contents($pathfile, json_encode($data));
        }   

        /** 
         * Delete DATA session
         * 
         */
        protected function unlinkFileData()
        {
            $pathfile = __DIR__. '/../../session/balance.json';
            @unlink($pathfile);
        }
    }