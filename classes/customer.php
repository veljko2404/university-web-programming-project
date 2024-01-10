<?php

    require_once 'person.php';

    class Customer extends Person {
        protected $discount;
        protected $conn;

        public function __construct(string $name, string $username, string $password, int $discount, $conn){
            $this->name = $name;
            $this->username = $username;
            $this->password = $password;
            $this->discount = $discount;
            $this->conn = $conn;
        }

        public function insertToDatabase(): bool {
            $this->password = md5($this->password);
            $q = "INSERT INTO customers(name, username, password, discount) VALUES('$this->name','$this->username','$this->password',$this->discount)";
            if($this->conn->query($q)){
                return true;
            } else {
                return false;
            }
        }

        public function validate(): string {
            if($this->name == "" || $this->username == "" || $this->password == ""){
                return "Fields can't be empty!";
            }

            if(strlen($this->password) < 6){
                return "Password must contain at least 6 characters!";
            }

            $q = "SELECT * FROM customers WHERE username = '$this->username'";
            $result = $this->conn->query($q);

            if($result->num_rows > 0){
                return "Username already exists!";
            }

            return "";
        }

        public function getDiscount(): string {
            return $this->discount;
        }
    }