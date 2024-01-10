<?php
    
    require_once 'person.php';

    class Seller extends Person {
        protected $sallary;
        protected $contract_duration_months;
        protected $conn;
        protected $menager_id;

        public function __construct(string $username, string $password, int $sallary, int $contract_duration_months, $menager_id, $conn){
            $this->username = $username;
            $this->password = $password;
            $this->sallary = $sallary;
            $this->contract_duration_months = $contract_duration_months;
            $this->conn = $conn;
            $this->menager_id = $menager_id;
        }

        public function addToDatabase(): bool {
            $date = date("Y/m/d");
            $q = "INSERT INTO sellers(username,password,sallary,work_from,contract_duration_months,menager_id) VALUES('$this->username','$this->password',$this->sallary,'$date',$this->contract_duration_months,$this->menager_id)";
            if($this->conn->query($q)){
                return true;
            } else {
                return false;
            }
        }

        public function getSallary(): string {
            return $this->sallary;
        }
        
        public function getContractDurationMonths(): string {
            return $this->contract_duration_months;
        }
    }