<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function PHPUnit\Framework\assertFalse;

class ProductServiceTest extends TestCase
{
    private ProductService $productService;
    public function setUp(): void
    {
        parent::setUp();

        $this->productService = $this->app->make(ProductService::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateSuccess()
    {
        $product = $this->productService->create(new Product(['name' => 'Test Product', 'price' => 100, 'category_id' => 1]));

        $this->assertEquals('Test Product', $product->name);
        $this->assertEquals(100, $product->price);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateFail()
    {
        $this->expectException(\Exception::class);

        $this->productService->create(new Product(['name' => 'Test Product', 'price' => null]));

        // echo 'Test Create Fail' . PHP_EOL;
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $product = $this->productService->create(new Product(['name' => 'Test Product', 'price' => 100, 'category_id' => 1]));

        $product->name = 'Test Product Updated';
        $product->price = 200;

        $product = $this->productService->update($product);

        $this->assertEquals('Test Product Updated', $product->name);
        $this->assertEquals(200, $product->price);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateFail()
    {
        $this->expectException(\Exception::class);

        $product = $this->productService->create(new Product(['name' => 'Test Product', 'price' => 100]));

        $product->name = null;
        $product->price = 200;

        $this->productService->update($product);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteSuccess()
    {
        $product = $this->productService->create(new Product(['name' => 'Test Product', 'price' => 100, 'category_id' => 1]));

        $this->assertTrue($this->productService->delete($product->id));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteFail()
    {
        // $this->expectException(\Exception::class);

        $this->assertFalse($this->productService->delete(0));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetAllSuccess()
    {
        $products = $this->productService->getAll(10);

        $this->assertEquals(10, $products->perPage());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetByIdSuccess()
    {
        $product = $this->productService->create(new Product(['name' => 'Test Product', 'price' => 100, 'category_id' => 1]));

        $product = $this->productService->getById($product->id);

        $this->assertEquals('Test Product', $product->name);
        $this->assertEquals(100, $product->price);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetByIdFail()
    {
        $this->expectException(\Exception::class);

        $this->productService->getById(0);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteMultiSuccess()
    {
        $product1 = $this->productService->create(new Product(['name' => 'Test Product 1', 'price' => 100, 'category_id' => 1]));
        $product2 = $this->productService->create(new Product(['name' => 'Test Product 2', 'price' => 100, 'category_id' => 1]));

        $this->assertTrue($this->productService->deleteMulti([$product1->id, $product2->id]));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testDeleteMultiFail()
    {
        $this->assertFalse($this->productService->deleteMulti([0, 8]));
    }
}
