<?php

namespace Tests\Feature\Api;

use App\Models\DeptAccount;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTokenTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful token generation with email
     */
    public function test_can_generate_token_with_email(): void
    {
        // Create a department account with hashed password
        $deptAccount = DeptAccount::create([
            'Dept_id' => 'TEST001',
            'dept_name' => 'Test Department',
            'employee_name' => 'Test User',
            'employee_id' => 'A250502',
            'email' => 'test@example.com',
            'role' => 'Staff',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/token', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'token',
                    'token_name',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'employee_id',
                        'department',
                        'role',
                    ],
                    'expires_at',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Token generated successfully',
            ]);

        // Verify token is present and not empty
        $this->assertNotEmpty($response->json('data.token'));
    }

    /**
     * Test successful token generation with employee_id
     */
    public function test_can_generate_token_with_employee_id(): void
    {
        // Create a department account
        $deptAccount = DeptAccount::create([
            'Dept_id' => 'TEST002',
            'dept_name' => 'Test Department',
            'employee_name' => 'Test User 2',
            'employee_id' => 'A250503',
            'email' => 'test2@example.com',
            'role' => 'Manager',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/token', [
            'email' => 'A250503', // Using employee_id as identifier
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'user' => [
                        'employee_id' => 'A250503',
                    ],
                ],
            ]);
    }

    /**
     * Test token generation fails with wrong password
     */
    public function test_token_generation_fails_with_wrong_password(): void
    {
        $deptAccount = DeptAccount::create([
            'Dept_id' => 'TEST003',
            'dept_name' => 'Test Department',
            'employee_name' => 'Test User 3',
            'employee_id' => 'A250504',
            'email' => 'test3@example.com',
            'role' => 'Staff',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/token', [
            'email' => 'test3@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid credentials - Wrong password',
            ]);
    }

    /**
     * Test token generation fails with non-existent user
     */
    public function test_token_generation_fails_with_nonexistent_user(): void
    {
        $response = $this->postJson('/api/auth/token', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid credentials - User not found',
            ]);
    }

    /**
     * Test token generation fails with inactive account
     */
    public function test_token_generation_fails_with_inactive_account(): void
    {
        $deptAccount = DeptAccount::create([
            'Dept_id' => 'TEST004',
            'dept_name' => 'Test Department',
            'employee_name' => 'Test User 4',
            'employee_id' => 'A250505',
            'email' => 'test4@example.com',
            'role' => 'Staff',
            'status' => 'inactive',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->postJson('/api/auth/token', [
            'email' => 'test4@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Account is not active',
            ]);
    }

    /**
     * Test token generation with custom token name
     */
    public function test_can_generate_token_with_custom_name(): void
    {
        $deptAccount = DeptAccount::create([
            'Dept_id' => 'TEST005',
            'dept_name' => 'Test Department',
            'employee_name' => 'Test User 5',
            'employee_id' => 'A250506',
            'email' => 'test5@example.com',
            'role' => 'Staff',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        $tokenName = 'My Custom Token';

        $response = $this->postJson('/api/auth/token', [
            'email' => 'test5@example.com',
            'password' => 'password123',
            'token_name' => $tokenName,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'token_name' => $tokenName,
                ],
            ]);
    }

    /**
     * Test validation errors for missing fields
     */
    public function test_validation_errors_for_missing_fields(): void
    {
        $response = $this->postJson('/api/auth/token', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * Test that token can be used for authenticated requests
     */
    public function test_generated_token_can_be_used_for_authentication(): void
    {
        $deptAccount = DeptAccount::create([
            'Dept_id' => 'TEST006',
            'dept_name' => 'Test Department',
            'employee_name' => 'Test User 6',
            'employee_id' => 'A250507',
            'email' => 'test6@example.com',
            'role' => 'Staff',
            'status' => 'active',
            'password' => Hash::make('password123'),
        ]);

        // Generate token
        $tokenResponse = $this->postJson('/api/auth/token', [
            'email' => 'test6@example.com',
            'password' => 'password123',
        ]);

        $token = $tokenResponse->json('data.token');

        // Use token to access protected endpoint
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/user');

        $response->assertStatus(200);
    }
}
