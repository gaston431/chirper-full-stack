<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_displays_the_selected_users_chirps(): void
    {
        $viewer = User::factory()->create(['name' => 'Logged In User']);
        $profileUser = User::factory()->create(['name' => 'Profile Owner']);
        $profileUser->chirps()->create(['message' => 'Chirp from profile owner']);
        $viewer->chirps()->create(['message' => 'Chirp from logged in user']);

        $this->actingAs($viewer)
            ->get(route('profile', $profileUser))
            ->assertOk()
            ->assertSeeText('Latest Chirps Profile Owner')
            ->assertSeeText('Chirp from profile owner')
            ->assertDontSeeText('Chirp from logged in user')
            ->assertSee('data-search-url="'.route('user.chirps.search', $profileUser).'"', false);
    }

    public function test_profile_search_returns_chirps_for_the_selected_user_not_the_viewer(): void
    {
        $viewer = User::factory()->create();
        $profileUser = User::factory()->create();
        $profileUser->chirps()->create(['message' => 'Laravel chirp from profile owner']);
        $viewer->chirps()->create(['message' => 'Laravel chirp from logged in user']);

        $this->actingAs($viewer)
            ->get(route('user.chirps.search', ['user' => $profileUser, 'search' => 'Laravel']))
            ->assertOk()
            ->assertSeeText('Laravel chirp from profile owner')
            ->assertDontSeeText('Laravel chirp from logged in user');
    }
}
