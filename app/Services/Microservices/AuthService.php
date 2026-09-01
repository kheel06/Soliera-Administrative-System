<?php

namespace App\Services\Microservices;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AuthService extends AbstractMicroservice
{
    protected string $serviceName = 'auth';

    /**
     * Authenticate user credentials
     */
    public function authenticate(array $credentials): array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($credentials) {
                $response = $this->post('/auth/authenticate', $credentials);
                $this->logCommunication('authenticate', $credentials, $response);
                return $response;
            },
            "auth_authenticate_" . md5(json_encode($credentials))
        );
    }

    /**
     * Authorize user action
     */
    public function authorize(string $token, string $action, array $context = []): array
    {
        return $this->post('/auth/authorize', [
            'token' => $token,
            'action' => $action,
            'context' => $context
        ]);
    }

    /**
     * Generate JWT token
     */
    public function generateToken(array $userData): array
    {
        return $this->post('/auth/tokens', $userData);
    }

    /**
     * Validate JWT token
     */
    public function validateToken(string $token): array
    {
        return $this->post('/auth/validate', ['token' => $token]);
    }

    /**
     * Refresh JWT token
     */
    public function refreshToken(string $refreshToken): array
    {
        return $this->post('/auth/refresh', ['refresh_token' => $refreshToken]);
    }

    /**
     * Revoke token
     */
    public function revokeToken(string $token): array
    {
        return $this->post('/auth/revoke', ['token' => $token]);
    }

    /**
     * Get user profile
     */
    public function getUserProfile(int $userId): array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($userId) {
                $response = $this->get("/auth/users/{$userId}");
                $this->logCommunication('get_user_profile', ['user_id' => $userId], $response);
                return $response;
            },
            "auth_user_profile_{$userId}",
            1800 // Cache for 30 minutes
        );
    }

    /**
     * Update user profile
     */
    public function updateUserProfile(int $userId, array $data): array
    {
        $response = $this->put("/auth/users/{$userId}", $data);
        $this->logCommunication('update_user_profile', ['user_id' => $userId, 'data' => $data], $response);
        
        // Clear cache
        Cache::forget("auth_user_profile_{$userId}");
        
        return $response;
    }

    /**
     * Get user permissions
     */
    public function getUserPermissions(int $userId): array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($userId) {
                return $this->get("/auth/users/{$userId}/permissions");
            },
            "auth_user_permissions_{$userId}",
            3600 // Cache for 1 hour
        );
    }

    /**
     * Check user permission
     */
    public function checkPermission(int $userId, string $permission): array
    {
        return $this->post("/auth/users/{$userId}/check-permission", [
            'permission' => $permission
        ]);
    }

    /**
     * Get user roles
     */
    public function getUserRoles(int $userId): array
    {
        return $this->executeWithCircuitBreaker(
            function () use ($userId) {
                return $this->get("/auth/users/{$userId}/roles");
            },
            "auth_user_roles_{$userId}",
            3600 // Cache for 1 hour
        );
    }

    /**
     * Assign role to user
     */
    public function assignRole(int $userId, string $role): array
    {
        $response = $this->post("/auth/users/{$userId}/roles", ['role' => $role]);
        
        // Clear cache
        Cache::forget("auth_user_roles_{$userId}");
        Cache::forget("auth_user_permissions_{$userId}");
        
        return $response;
    }

    /**
     * Remove role from user
     */
    public function removeRole(int $userId, string $role): array
    {
        $response = $this->delete("/auth/users/{$userId}/roles/{$role}");
        
        // Clear cache
        Cache::forget("auth_user_roles_{$userId}");
        Cache::forget("auth_user_permissions_{$userId}");
        
        return $response;
    }

    /**
     * Create user
     */
    public function createUser(array $userData): array
    {
        $response = $this->post('/auth/users', $userData);
        $this->logCommunication('create_user', $userData, $response);
        return $response;
    }

    /**
     * Update user
     */
    public function updateUser(int $userId, array $data): array
    {
        $response = $this->put("/auth/users/{$userId}", $data);
        $this->logCommunication('update_user', ['user_id' => $userId, 'data' => $data], $response);
        
        // Clear cache
        Cache::forget("auth_user_profile_{$userId}");
        
        return $response;
    }

    /**
     * Delete user
     */
    public function deleteUser(int $userId): bool
    {
        $response = $this->delete("/auth/users/{$userId}");
        $this->logCommunication('delete_user', ['user_id' => $userId], $response);
        
        // Clear cache
        Cache::forget("auth_user_profile_{$userId}");
        Cache::forget("auth_user_roles_{$userId}");
        Cache::forget("auth_user_permissions_{$userId}");
        
        return $response['success'] ?? false;
    }

    /**
     * Search users
     */
    public function searchUsers(array $filters = [], int $page = 1, int $limit = 20): array
    {
        $params = array_merge($filters, ['page' => $page, 'limit' => $limit]);
        
        return $this->executeWithCircuitBreaker(
            function () use ($params) {
                $response = $this->get('/auth/users/search', $params);
                $this->logCommunication('search_users', $params, $response);
                return $response;
            },
            "auth_user_search_" . md5(json_encode($params)),
            300 // Cache for 5 minutes
        );
    }

    /**
     * Get authentication statistics
     */
    public function getAuthStats(array $filters = []): array
    {
        return $this->get('/auth/stats', $filters);
    }

    /**
     * Get active sessions
     */
    public function getActiveSessions(int $userId = null): array
    {
        $params = $userId ? ['user_id' => $userId] : [];
        return $this->get('/auth/sessions', $params);
    }

    /**
     * Revoke user sessions
     */
    public function revokeSessions(int $userId): array
    {
        return $this->post("/auth/users/{$userId}/revoke-sessions");
    }

    /**
     * Enable multi-factor authentication
     */
    public function enableMFA(int $userId): array
    {
        return $this->post("/auth/users/{$userId}/mfa/enable");
    }

    /**
     * Disable multi-factor authentication
     */
    public function disableMFA(int $userId): array
    {
        return $this->post("/auth/users/{$userId}/mfa/disable");
    }

    /**
     * Verify MFA code
     */
    public function verifyMFA(int $userId, string $code): array
    {
        return $this->post("/auth/users/{$userId}/mfa/verify", [
            'code' => $code
        ]);
    }

    /**
     * Get authentication logs
     */
    public function getAuthLogs(array $filters = []): array
    {
        return $this->get('/auth/logs', $filters);
    }

    /**
     * Lock user account
     */
    public function lockUser(int $userId, string $reason): array
    {
        return $this->post("/auth/users/{$userId}/lock", [
            'reason' => $reason
        ]);
    }

    /**
     * Unlock user account
     */
    public function unlockUser(int $userId): array
    {
        return $this->post("/auth/users/{$userId}/unlock");
    }

    /**
     * Get password reset token
     */
    public function getPasswordResetToken(string $email): array
    {
        return $this->post('/auth/password-reset/token', [
            'email' => $email
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(string $token, string $newPassword): array
    {
        return $this->post('/auth/password-reset', [
            'token' => $token,
            'password' => $newPassword
        ]);
    }

    /**
     * Change password
     */
    public function changePassword(int $userId, string $currentPassword, string $newPassword): array
    {
        return $this->post("/auth/users/{$userId}/change-password", [
            'current_password' => $currentPassword,
            'new_password' => $newPassword
        ]);
    }
}
