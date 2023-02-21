<?php
    require_once("config.php");

    class MySQLDB {
        public $dbConn;

        public function open_connection() {
            $this->dbConn = mysqli_connect(RDS_HOSTNAME, RDS_USERNAME, RDS_PASSWORD, RDS_DB_NAME, RDS_PORT);
            if(mysqli_connect_errno()) {
                die( "Database connection error: ".mysqli_connect_error()."(".mysqli_connect_errno().")" );
            }
        }

        public function close_connection() {
            if(isset($this->dbConn)) {
                mysqli_close($this->dbConn);
                unset($this->dbConn);
            }
        }

        public function query($sql) {
            $result = mysqli_query($this->dbConn, $sql);
            if(!$result) {
                die("Database query error: ".mysqli_error($this->dbConn)." (".mysqli_errno($this->dbConn).")");
            }
            return $result;
        }

        function __construct(){
            $this->open_connection();
        }

    }

    $mydb = new MySQLDB();
?>
