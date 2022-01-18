<?php
    class BalanceController extends BaseController
    {
        public function __construct()
        {

        }

        public function process() {
            $query_strings = $this->getRequestParams();
            $this->return_balance($query_strings);
        }

        public function return_balance($params) {
            $account = $params['account_id'];
            $data = $this->getFileData();

            if(!$data) {
                $this->returnResponse(
                    '0',
                    array('Content-Type: application/json', 'HTTP/1.1 404 OK')
                );
            } else {
                $process = !1;
                foreach($data->balances as $index => $balance) {
                    if($balance->id == $account) {
                        $process = !0;
                        $this->returnResponse(
                            json_encode($balance->balance),
                            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                        );
                    }
                }

                if(!$process) {
                    $this->returnResponse(
                        '0',
                        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                    );
                }
            }
        }
    }