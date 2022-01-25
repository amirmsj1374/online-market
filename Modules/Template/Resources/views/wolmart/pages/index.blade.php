@extends('template::wolmart.master')
@section('content')
<div>
    
    <!-- Start of Header -->
    @include('template::wolmart.elements.header.header-demo1')

    <!-- End of Header -->

    <!-- Start of Main-->

    @include('template::wolmart.elements.slider.slider-demo1')
    <!-- End of .intro-section -->

    @include('template::wolmart.elements.post-notification.post-demo1')

    @include('template::wolmart.elements.banner.banner-2*6')

    @include('template::wolmart.elements.product.hot-product')

    @include('template::wolmart.elements.category.category-demo1')
    <!-- End of .category-section top-category -->

    @include('template::wolmart.elements.product.favorit-product')

    @include('template::wolmart.elements.banner.banner-2*6-wbtn')
    <!-- End of Category Cosmetic Lifestyle -->
    @include('template::wolmart.elements.product.show-more-product')
    <!-- End of Product Wrapper 1 -->
    @include('template::wolmart.elements.banner.baner-fw')
    <!-- End of Banner Fashion -->
    <!-- End of Product Wrapper 1 -->
    @include('template::wolmart.elements.category.my-customer')
    <!-- End of Brands Wrapper -->
    @include('template::wolmart.elements.articles.articles-demo1')
    <!-- Post Wrapper -->
    @include('template::wolmart.elements.category.current-views')
    <!-- End of Reviewed Producs -->
    <!--End of Catainer -->

    <!-- End of Main -->

    <!-- Start of Footer -->
    @include('template::wolmart.elements.footer.footer-demo1')
</div>
    @endsection