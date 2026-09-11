<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as GoogleUser;
use Mockery;
use Tests\TestCase;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_google_user_is_redirected_to_prefilled_registration(): void
    {
        $this->mockGoogleUser('google-123', 'New User', 'NEW@example.com');

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect();
        $location = $response->headers->get('Location');

        $this->assertStringContainsString('/register?', $location);
        $this->assertStringContainsString('from_google=1', $location);
        $this->assertStringContainsString('email=new%40example.com', $location);
        $this->assertStringContainsString('google_id=google-123', $location);
    }

    public function test_existing_google_user_receives_token_and_dashboard_callback(): void
    {
        $user = User::factory()->create([
            'email' => 'member@example.com',
            'google_id' => null,
            'role' => 'user',
        ]);
        $this->mockGoogleUser('google-456', 'Member', 'member@example.com');

        $response = $this->get('/auth/google/callback');

        $response->assertOk()->assertViewIs('auth-callback');
        $this->assertSame('google-456', $user->fresh()->google_id);
        $this->assertDatabaseCount('personal_access_tokens', 1);
    }

    public function test_invalid_google_state_returns_visible_safe_error(): void
    {
        $provider = Mockery::mock();
        $provider->shouldReceive('stateless')->once()->andReturnSelf();
        $provider->shouldReceive('user')->once()->andThrow(new InvalidStateException);
        Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect('/login');
        $response->assertSessionHas('error', 'Sesi login Google kedaluwarsa atau cookie browser tidak terbaca. Silakan coba lagi.');

        $this->get('/login')
            ->assertOk()
            ->assertSee('Sesi login Google kedaluwarsa atau cookie browser tidak terbaca. Silakan coba lagi.');
        $response->assertRedirect();
        $this->assertStringContainsString('/login?', $response->headers->get('Location'));
    }

    private function mockGoogleUser(string $id, string $name, string $email): void
    {
        $googleUser = (new GoogleUser)->map([
            'id' => $id,
            'name' => $name,
            'email' => $email,
        ]);
        $provider = Mockery::mock();
        $provider->shouldReceive('stateless')->once()->andReturnSelf();
        $provider->shouldReceive('user')->once()->andReturn($googleUser);
        Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);
    }
}
