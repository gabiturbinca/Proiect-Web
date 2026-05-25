<?php

class JwtService {
    private const ALGO = 'HS256';
    private const TTL_SEC = 3600;
    public function __construct(private string $secret) {}

    public function encode(array $claims):string {
        $header = ['alg' => self::ALGO, 'typ' => 'JWT'];
        $now = time();
        $claims = array_merge($claims, ['iat' => $now, 'exp' => $now + self::TTL_SEC]);
        $h64 = self::base64UrlEncode(json_encode($header));
        $p64 = self::base64UrlEncode(json_encode($claims));

        $sig = hash_hmac('sha256', "$h64.$p64", $this->secret, true);
        $s64 = self::base64UrlEncode($sig);
        return "$h64.$p64.$s64";
    }

    public function decode(string $token): array {
        $parts = explode('.', $token);
        if(count($parts) != 3)
            throw new AuthException("Token format is invalid");
        [$h64, $p64, $s64] = $parts;

        $header = json_decode(self::base64UrlDecode($h64), true);
        if(!is_array($header))
            throw new AuthException("Invalid header");
        if (($header['alg'] ?? null) !== self::ALGO) 
            throw new AuthException("Invalid algorithm");
        if (($header['typ'] ?? null) !== 'JWT') 
            throw new AuthException("Invalid type");
        $expectedSignature = hash_hmac('sha256', "$h64.$p64", $this->secret, true );
        $sig = self::base64UrlDecode($s64);

        if(!hash_equals($sig, $expectedSignature))
            throw new AuthException("Invalid signature!");
        $payload = json_decode(self::base64UrlDecode($p64), true);
        if(!is_array($payload))
            throw new AuthException("Invalid signature format");
        if(!isset($payload['exp']) || time() >= $payload['exp'] )
            throw new AuthException("Token doesnt exist or is expired");
        return $payload;
    }

    private function base64UrlEncode(string $data): string {
        return rtrim(strtr(base64_encode($data), '+/','-_'), '=');
    }
    private function base64UrlDecode(string $data): string {
        $rest = strlen($data) % 4;
        if($rest === 1)
            throw new AuthException("Impossible length");
        return base64_decode(strtr($data, '-_', '+/'), true);
    }
}