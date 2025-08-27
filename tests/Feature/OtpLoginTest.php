<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;


class OtpLoginTest extends TestCase
{

    public function test_user_receives_otp_email()
    {
        Notification::fake();
        Mail::fake();

        $email = 'newuser@example.com';

        User::where('email', 'newuser@example.com')->delete();

        $response = $this->postJson('/api/v1/send-otp', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => $email,
        ]);

        $response->assertStatus(200);

        Notification::assertSentTo(
            new AnonymousNotifiable,
            OtpNotification::class,
            function ($notification, $channels, $notifiable) use ($email) {
                return $notifiable->routes['mail'] === $email;
            }
        );
    }

    public function test_user_can_register_with_valid_otp()
    {
        $email = 'newuser@example.com';
        $otp = '123456';

        Cache::put("otp_{$email}", $otp, now()->addMinutes(10));

        $response = $this->postJson('/api/v1/verify-otp', [
            'email' => $email,
            'otp' => $otp,
            'first_name' => 'New',
            'last_name' => 'User',
            'password' => 'securePassword123',
        ]);

        $response->assertStatus(200);
    }
}
