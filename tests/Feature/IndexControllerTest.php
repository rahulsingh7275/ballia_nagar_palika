<?php

namespace Tests\Feature;

use App\Models\District;
use App\Models\Index;
use App\Models\State;
use App\Models\User;
use App\Models\VaultRegistrationOffice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_filter_indexes(): void
    {
        $user = User::factory()->create();

        $state = State::create(['name' => 'Filtered State', 'code' => 'FS']);
        $district = District::create(['state_id' => $state->id, 'name' => 'Filtered District', 'code' => 'FD']);
        $office = VaultRegistrationOffice::create([
            'district_id' => $district->id,
            'office_name' => 'Filtered Office',
            'office_code' => 'FO',
        ]);

        $matchingIndex = Index::create([
            'state_id' => $state->id,
            'district_id' => $district->id,
            'vault_registration_office_id' => $office->id,
            'volume_year' => '2025',
            'book_number' => 'BK-25',
            'volume_number' => 'VOL-25',
            'is_volume_forwarded' => false,
            'status' => 'approved',
            'locked' => false,
            'created_by' => $user->id,
        ]);

        $otherIndex = Index::create([
            'state_id' => $state->id,
            'district_id' => $district->id,
            'vault_registration_office_id' => $office->id,
            'volume_year' => '2024',
            'book_number' => 'BK-24',
            'volume_number' => 'VOL-24',
            'is_volume_forwarded' => false,
            'status' => 'pending',
            'locked' => false,
            'created_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('indexes.index', [
            'status' => 'approved',
            'volume_year' => '2025',
            'book_number' => 'BK-25',
            'volume_number' => 'VOL-25',
        ]));

        $response->assertOk();
        $response->assertSee('VOL-25');
        $response->assertDontSee('VOL-24');
        $response->assertSee(route('indexes.edit', $matchingIndex));
    }
}
