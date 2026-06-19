<?php

namespace Tests\Feature;

use App\Models\Block;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserBlockAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user_page_does_not_show_block_assignment_fields(): void
    {
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['label' => 'Admin']
        );

        $admin = User::factory()->create([
            'role_id' => $adminRole->id,
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('admin.users.create'));

        $response->assertOk();
        $response->assertDontSee('name="block_ids[]"');
        $response->assertDontSee('Hold Ctrl/Cmd to select multiple blocks.');
        $response->assertDontSee('Choices');
    }

    public function test_selected_user_page_loads_existing_block_assignments(): void
    {
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['label' => 'Admin']
        );

        $admin = User::factory()->create([
            'role_id' => $adminRole->id,
        ]);

        $user = User::factory()->create([
            'role_id' => $adminRole->id,
        ]);

        $blockOne = Block::firstOrCreate(['name' => 'Block A']);
        $blockTwo = Block::firstOrCreate(['name' => 'Block B']);

        $user->blocks()->sync([$blockOne->id, $blockTwo->id]);

        $this->actingAs($admin);

        $response = $this->get(route('admin.user-block-assignments.index', ['user_id' => $user->id]));

        $response->assertOk();
        $response->assertViewHas('selectedUserId', $user->id);
        $response->assertViewHas('selectedBlockIds', [$blockOne->id, $blockTwo->id]);
    }

    public function test_admin_can_open_assign_blocks_page_and_update_multiple_blocks(): void
    {
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            ['label' => 'Admin']
        );

        $admin = User::factory()->create([
            'role_id' => $adminRole->id,
        ]);

        $user = User::factory()->create([
            'role_id' => $adminRole->id,
        ]);

        $blockOne = Block::firstOrCreate(['name' => 'Block A']);
        $blockTwo = Block::firstOrCreate(['name' => 'Block B']);

        $this->actingAs($admin);

        $response = $this->get(route('admin.users.assign-blocks', $user));

        $response->assertOk();
        $response->assertSee('Assign Blocks');
        $response->assertSee('block_ids[]');

        $response = $this->post(route('admin.users.store-blocks', $user), [
            'block_ids' => [$blockOne->id, $blockTwo->id],
        ]);

        $response->assertRedirect(route('admin.users.assign-blocks', $user));

        $this->assertDatabaseHas('block_user', [
            'user_id' => $user->id,
            'block_id' => $blockOne->id,
        ]);
        $this->assertDatabaseHas('block_user', [
            'user_id' => $user->id,
            'block_id' => $blockTwo->id,
        ]);
    }

    public function test_admin_can_assign_multiple_blocks_to_user(): void
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

        $this->actingAs($admin);

        $response = $this->post(route('admin.users.store'), [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role_id' => $adminRole->id,
            'block_ids' => [$blockOne->id, $blockTwo->id],
        ]);

        $response->assertRedirect(route('admin.users.index'));

        $user = User::where('email', 'testuser@example.com')->firstOrFail();

        $this->assertTrue($user->blocks()->whereIn('blocks.id', [$blockOne->id, $blockTwo->id])->count() === 2);
        $this->assertDatabaseHas('block_user', [
            'user_id' => $user->id,
            'block_id' => $blockOne->id,
        ]);
        $this->assertDatabaseHas('block_user', [
            'user_id' => $user->id,
            'block_id' => $blockTwo->id,
        ]);
    }
}
