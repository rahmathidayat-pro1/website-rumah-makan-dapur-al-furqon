<?php

class PakasirService {
    private $project;
    private $apiKey;
    private $baseUrl = 'https://app.pakasir.com/api';

    public function __construct()
    {
        // Coba ambil dari database dulu
        $this->loadConfigFromDatabase();
        
        // Fallback ke default jika tidak ada di database
        if (empty($this->project)) {
            $this->project = 'dapur-al-furqon';
        }
        if (empty($this->apiKey)) {
            $this->apiKey = 'mQt6jshUwiQUEQAanUb9u21ByTb3nGCG';
        }
    }

    private function loadConfigFromDatabase()
    {
        try {
            $db = new Database();
            
            // Get project
            $db->query("SELECT value_pengaturan FROM pengaturan WHERE key_pengaturan = 'pakasir_project'");
            $result = $db->single();
            if ($result && !empty($result['value_pengaturan'])) {
                $this->project = $result['value_pengaturan'];
            }
            
            // Get API key
            $db->query("SELECT value_pengaturan FROM pengaturan WHERE key_pengaturan = 'pakasir_api_key'");
            $result = $db->single();
            if ($result && !empty($result['value_pengaturan'])) {
                $this->apiKey = $result['value_pengaturan'];
            }
        } catch (Exception $e) {
            error_log("PakasirService: Failed to load config from database - " . $e->getMessage());
        }
    }

    public function createTransaction($orderId, $amount, $method = 'qris')
    {
        $url = $this->baseUrl . '/transactioncreate/' . $method;
        
        $data = [
            'project' => $this->project,
            'order_id' => $orderId,
            'amount' => (int)$amount,
            'api_key' => $this->apiKey
        ];

        $response = $this->makeRequest($url, $data);
        
        if ($response && isset($response['payment'])) {
            return [
                'success' => true,
                'data' => $response['payment']
            ];
        }

        return [
            'success' => false,
            'message' => 'Failed to create transaction',
            'response' => $response
        ];
    }

    public function cancelTransaction($orderId, $amount)
    {
        $url = $this->baseUrl . '/transactioncancel';
        
        $data = [
            'project' => $this->project,
            'order_id' => $orderId,
            'amount' => (int)$amount,
            'api_key' => $this->apiKey
        ];

        $response = $this->makeRequest($url, $data);
        
        return [
            'success' => $response !== false,
            'response' => $response
        ];
    }

    public function simulatePayment($orderId, $amount)
    {
        $url = $this->baseUrl . '/paymentsimulation';
        
        $data = [
            'project' => $this->project,
            'order_id' => $orderId,
            'amount' => (int)$amount,
            'api_key' => $this->apiKey
        ];

        $response = $this->makeRequest($url, $data);
        
        return [
            'success' => $response !== false,
            'response' => $response
        ];
    }

