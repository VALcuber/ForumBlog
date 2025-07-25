<?php
class SettingsModel extends Model{

    // Получить все настройки
    public function getSettings(){

        $sql = "SELECT section, name, value FROM settings";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $settings = [];
        foreach ($rows as $row) {
            $settings[$row['section']][$row['name']] = $row['value'];
        }
        return $settings;
    }

    // Получить одну секцию
    public function getSection($section){

        $sql = "SELECT name, value FROM settings WHERE section = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$section]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[$row['name']] = $row['value'];
        }
        return $result;
    }

    // Сохранить секцию (перезаписать все значения)
    public function saveSection($section, $data){

        foreach ($data as $name => $value) {
            $sql = "INSERT INTO settings (section, name, value) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE value = VALUES(value)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$section, $name, $value]);
        }
    }
}