<?php
// bookstore_web/app/models/Setting.php

class Setting {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAll() {
        $this->db->query("SELECT * FROM settings");
        $results = $this->db->resultSet();
        $settings = [];
        foreach ($results as $row) {
            $settings[$row->setting_key] = $row->setting_value;
        }
        return $settings;
    }

    public function update($key, $value) {
        $this->db->query("UPDATE settings SET setting_value = :value WHERE setting_key = :key");
        $this->db->bind(':value', $value);
        $this->db->bind(':key', $key);
        return $this->db->execute();
    }

    public function getByKey($key) {
        $this->db->query("SELECT setting_value FROM settings WHERE setting_key = :key");
        $this->db->bind(':key', $key);
        $row = $this->db->single();
        return $row ? $row->setting_value : null;
    }
}
