<?php
class CustomSessionHandler extends SessionHandler
{
    private $logFile;

    public function __construct($logFile = '/var/log/php_sessions.log')
    {
        $this->logFile = $logFile;
    }

    private function log($message)
    {
        $date = date('Y-m-d H:i:s');
        file_put_contents($this->logFile, "[$date] $message\n", FILE_APPEND);
    }

    // public function open($savePath, $sessionName)
    // {
    //     $this->log("Session opened: save_path = $savePath, session_name = $sessionName");
    //     return parent::open($savePath, $sessionName);
    // }
    public function open(string $savePath, string $sessionName): bool
    {
        $this->log("Session opened: save_path = $savePath, session_name = $sessionName");
        return parent::open($savePath, $sessionName);
    }

    // public function close(string $savePath, string $sessionName): bool
    // {
    //     $this->log("Session closed: save_path = $savePath, session_name = $sessionName");
    //     return parent::close($savePath, $sessionName);
    // }

    public function read(string $sessionId): string
    {
        $this->log("Session read: session_id = $sessionId");
        return parent::read($sessionId);
    }

    public function write($sessionId, $data): bool
    {
        $this->log("Session write: session_id = $sessionId, data_length = " . strlen($data));
        return parent::write($sessionId, $data);
    }

    public function destroy($sessionId): bool
    {
        $this->log("Session destroyed: session_id = $sessionId");
        return parent::destroy($sessionId);
    }

    // public function gc($maxlifetime)
    // {
    //     $this->log("Session garbage collection triggered: max_lifetime = $maxlifetime");
    //     return parent::gc($maxlifetime);
    // }
}
