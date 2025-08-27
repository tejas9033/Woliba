<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\WellbeingPillar;
use App\Models\WellnessInterest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class WellnessApiTest extends TestCase
{
    public $user = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user, ['*']);
    }

    public function test_user_can_fetch_interests()
    {
        $response = $this->getJson('/api/v1/wellness/interests');

        $response->assertStatus(200);
    }

    public function test_user_can_store_selected_interests()
    {
        $interestIds = WellnessInterest::pluck('id')->take(2)->toArray();

        $response = $this->postJson('/api/v1/wellness/interests', [
            'interests' => $interestIds
        ]);

        $response->assertStatus(200);

        // Assert relation exists
        foreach ($interestIds as $id) {
            $this->assertTrue($this->user->wellnessInterests()->where('wellness_interests.id', $id)->exists());
        }
    }

    public function test_user_can_fetch_pillars()
    {
        $response = $this->getJson('/api/v1/wellness/pillars');

        $response->assertStatus(200);
    }

    public function test_user_can_store_selected_pillars()
    {
        $pillarIds = WellbeingPillar::pluck('id')->take(2)->toArray();

        $response = $this->postJson('/api/v1/wellness/pillars', [
            'pillars' => $pillarIds
        ]);

        $response->assertStatus(200);

        // Assert relation exists
        foreach ($pillarIds as $id) {
            $this->assertTrue($this->user->wellbeingPillars()->where('wellbeing_pillars.id', $id)->exists());
        }
    }
}
