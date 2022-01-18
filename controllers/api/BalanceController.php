<?php
    class BalanceController extends BaseController
    {
        public function __construct()
        {
            $this->_session = $_SESSION;
        }

        public function process() {
            $query_strings = $this->getRequestParams();
            $this->return_balance($query_strings);
        }

        public function return_balance($params) {
            $account = $params['account_id'];
            if(!isset($this->_session['balances'])) {
                $this->returnResponse(
                    null,
                    array('Content-Type: application/json', 'HTTP/1.1 404 OK')
                );
            } else {
                $process = !1;
                foreach($this->_session['balances'] as $index => $balance) {
                    if($balance['id'] == $account) {
                        $process = !0;
                        $this->returnResponse(
                            $balance['balance'],
                            array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                        );
                    }
                }

                if(!$process) {
                    $this->returnResponse(
                        null,
                        array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                    );
                }
            }
        }
    }