<?php

class AdminAuthController {

    public function __construct(
        private AdminAuthService $adminAuthService,
        private CurrentUserDTO $current,
    ) {}

    public function resetPassword(int $userId): AdminResetDTO {
        return $this->adminAuthService->resetUserPassword($userId);
    }

    public function listPendingResets(): array {
        $pageNumber = max(1, (int) ($_GET['pageNumber'] ?? 1));
        $elemNumber = max(1, min(100, (int) ($_GET['elemNumber'] ?? 20)));
        return $this->adminAuthService->listPendingResets($pageNumber, $elemNumber);
    }

    public function approveReset(int $requestId): AdminResetDTO {
        return $this->adminAuthService->approveResetRequest($requestId, $this->current->id);
    }

    public function denyReset(int $requestId): array {
        $this->adminAuthService->denyResetRequest($requestId, $this->current->id);
        return ['message' => 'Reset request denied'];
    }
}
