<?php

namespace Tests\Feature;

use App\Models\Block;
use App\Models\PropertyTaxBill;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyTaxBillsBlockAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_filter_property_tax_bills_by_selected_block(): void
    {
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['label' => 'Admin']
        );

        $admin = User::factory()->create([
            'role_id' => $adminRole->id,
        ]);

        $blockOne = Block::firstOrCreate(['name' => 'Block A']);
        $blockTwo = Block::firstOrCreate(['name' => 'Block B']);

        PropertyTaxBill::create([
            'bill_number' => 'BILL-001',
            'property_id' => 'P-001',
            'owner_name' => 'Owner One',
            'father_name' => 'Father One',
            'address' => 'Address One',
            'financial_year' => '2026-27',
            'block_id' => $blockOne->id,
        ]);

        PropertyTaxBill::create([
            'bill_number' => 'BILL-002',
            'property_id' => 'P-002',
            'owner_name' => 'Owner Two',
            'father_name' => 'Father Two',
            'address' => 'Address Two',
            'financial_year' => '2026-27',
            'block_id' => $blockTwo->id,
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('admin.property-tax.list', ['block_id' => $blockOne->id]));

        $response->assertOk();
        $response->assertSee('Block A');
        $response->assertSee('Owner One');
        $response->assertDontSee('Owner Two');
    }

    public function test_user_can_only_see_assigned_block_bills(): void
    {
        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            ['label' => 'User']
        );

        $user = User::factory()->create([
            'role_id' => $userRole->id,
        ]);

        $blockOne = Block::firstOrCreate(['name' => 'Block A']);
        $blockTwo = Block::firstOrCreate(['name' => 'Block B']);

        $user->blocks()->sync([$blockOne->id]);

        PropertyTaxBill::create([
            'bill_number' => 'BILL-101',
            'property_id' => 'P-101',
            'owner_name' => 'Assigned Owner',
            'father_name' => 'Assigned Father',
            'address' => 'Assigned Address',
            'financial_year' => '2026-27',
            'block_id' => $blockOne->id,
        ]);

        PropertyTaxBill::create([
            'bill_number' => 'BILL-102',
            'property_id' => 'P-102',
            'owner_name' => 'Other Owner',
            'father_name' => 'Other Father',
            'address' => 'Other Address',
            'financial_year' => '2026-27',
            'block_id' => $blockTwo->id,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('admin.property-tax.list'));

        $response->assertOk();
        $response->assertSee('Assigned Owner');
        $response->assertDontSee('Other Owner');
        $response->assertSee('Block A');
        $response->assertDontSee('Block B');
    }
}
