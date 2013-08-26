<?php

require_once 'Thrift/Exception/TException.php';
require_once 'Thrift/Exception/TTransportException.php';
require_once 'Thrift/Transport/TTransport.php';
require_once 'Thrift/Transport/TSocket.php';
require_once 'Thrift/Transport/TBufferedTransport.php';
require_once 'Thrift/Protocol/TProtocol.php';
require_once 'Thrift/Protocol/TBinaryProtocol.php';
require_once 'Thrift/Type/TMessageType.php';
require_once 'Thrift/Type/TType.php';
require_once 'Thrift/Factory/TStringFuncFactory.php';
require_once 'Thrift/StringFunc/TStringFunc.php';
require_once 'Thrift/StringFunc/Core.php';


require_once 'Types.php';
require_once 'ANNMSService.php';

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\TBufferedTransport;

class ANNClient {

    private $_host;
    private $_port;
    private $_username;
    private $_password;
    private $_transport;
    private $_client;

    /**
     * 
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     */
    public function __construct($host, $port, $username, $password) {
        $this->_host = $host;
        $this->_port = $port;
        $this->_username = $username;
        $this->_password = $password;

        $socket = new TSocket($host, $this->_port);
        $this->_transport = new TBufferedTransport($socket);
        $protocol = new TBinaryProtocol($this->_transport);
        $this->_client = new annms\ANNMSServiceClient($protocol);
    }
    public function __destruct() {
        $this->close();
    }

    public function connect() {
        $this->_transport->open();
        $this->_client->connect($this->_username, $this->_password);
    }

    /**
     * 
     * @param string $query
     */
    public function query($query) {
        $this->_client->execute($query);
    }

    public function close() {
        $this->_transport->close();
    }

}

?>
