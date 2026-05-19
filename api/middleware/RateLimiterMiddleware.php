<?php


class RateLimiterMiddleware implements Middleware {

    private const NR_TRY = 5;
    private const TIMEOUT = 300;
    public function __construct(private LoginAttemptRepository $logRepo) {}
    #[Override]
    public function handle(): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        if($this->logRepo->countByIp($ip) >= self::NR_TRY) {
            throw new TooManyRequestsException(self::TIMEOUT);
        }
        $this->logRepo->record($ip);
    }


}