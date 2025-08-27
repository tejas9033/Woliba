<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use App\Notifications\MagicLinkNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\URL;

class InviteUserTest extends TestCase
{
    public function test_admin_can_invite_user_with_valid_api_secret()
    {
        Notification::fake();

        $adminSecret = config('constants.admin.api-secret'); // Make sure this is set in config/constants.php

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'sonitejas9033@gmail.com',
        ];

        $response = $this->postJson('/api/v1/admin/invite', $data, [
            'X-ADMIN-API-SECRET' => $adminSecret,
        ]);

        $response->assertStatus(200);

        // If you're using AnonymousNotifiable
        Notification::assertSentTo(
            new AnonymousNotifiable,
            MagicLinkNotification::class,
            function ($notification, $channels, $notifiable) use ($data) {
                return $notifiable->routes['mail'] === $data['email'];
            }
        );

        $response->assertStatus(200);
    }

    public function test_user_can_login_using_valid_magic_link()
    {
        // Clean up any existing user
        User::where('email', 'john@gmail.com')->delete();

        // Create a fresh user
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@gmail.com',
        ]);

        // Generate a signed URL for magic login
        $signedUrl = URL::temporarySignedRoute(
            'v1.magic-login',
            now()->addMinutes(10),
            ['user' => $user->id]
        );

        // Parse the full URL to extract the query string
        $parsedUrl = parse_url($signedUrl);
        parse_str($parsedUrl['query'], $queryParams);

        // Hit the magic login endpoint
        $response = $this->getJson("/api/v1/magic-link/user?" . http_build_query($queryParams));

        // Assert response is OK
        $response->assertStatus(200);

        // Assert user is authenticated
        $this->actingAs($user);
    }
}
