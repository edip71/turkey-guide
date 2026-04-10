<?php
// BaseModel sınıfı - Kalıtım için temel sınıf
abstract class BaseModel {
    protected $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    abstract public function save();
}
?>