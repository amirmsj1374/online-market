<main class="main">
    <div class="container">

        <div class="title-link-wrapper appear-animate">
            <h2 class="title"> {{$section['title']}} </h2>
            <a href="shop-boxed-banner.html" class="font-weight-bold ls-25">محصولات بیشتر <i
                    class="w-icon-long-arrow-left"></i></a>
        </div>
        <!-- End of Title Link Wrapper -->
        <div class="row cols-lg-4 cols-md-3 cols-xs-2 cols-1 appear-animate">

            @foreach ($section['contents'][0]['products'] as $key => $product_id)
            @php
            $product = \Modules\Product\Entities\Product::find($product_id)->toArray()
            @endphp

            <div class="product-wrap mb-0">
                <div class="product product-widget">
                    @if (! empty($product['images']))
                    <figure class="product-media">
                        <a href="product-default.html">
                            <img src="{{$product['images'][0]}}" alt="Product" width="600" height="675">
                        </a>
                    </figure>
                    @endif
                    <div class="product-details">
                        <h4 class="product-name">
                            <a href="product-default.html"> {{$product['title']}}</a>
                        </h4>
                        @if (! empty($product['inventories']))
                        <div class="product-price">{{$product['inventories'][0]['final_price']}} تومان </div>
                        @endif
                    </div>
                </div>
            </div>

            @endforeach
        </div>
        <!-- End of Product Widget -->
    </div>
</main>
