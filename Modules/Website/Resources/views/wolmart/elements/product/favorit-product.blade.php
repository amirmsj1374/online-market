<main class="main">
    {{-- {{dd($section['contents'])}} --}}
    <div class="container">
        <h2 class="title justify-content-center ls-normal mb-4 mt-10 pt-1 appear-animate">
            {{$section['title']}}
        </h2>
        <div class="tab tab-nav-boxed tab-nav-outline appear-animate">
            <ul class="nav nav-tabs justify-content-center" role="tablist">
                @foreach ($section['contents'][0]['categories'] as $key => $category_id)
                    <li class="nav-item mr-2 mb-2">
                        <a class="nav-link br-sm font-size-md ls-normal {{$key === 0 ? 'active' : ''}}" href="#tab1-{{$category_id}}">
                            {{\AliBayat\LaravelCategorizable\Category::find($category_id)->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- End of Tab -->
        <div class="tab-content product-wrapper appear-animate">
            @foreach ($section['contents'][0]['categories'] as $key => $category_id)
                <div class="tab-pane pt-4  {{$key === 0 ? 'active' : ''}}" id="tab1-{{$category_id}}">
                    <div class="row cols-xl-5 cols-md-4 cols-sm-3 cols-2">
                        <?php $products = \AliBayat\LaravelCategorizable\Category::find($category_id)
                                    ->entries(\Modules\Product\Entities\Product::class)->get()->toArray() ?>
                        @foreach ($products as $product)
                            <div class="product-wrap" >
                                <div class="product text-center">
                                    <figure class="product-media">
                                        <a href="product-default.html">
                                            @if (! empty($product['images']))
                                                <img src="{{$product['images'][0]}}"
                                                    alt="Product" width="300" height="338" />
                                            @endif
                                            @if (count($product['images']) > 1)
                                                <img src="{{$product['images'][1]}}"
                                                    alt="Product" width="300" height="338" />
                                            @endif
                                        </a>
                                        <div class="product-action-vertical">
                                            <a href="#" class="btn-product-icon btn-cart w-icon-cart"
                                                title="افزودن به سبد خرید"></a>
                                            <a href="#" class="btn-product-icon btn-wishlist w-icon-heart"
                                                title="افزودن به علاقه مندیها"></a>
                                            <a href="#" class="btn-product-icon btn-quickview w-icon-search"
                                                title="نمایش سریع"></a>
                                            <a href="#" class="btn-product-icon btn-compare w-icon-compare"
                                                title="افزودن برای مقایسه"></a>
                                        </div>
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name">
                                            <a href="product-default.html">
                                                {{$product['title']}}
                                            </a>
                                        </h4>
                                        <div class="ratings-container">
                                            <div class="ratings-full">
                                                <span class="ratings" style="width: 60%"></span>
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div>
                                            <a href="product-default.html" class="rating-reviews">(1 نظر )</a>
                                        </div>
                                        @if (! empty($product['inventories']))
                                            <div class="product-price">
                                                <ins class="new-price">
                                                    {{$product['inventories'][0]['final_price']}} تومان
                                                </ins>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <!-- End of Tab Pane -->
        </div>
        <!-- End of Tab Content -->
    </div>
</main>
