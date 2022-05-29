<?php

namespace Tests\Feature;

use App\Services\CategoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryServiceTest extends TestCase
{

    private CategoryService $categoryService;

    public function setUp(): void
    {
        parent::setUp();

        $this->categoryService = $this->app->make(CategoryService::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $category = $this->categoryService->create(new \App\Models\Category(['name' => 'Test Category']));

        $this->assertEquals('Test Category', $category->name);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateFail()
    {
        $this->expectException(\Exception::class);

        $this->categoryService->create(new \App\Models\Category(['name' => null]));

        // echo 'Test Create Fail' . PHP_EOL;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $category = $this->categoryService->create(new \App\Models\Category(['name' => 'Test Category']));

        $category->name = 'Test Category Updated';
        $category->save();

        $this->assertEquals('Test Category Updated', $category->name);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateFail()
    {
        $this->expectException(\Exception::class);

        $category = $this->categoryService->create(new \App\Models\Category(['name' => null]));

        $category->name = null;
        $category->save();

        // echo 'Test Update Fail' . PHP_EOL;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $category = $this->categoryService->create(new \App\Models\Category(['name' => 'Test Category']));

        $this->assertTrue($this->categoryService->delete($category->id));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteFail()
    {
        // $this->expectException(\Exception::class);

        $this->assertFalse($this->categoryService->delete(0));

        // echo 'Test Delete Fail' . PHP_EOL;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllSuccess()
    {
        $categories = $this->categoryService->getAll();

        $this->assertGreaterThan(0, $categories->count());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetByIdSuccess()
    {
        $category = $this->categoryService->create(new \App\Models\Category(['name' => 'Test Category']));

        $this->assertEquals('Test Category', $this->categoryService->getById($category->id)->name);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetByIdFail()
    {
        $this->expectException(\Exception::class);

        $this->assertFalse($this->categoryService->getById(0));

        // echo 'Test GetById Fail' . PHP_EOL;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteMultiSuccess()
    {
        $category1 = $this->categoryService->create(new \App\Models\Category(['name' => 'Test Category 1']));
        $category2 = $this->categoryService->create(new \App\Models\Category(['name' => 'Test Category 2']));

        $this->assertTrue($this->categoryService->deleteMulti([$category1->id, $category2->id]));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteMultiFail()
    {

        $this->assertFalse($this->categoryService->deleteMulti([0]));

        // echo 'Test DeleteMulti Fail' . PHP_EOL;
    }
}
