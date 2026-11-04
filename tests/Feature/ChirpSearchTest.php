<?php

namespace Tests\Feature;

use App\Models\Chirp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChirpSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_displays_chirps_on_the_initial_request(): void
    {
        Chirp::query()->create(['message' => 'A chirp from the feed']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSeeText('A chirp from the feed');
    }

    public function test_search_displays_only_matching_chirps_and_preserves_the_search_value(): void
    {
        Chirp::query()->create(['message' => 'Laravel makes posting chirps simple']);
        Chirp::query()->create(['message' => 'A message about something else']);

        $this->get(route('home', ['search' => 'Laravel']))
            ->assertOk()
            ->assertSeeText('Laravel makes posting chirps simple')
            ->assertDontSeeText('A message about something else')
            ->assertSee('value="Laravel"', false);
    }

    public function test_search_displays_an_empty_state_when_no_chirps_match(): void
    {
        $this->get(route('home', ['search' => 'missing']))
            ->assertOk()
            ->assertSeeText('No chirps match your search.');
    }

    public function test_search_rejects_non_string_values(): void
    {
        $this->get(route('home', ['search' => ['invalid']]))
            ->assertSessionHasErrors('search');
    }

    public function test_search_rejects_values_longer_than_100_characters(): void
    {
        $this->get(route('home', ['search' => str_repeat('a', 101)]))
            ->assertSessionHasErrors('search');
    }

    public function test_search_endpoint_returns_a_blade_rendered_chirp_list(): void
    {
        Chirp::query()->create(['message' => 'A matching chirp']);

        $this->get(route('chirps.search', ['search' => 'matching']))
            ->assertOk()
            ->assertSeeText('A matching chirp')
            ->assertDontSee('<html');
    }

    public function test_search_endpoint_rejects_invalid_search_values(): void
    {
        $this->getJson(route('chirps.search', ['search' => ['invalid']]))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('search');
    }

    public function test_search_paginates_results_and_keeps_the_search_query(): void
    {
        foreach (range(1, 21) as $number) {
            Chirp::query()->create(['message' => "Matching chirp {$number}"]);
        }

        $response = $this->get(route('home', ['search' => 'Matching', 'page' => 2]));

        $response->assertOk()
            ->assertViewHas('chirps', fn ($chirps): bool => $chirps->currentPage() === 2 && $chirps->total() === 21);
        $this->assertStringContainsString('search=Matching', html_entity_decode($response->getContent()));
    }
}