    private function makeRequest($url, $data)
    {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json'
            ],
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);

        if ($error) {
            error_log("Pakasir API Error: " . $error);
            return false;
        }

        if ($httpCode !== 200) {
            error_log("Pakasir API HTTP Error: " . $httpCode . " - " . $response);
            return false;
        }

        $decoded = json_decode($response, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Pakasir API JSON Error: " . json_last_error_msg());
            return false;
        }

        return $decoded;
    }

    public function generateQRCode($qrString)
    {
        // QRIS string membutuhkan ukuran QR yang lebih besar dan error correction tinggi
        // karena string-nya panjang (biasanya 200+ karakter)
        
        // QR Server API dengan parameter optimal untuk QRIS:
        // - size: 400x400 untuk keterbacaan yang lebih baik
        // - ecc: H (High error correction - 30% recovery)
        // - format: png untuk kualitas terbaik
        // - margin: 2 untuk border yang cukup
        $qrServerUrl = "https://api.qrserver.com/v1/create-qr-code/?" . http_build_query([
            'size' => '400x400',
            'data' => $qrString,
            'ecc' => 'M',  // Medium error correction (15% recovery) - balance antara size dan reliability
            'margin' => '2',
            'format' => 'png'
        ]);
        
        return $qrServerUrl;
    }

    public function getQRCodeServices($qrString)
    {
        // Return all available QR code services for fallback
        // Dengan parameter yang dioptimalkan untuk QRIS
        return [
            'qrserver' => "https://api.qrserver.com/v1/create-qr-code/?" . http_build_query([
                'size' => '400x400',
                'data' => $qrString,
                'ecc' => 'M',
                'margin' => '2',
                'format' => 'png'
            ]),
            'quickchart' => "https://quickchart.io/qr?" . http_build_query([
                'text' => $qrString,
                'size' => '400',
                'ecLevel' => 'M',
                'margin' => '2',
                'format' => 'png'
            ]),
            // Google Charts deprecated, tapi masih bisa sebagai fallback terakhir
            'googlecharts' => "https://chart.googleapis.com/chart?" . http_build_query([
                'chs' => '400x400',
                'cht' => 'qr',
                'chl' => $qrString,
                'chld' => 'M|2'  // Error correction M, margin 2
            ])
        ];
    }

    public function generateQRCodeBase64($qrString)
    {
        // Alternative: Generate base64 QR code for offline use
        try {
            $url = $this->generateQRCode($qrString);
            
            // Set context untuk timeout
            $context = stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'user_agent' => 'Mozilla/5.0 (compatible; DapurAlFurqon/1.0)'
                ]
            ]);
            
            $imageData = @file_get_contents($url, false, $context);
            
            if ($imageData !== false) {
                return 'data:image/png;base64,' . base64_encode($imageData);
            }
        } catch (Exception $e) {
            error_log("QR Code generation error: " . $e->getMessage());
        }
        
        // Fallback: return URL
        return $this->generateQRCode($qrString);
    }

    public function formatExpiredTime($expiredAt)
    {
        try {
            // Handle both Pakasir format and MySQL format with proper timezone
            $localTimezone = new DateTimeZone('Asia/Jakarta');
            
            // If it's Pakasir format (with Z), parse as UTC first
            if (strpos($expiredAt, 'Z') !== false || strpos($expiredAt, 'T') !== false) {
                $expired = new DateTime($expiredAt, new DateTimeZone('UTC'));
                $expired->setTimezone($localTimezone);
            } else {
                // MySQL format, assume local timezone
                $expired = new DateTime($expiredAt, $localTimezone);
            }
            
            $now = new DateTime('now', $localTimezone);
            
            if ($expired <= $now) {
                return 'Expired';
            }
            
            $diff = $now->diff($expired);
            
            if ($diff->h > 0) {
                return $diff->h . ' jam ' . $diff->i . ' menit';
            } else {
                return $diff->i . ' menit ' . $diff->s . ' detik';
            }
        } catch (Exception $e) {
            error_log("formatExpiredTime error: " . $e->getMessage() . " for datetime: " . $expiredAt);
            return 'Invalid time';
        }
    }

    public function convertToMySQLDateTime($pakasirDateTime)
    {
        try {
            // Pakasir format: 2025-12-19T17:45:10.739993889Z (UTC)
            // MySQL format: 2025-12-19 17:45:10 (Local timezone)
            
            // Create DateTime object with UTC timezone
            $dateTime = new DateTime($pakasirDateTime, new DateTimeZone('UTC'));
            
            // Convert to local timezone (Asia/Jakarta for Indonesia)
            $localTimezone = new DateTimeZone('Asia/Jakarta');
            $dateTime->setTimezone($localTimezone);
            
            return $dateTime->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            // Fallback: 15 minutes from now in local timezone
            $fallback = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
            $fallback->add(new DateInterval('PT15M'));
            return $fallback->format('Y-m-d H:i:s');
        }
    }
}