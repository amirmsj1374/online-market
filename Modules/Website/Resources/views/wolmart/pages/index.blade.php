@extends('website::wolmart.master')
@section('content')
<div>

    <!-- Start of Header -->
    @if ($menu && $header)
        @include('website::wolmart.elements.header.header-demo1')
    @endif

    <!-- End of Header -->

    <!-- Start of Main-->
    @foreach ($layouts as $sections)
    {{-- {{dd($sections)}} --}}
        @foreach ($sections as $section)
            @if ($section['type'] === 'slider-fullsize')
                @include('website::wolmart.elements.slider.slider-demo1', ['section' => $section])
            @endif
            <!-- End of .intro-section -->
            @if ($section['type'] === 'banner-fullsize')
                @include('website::wolmart.elements.banner.baner-fw', ['section' => $section])
            @endif

            @if ($section['type'] === 'banner-two-col-one-row')
                @include('website::wolmart.elements.banner.banner-26', ['section' => $section])
            @endif

            @if ($section['type'] === 'product-simple')
                @include('website::wolmart.elements.product.favorit-product', ['section' => $section])
            @endif
            <!-- End of Banner Fashion -->
        @endforeach


    @endforeach
  <!-- Start of Footer -->
        @if($footer)
            @include('website::wolmart.elements.footer.footer-demo1', ['footer' => $footer])
        @endif

    {{-- @include('website::wolmart.elements.post-notification.post-demo1') --}}

    {{-- @include('website::wolmart.elements.product.hot-product') --}}

    {{-- @include('website::wolmart.elements.category.category-demo1') --}}
    <!-- End of .category-section top-category -->

    {{-- @include('website::wolmart.elements.banner.banner-26-wbtn') --}}
    <!-- End of Category Cosmetic Lifestyle -->
    {{-- @include('website::wolmart.elements.product.show-more-product') --}}
    <!-- End of Product Wrapper 1 -->

    <!-- End of Product Wrapper 1 -->
    {{-- @include('website::wolmart.elements.category.my-customer') --}}
    <!-- End of Brands Wrapper -->
    {{-- @include('website::wolmart.elements.articles.articles-demo1') --}}
    <!-- Post Wrapper -->
    {{-- @include('website::wolmart.elements.category.current-views') --}}
    <!-- End of Reviewed Producs -->
    <!--End of Catainer -->

    <!-- End of Main -->


</div>
    @endsection
