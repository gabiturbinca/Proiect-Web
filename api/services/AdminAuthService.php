<?php

class AdminAuthService {

    public function __construct(
        private UserRepository $userRepository,
        private PasswordResetRequestRepository $resetRequestRepository,
    ) {}

    public function resetUserPassword(int $userId): AdminResetDTO {
        $user = $this->userRepository->findById($userId);
        $tempPass = bin2hex(random_bytes(8));
        $hash = password_hash($tempPass, PASSWORD_BCRYPT);

        $this->userRepository->updatePassword($userId, $hash);
        $this->userRepository->setMustChangePassword($userId, true);

        return new AdminResetDTO($userId, $tempPass);
    }

    public function listPendingResets(int $page, int $limit): array {
        $offset = ($page - 1) * $limit;
        $requests = $this->resetRequestRepository->findPending($limit, $offset);
        return [
            'requests' => array_map(fn(PasswordResetRequest $r) => $this->toDTO($r), $requests),
            'requests_count' => $this->resetRequestRepository->countPending(),
        ];
    }

    public function approveResetRequest(int $requestId, int $adminId): AdminResetDTO {
        $request = $this->resetRequestRepository->findById($requestId);
        if ($request === null) {
            throw new NotFoundException("Reset request not found");
        }
        if ($request->getStatus() !== 'pending') {
            throw new ConflictException(['request' => ['Request is not pending']]);
        }

        $result = $this->resetUserPassword($request->getUserId());
        $this->resetRequestRepository->markApproved($requestId, $adminId);

        return $result;
    }

    public function denyResetRequest(int $requestId, int $adminId): void {
        $request = $this->resetRequestRepository->findById($requestId);
        if ($request === null) {
            throw new NotFoundException("Reset request not found");
        }
        if ($request->getStatus() !== 'pending') {
            throw new ConflictException(['request' => ['Request is not pending']]);
        }
        $this->resetRequestRepository->markDenied($requestId, $adminId);
    }

    private function toDTO(PasswordResetRequest $r): PasswordResetRequestDTO {
        return new PasswordResetRequestDTO(
            id:          $r->getId(),
            userId:      $r->getUserId(),
            username:    $r->getUsername() ?? '',
            status:      $r->getStatus(),
            requestedAt: $r->getRequestedAt(),
            processedAt: $r->getProcessedAt(),
            message:     $r->getMessage(),
        );
    }
}
