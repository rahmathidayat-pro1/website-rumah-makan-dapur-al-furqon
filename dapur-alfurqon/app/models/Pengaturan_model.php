<?php

class Pengaturan_model {
    private $table = 'pengaturan';
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function getAllPengaturan()
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' ORDER BY key_pengaturan');
        return $this->db->resultSet();
    }

    public function getPengaturanByKey($key)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE key_pengaturan = :key');
        $this->db->bind('key', $key);
        return $this->db->single();
    }

    public function getPengaturanValue($key)
    {
        $pengaturan = $this->getPengaturanByKey($key);
        return $pengaturan ? $pengaturan['value_pengaturan'] : '';
    }

    public function updatePengaturan($key, $value)
    {
        // Cek apakah key sudah ada
        $existing = $this->getPengaturanByKey($key);
        
        if ($existing) {
            // Update existing
            $query = "UPDATE " . $this->table . " SET value_pengaturan = :value WHERE key_pengaturan = :key";
            $this->db->query($query);
            $this->db->bind('value', $value);
            $this->db->bind('key', $key);
        } else {
            // Insert new
            $query = "INSERT INTO " . $this->table . " (key_pengaturan, value_pengaturan) VALUES (:key, :value)";
            $this->db->query($query);
            $this->db->bind('key', $key);
            $this->db->bind('value', $value);
        }
        
        $this->db->execute();
        return $this->db->rowCount();
    }

    public function updateMultiplePengaturan($data)
    {
        $success = 0;
        foreach ($data as $key => $value) {
            if ($this->updatePengaturan($key, $value) > 0) {
                $success++;
            }
        }
        return $success;
    }

    public function getPengaturanForProfile()
    {
        $keys = [
            'sejarah', 'visi', 'misi', 
            'jam_senin_jumat', 'jam_sabtu', 'jam_minggu',
            'alamat', 'telepon', 'email', 'whatsapp', 'whatsapp_display',
            'pakasir_project', 'pakasir_api_key'
        ];
        
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->getPengaturanValue($key);
        }
        
        return $result;
    }

    public function getPakasirConfig()
    {
        return [
            'project' => $this->getPengaturanValue('pakasir_project'),
            'api_key' => $this->getPengaturanValue('pakasir_api_key')
        ];
    }

    public function getMisiArray()
    {
        $misi = $this->getPengaturanValue('misi');
        return $misi ? explode("\n", $misi) : [];
    }
}