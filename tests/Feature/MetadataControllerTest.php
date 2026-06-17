<?php

namespace Tests\Feature;

use App\Models\Deed;
use App\Models\District;
use App\Models\Index;
use App\Models\Metadata;
use App\Models\State;
use App\Models\User;
use App\Models\VaultRegistrationOffice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MetadataControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_volume_metadata_list(): void
    {
        $user = User::factory()->create();

        $state = State::create(['name' => 'Test State', 'code' => 'TS']);
        $district = District::create(['state_id' => $state->id, 'name' => 'Test District', 'code' => 'TD']);
        $office = VaultRegistrationOffice::create([
            'district_id' => $district->id,
            'office_name' => 'Test Office',
            'office_code' => 'TO',
        ]);

        $index = Index::create([
            'state_id' => $state->id,
            'district_id' => $district->id,
            'vault_registration_office_id' => $office->id,
            'volume_year' => '2024',
            'book_number' => 'BK-1',
            'volume_number' => 'VOL-1',
            'status' => 'pending',
            'locked' => false,
            'created_by' => $user->id,
        ]);

        $deed = Deed::create([
            'index_id' => $index->id,
            'presentation_year' => '2024',
            'deed_number' => 'D-100',
            'party_name' => 'Test Party',
            'property_details' => 'Test Property',
            'village' => 'Test Village',
            'area' => '100 sq ft',
            'registration_date' => '2024-01-01',
            'status' => 'pending',
        ]);

        Metadata::create([
            'deed_id' => $deed->id,
            'presentation_year' => '2024',
            'deed_number' => 'D-100',
            'party_name' => 'Test Party',
            'property_details' => 'Test Property',
            'village' => 'Test Village',
            'area' => '100 sq ft',
            'registration_date' => '2024-01-01',
            'created_by' => $user->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('metadata.index'));

        $response->assertOk();
        $response->assertSee('Metadata List');
        $response->assertSee('Test Party');
        $response->assertSee(route('deeds.metadata.edit', [$deed, $deed->metadata->first()]));
    }

    public function test_metadata_list_can_be_filtered_by_status_volume_and_date(): void
    {
        $user = User::factory()->create();

        $state = State::create(['name' => 'Filter State', 'code' => 'FS']);
        $district = District::create(['state_id' => $state->id, 'name' => 'Filter District', 'code' => 'FD']);
        $office = VaultRegistrationOffice::create([
            'district_id' => $district->id,
            'office_name' => 'Filter Office',
            'office_code' => 'FO',
        ]);

        $indexOne = Index::create([
            'state_id' => $state->id,
            'district_id' => $district->id,
            'vault_registration_office_id' => $office->id,
            'volume_year' => '2024',
            'book_number' => 'BK-F1',
            'volume_number' => 'VOL-1',
            'status' => 'pending',
            'locked' => false,
            'created_by' => $user->id,
        ]);

        $indexTwo = Index::create([
            'state_id' => $state->id,
            'district_id' => $district->id,
            'vault_registration_office_id' => $office->id,
            'volume_year' => '2025',
            'book_number' => 'BK-F2',
            'volume_number' => 'VOL-2',
            'status' => 'pending',
            'locked' => false,
            'created_by' => $user->id,
        ]);

        $deedOne = Deed::create([
            'index_id' => $indexOne->id,
            'presentation_year' => '2024',
            'deed_number' => 'D-300',
            'party_name' => 'Pending Party',
            'property_details' => 'Pending Property',
            'village' => 'Pending Village',
            'area' => '300 sq ft',
            'registration_date' => '2024-03-03',
            'status' => 'pending',
        ]);

        $deedTwo = Deed::create([
            'index_id' => $indexTwo->id,
            'presentation_year' => '2025',
            'deed_number' => 'D-400',
            'party_name' => 'Approved Party',
            'property_details' => 'Approved Property',
            'village' => 'Approved Village',
            'area' => '400 sq ft',
            'registration_date' => '2025-04-04',
            'status' => 'pending',
        ]);

        Metadata::create([
            'deed_id' => $deedOne->id,
            'presentation_year' => '2024',
            'deed_number' => 'D-300',
            'party_name' => 'Pending Party',
            'property_details' => 'Pending Property',
            'village' => 'Pending Village',
            'area' => '300 sq ft',
            'registration_date' => '2024-03-03',
            'created_by' => $user->id,
            'status' => 'pending',
        ]);

        $approvedMetadata = Metadata::create([
            'deed_id' => $deedTwo->id,
            'presentation_year' => '2025',
            'deed_number' => 'D-400',
            'party_name' => 'Approved Party',
            'property_details' => 'Approved Property',
            'village' => 'Approved Village',
            'area' => '400 sq ft',
            'registration_date' => '2025-04-04',
            'created_by' => $user->id,
            'status' => 'approved',
        ]);

        $response = $this->actingAs($user)->get(route('metadata.index', [
            'status' => 'approved',
            'volume' => 'VOL-2',
            'date' => '2025-04-04',
        ]));

        $response->assertOk();
        $response->assertSee('Approved Party');
        $response->assertDontSee('Pending Party');
        $response->assertSee(route('deeds.metadata.edit', [$deedTwo, $approvedMetadata]));
    }

    public function test_authenticated_user_can_open_metadata_edit_page(): void
    {
        $user = User::factory()->create();

        $state = State::create(['name' => 'Test State 2', 'code' => 'TS2']);
        $district = District::create(['state_id' => $state->id, 'name' => 'Test District 2', 'code' => 'TD2']);
        $office = VaultRegistrationOffice::create([
            'district_id' => $district->id,
            'office_name' => 'Test Office 2',
            'office_code' => 'TO2',
        ]);

        $index = Index::create([
            'state_id' => $state->id,
            'district_id' => $district->id,
            'vault_registration_office_id' => $office->id,
            'volume_year' => '2025',
            'book_number' => 'BK-2',
            'volume_number' => 'VOL-2',
            'status' => 'pending',
            'locked' => false,
            'created_by' => $user->id,
        ]);

        $deed = Deed::create([
            'index_id' => $index->id,
            'presentation_year' => '2025',
            'deed_number' => 'D-200',
            'party_name' => 'Second Test Party',
            'property_details' => 'Second Property',
            'village' => 'Second Village',
            'area' => '200 sq ft',
            'registration_date' => '2025-01-01',
            'status' => 'pending',
        ]);

        $metadata = Metadata::create([
            'deed_id' => $deed->id,
            'presentation_year' => '2025',
            'deed_number' => 'D-200',
            'party_name' => 'Second Test Party',
            'property_details' => 'Second Property',
            'village' => 'Second Village',
            'area' => '200 sq ft',
            'registration_date' => '2025-01-01',
            'created_by' => $user->id,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($user)->get(route('deeds.metadata.edit', [$deed, $metadata]));

        $response->assertOk();
        $response->assertSee('Update Metadata');
    }
}
