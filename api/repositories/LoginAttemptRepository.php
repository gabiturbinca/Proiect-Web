<?php

class LoginAttemptRepository {

    public function __construct(private PDO $db) {}

    public function record(string $ip) {
        $stmt = $this->db->prepare(
            "INSERT INTO login_attempts(ip_address)
            VALUES( ? )
        ");
        $stmt->execute([$ip]);
    }
    public function countByIp(string $ip):int {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM login_attempts 
            WHERE ip_address = ? 
            AND attempted_at > NOW() - INTERVAL '5 minutes'
        ");
        $stmt->execute([$ip]);
        return (int)$stmt->fetchColumn();
    }

    public function clearByIp(string $ip) {
        $stmt = $this->db->prepare(
            "DELETE FROM login_attempts 
            WHERE ip_address = ?
        ");
        $stmt->execute([$ip]);
    }

    public function removeOld(int $exptime) {}
}