<?php
    
    require_once 'person.php';
    
    class Menager extends Person {
        protected $sallary;
        protected $conn;

        public function __construct(string $name, string $username, string $password, int $sallary, $conn){
            $this->name = $name;
            $this->username = $username;
            $this->password = $password;
            $this->sallary = $sallary;
            $this->conn = $conn;
        }

        public function getSallary(): string {
            return $this->sallary;
        }

        public function addToDatabase(): bool {
            $q = "INSERT INTO menagers(name,username,password,sallary) VALUES('$this->name','$this->username','$this->password',$this->sallary)";
            if($this->conn->query($q)){
                return true;
            } else {
                return false;
            }
        }
    }