<?php
    class EventController extends BaseController
    {
        public function __construct()
        {
            
        }

        public function process() {
            $query_strings = $this->getRequestParams();
            $action = strval($query_strings['type']);
            $this->$action($query_strings);
        }

        public function deposit($params) {
            $account = $params['destination'];
            $amount = $params['amount'];

            $data = $this->getFileData();

            if(!$data) {
                
                $data['balances'] = [];
                $balance = ['id' => $account, 'balance' => $amount];
                array_push($data['balances'], $balance);
                $this->setFileData($data);
                $response['destination'] = $balance;

                $this->returnResponse(
                    $response,
                    array('Content-Type: application/json', 'HTTP/1.1 201 OK')
                );
            } else {
                $balances = $data->balances;

                foreach($balances as $index => $balance) {
                    if($balance->id == $account) {
                        $balance->balance += $amount; 
                        $response['destination'] = $balance;

                        $this->setFileData($data);

                        $this->returnResponse(
                            $response,
                            array('Content-Type: application/json', 'HTTP/1.1 201 OK')
                        );
                    }
                }
            }
        }

        public function withdraw() {
            $account = $params['origin'];
            $amount = $params['amount'];

            $data = $this->getFileData();

            if(!$data) {
                $this->returnResponse(
                    '',
                    array('Content-Type: application/json', 'HTTP/1.1 404 OK')
                );
            } else {
                $balances = $data->balances;
                $process = !1;

                foreach($balances as $index => $balance) {
                    if($balance->id == $account) {
                        $process++;
                        $balance->balance -= $amount; 
                        $response['origin'] = $balance;

                        $this->setFileData($data);

                        $this->returnResponse(
                            $response,
                            array('Content-Type: application/json', 'HTTP/1.1 201 OK')
                        );
                    }
                }

                if(!$process) {
                    $this->returnResponse(
                        '',
                        array('Content-Type: application/json', 'HTTP/1.1 404 OK')
                    );
                }
            }
        }

        public function transfer() {
            $origin = $params['origin'];
            $destination = $params['destination'];
            $amount = $params['amount'];

            $data = $this->getFileData();

            if(!$data) {
                $this->returnResponse(
                    '',
                    array('Content-Type: application/json', 'HTTP/1.1 404 OK')
                );
            } else {
                $balances = $data->balances;
                $process = !1;

                foreach($balances as $index => $balance) {
                    if($balance->id == $origin) {
                        $process++;
                        $indiceorigem = $index;
                    }
                }

                foreach($balances as $index => $balance) {
                    if($balance->id == $destination) {
                        $process++;
                        $indicedestino = $index;
                    }
                }


                if(!$process || $process != 2) {
                    $this->returnResponse(
                        '',
                        array('Content-Type: application/json', 'HTTP/1.1 404 OK')
                    );
                } else {
                    $data->balances[$indiceorigem]->balance -= $amount; 
                    $data->balances[$indicedestino]->balance -= $amount; 
                    $response['origin'] = $data->balances[$indiceorigem];
                    $response['destination'] = $data->balances[$indicedestino];

                    $this->setFileData($data);
                    $this->returnResponse(
                        $response,
                        array('Content-Type: application/json', 'HTTP/1.1 201 OK')
                    );
                }
            }
        }
    }