<?php

namespace Tests\Feature\Web\Admin;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAsAdmin();

        $this->createBasicTags();
    }

    public function test_admin_can_view_tags_list(): void
    {
        $this->createTag([
            'name' => ['zh_TW' => '測試標籤'],
        ]);

        $this->get(route('admin.tags.index'))
            ->assertOk()
            ->assertViewIs('admin.tags.index')
            ->assertSee('測試標籤');
    }

    public function test_admin_can_create_tag(): void
    {
        $data = [
            'name' => '新標籤',
            'slug' => 'newtag',
            'type' => 'test',
            'order_column' => 1,
        ];

        $this->post(route('admin.tags.store'), $data)
            ->assertRedirect(route('admin.tags.index'));

        $this->assertDatabaseHas('tags', [
            'name->zh_TW' => '新標籤',
            'slug->zh_TW' => 'newtag',
        ]);
    }

    public function test_admin_can_update_tag(): void
    {
        $tag = $this->createTag([
            'name' => ['zh_TW' => '舊標籤'],
            'slug' => ['zh_TW' => 'oldtag'],
        ]);

        $data = [
            'name' => '更新標籤',
            'slug' => 'updatedtag',
            'type' => 'test',
            'order_column' => 2,
        ];

        $this->patch(route('admin.tags.update', $tag), $data)
            ->assertRedirect(route('admin.tags.index'));

        $this->assertDatabaseHas('tags', [
            'name->zh_TW' => '更新標籤',
            'slug->zh_TW' => 'updatedtag',
        ]);
    }

    private function createTag(array $state = []): Tag
    {
        return Tag::factory()
            ->state($state + [
                'name' => ['zh_TW' => '測試標籤'],
                'slug' => ['zh_TW' => 'test'],
                'type' => 'test',
                'order_column' => 1,
            ])->create();
    }
}
