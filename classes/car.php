<?php

    class Car{
        protected $make;
        protected $model;
        protected $price;
        protected $year;
        protected $number_of_available;
        protected $image;
        protected $conn;

        public function __construct($make, $model, $price, $year, $number_of_available, $image, $conn){
            $this->make = $make;
            $this->model = $model;
            $this->price = $price;
            $this->year = $year;
            $this->number_of_available = $number_of_available;
            $this->image = $image;
            $this->conn = $conn;
        }

        public function insertToDatabase(): bool {
            $q = "INSERT INTO cars(make, model, year, price, number_of_available, image) VALUES('$this->make','$this->model',$this->year,$this->price,$this->number_of_available,'$this->image')";
            if($this->conn->query($q)){
                return true;
            } else {
                return false;
            }
        }
    }