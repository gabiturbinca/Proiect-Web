<?php

class AdminMiddleware implements Middleware {
    public function __construct(private Container $container) {}

    public function handle(): void {
        $user = $this->container->get(CurrentUserDTO::class);
        if ($user->role !== 'admin')
            throw new AuthException("Admin access required");
    }
}
