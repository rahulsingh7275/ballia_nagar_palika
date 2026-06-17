<?php

namespace Tests\Feature;

use App\Models\Deed;
use App\Models\District;
use App\Models\Index;
use App\Models\State;
use App\Models\User;
use App\Models\VaultRegistrationOffice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeedControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_filter_deeds(): void
    {
        $user = User::factory()->create();

        $state = State::create(['name' => 'Deed State', 'code' => 'DS']);
        $district = District::create(['state_id' => $state->id, 'name' => 'Deed District', 'code' => 'DD']);
        $office = VaultRegistrationOffice::create([
            'district_id' => $district->id,
            'office_name' => 'Deed Office',
            'office_code' => 'DO',
        ]);

        $index = Index::create([
            'state_id' => $state->id,
            'district_id' => $district->id,
            'vault_registration_office_id' => $office->id,
            'volume_year' => '2024',
            'book_number' => 'BK-D',
            'volume_number' => 'VOL-D',
            'is_volume_forwarded' => false,
            'status' => 'pending',
            'locked' => false,
            'created_by' => $user->id,
        ]);

        Deed::create([
            'index_id' => $index->id,
            'presentation_year' => '2024',
            'deed_number' => 'D-001',
            'party_name' => 'Alpha Party',
            'property_details' => 'Alpha Property',
            'village' => 'Alpha Village',
            'area' => '100 sq ft',
            'registration_date' => '2024-01-01',
            'status' => 'approved',
        ]);

        Deed::create([
            'index_id' => $index->id,
            'presentation_year' => '2025',
            'deed_number' => 'D-002',
            'party_name' => 'Beta Party',
            'property_details' => 'Beta Property',
            'village' => 'Beta Village',
            'area' => '200 sq ft',
            'registration_date' => '2025-02-02',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('indexes.deeds.index', [$index, 'status' => 'approved', 'party_name' => 'Alpha']));

        $response->assertOk();
        $response->assertSee('Alpha Party');
        $response->assertDontSee('Beta Party');
    }

    public function test_authenticated_user_can_view_all_deeds_with_filters(): void
    {
        $user = User::factory()->create();

        $state = State::create(['name' => 'All Deeds State', 'code' => 'ADS']);
        $district = District::create(['state_id' => $state->id, 'name' => 'All Deeds District', 'code' => 'ADD']);
        $office = VaultRegistrationOffice::create([
            'district_id' => $district->id,
            'office_name' => 'All Deeds Office',
            'office_code' => 'ADO',
        ]);

        $matchingIndex = Index::create([
            'state_id' => $state->id,
            'district_id' => $district->id,
            'vault_registration_office_id' => $office->id,
            'volume_year' => '2026',
            'book_number' => 'BK-ALL',
            'volume_number' => 'VOL-ALL',
            'is_volume_forwarded' => false,
            'status' => 'pending',
            'locked' => false,
            'created_by' => $user->id,
        ]);

        $otherIndex = Index::create([
            'state_id' => $state->id,
            'district_id' => $district->id,
            'vault_registration_office_id' => $office->id,
            'volume_year' => '2025',
            'book_number' => 'BK-OLD',
            'volume_number' => 'VOL-OLD',
            'is_volume_forwarded' => false,
            'status' => 'pending',
            'locked' => false,
            'created_by' => $user->id,
        ]);

        $matchingDeed = Deed::create([
            'index_id' => $matchingIndex->id,
            'presentation_year' => '2026',
            'deed_number' => 'D-ALL',
            'party_name' => 'Matching Party',
            'property_details' => 'Matching Property',
            'village' => 'Matching Village',
            'area' => '500 sq ft',
            'registration_date' => '2026-03-03',
            'status' => 'approved',
        ]);

        Deed::create([
            'index_id' => $otherIndex->id,
            'presentation_year' => '2025',
            'deed_number' => 'D-OLD',
            'party_name' => 'Other Party',
            'property_details' => 'Other Property',
            'village' => 'Other Village',
            'area' => '600 sq ft',
            'registration_date' => '2025-04-04',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('deeds.index', [
            'status' => 'approved',
            'volume_year' => '2026',
            'party_name' => 'Matching',
        ]));

        $response->assertOk();
        $response->assertSee('All Deeds');
        $response->assertSee('Matching Party');
        $response->assertDontSee('Other Party');
        $response->assertSee(route('indexes.deeds.edit', [$matchingIndex, $matchingDeed]));
    }

    public function test_all_deeds_view_renders_when_index_relation_is_missing(): void
    {
        $deed = new Deed([
            'id' => 999,
            'presentation_year' => '2024',
            'deed_number' => 'D-999',
            'party_name' => 'Missing Index Party',
            'property_details' => 'Missing Index Property',
            'village' => 'Missing Village',
            'area' => '999 sq ft',
            'registration_date' => '2024-01-01',
            'status' => 'pending',
        ]);
        $deed->setRelation('index', null);
        $deed->setRelation('scannedDocuments', collect());

        $html = view('deeds.all', [
            'deeds' => collect([$deed]),
            'status' => null,
            'stateId' => null,
            'districtId' => null,
            'officeId' => null,
            'volumeYear' => null,
            'bookNumber' => null,
            'volumeNumber' => null,
            'presentationYear' => null,
            'deedNumber' => null,
            'partyName' => null,
            'village' => null,
            'registrationDate' => null,
            'states' => collect(),
            'districts' => collect(),
            'offices' => collect(),
        ])->render();

        $this->assertStringContainsString('No index linked', $html);
        $this->assertStringContainsString('Missing Index Party', $html);
    }
}
