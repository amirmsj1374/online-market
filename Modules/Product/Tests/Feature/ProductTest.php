<?php

namespace Modules\Product\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Modules\Product\Entities\Product;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_product_index()
    {
        $response =
            $this->getJson(route('product.all'));

        $response->assertStatus(200);
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_product_create()
    {
        $product = Product::newFactory()->make();

        $response =
            $this->postJson(route('product.create'), [
                'title'       => $product->title,
                'description' => $product->description,
                'body'        => $product->body,
            ]);

        $response->assertStatus(201);
        // $response->assertJson([
        //     'title' => $product->title,
        // ]);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_product_update()
    {
        $product = Product::newFactory()->create();
        $response =
            $this->postJson(route('product.update', $product->id), [
                'title'       => 'محصول شماره یک',
                'description' => 'توضیخات مختصر',
                'body'        => 'توضیخ کامل',
                'price'       => 12000,
            'links'       => json_encode([
                    [ 'title' => 'first', 'url' => 'google.com' ],
                    [ 'title' => 'second', 'url' => 'youtube.com' ]
            ]),
            ]);

        $response->assertStatus(200);
    }
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_product_delete()
    {
        $product = Product::newFactory()->create();
        $response =
            $this->postJson(route('product.delete', $product->id));

        $response->assertStatus(200);
    }
}
