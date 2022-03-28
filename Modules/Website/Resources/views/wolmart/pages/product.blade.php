@extends('template.wolmart.master')
 @section('content')


    <!-- Start of Header -->
    @include('template::wolmart.elements.header.header-demo1')
    <!-- End of Header -->


    <!-- Start of Main -->
    <main class="main mb-10 pb-1">
        <!-- Start of Breadcrumb -->
        @include('template::wolmart.elements.breadcrumb.breadcrumb-product-demo1')
        <!-- End of Breadcrumb -->

        <!-- Start of Page Content -->
        <div class="page-content">
            <div class="container">

                @include('template::wolmart.elements.product.product-details')



                @include('template::wolmart.elements.product.related-product-section')


            </div>
        </div>
        <!-- End of Page Content -->
    </main>
    <!-- End of Main -->

    <!-- Start of Footer -->
    @include('template::wolmart.elements.footer.footer-demo1')
    <!-- End of Footer -->
 @endsection
<!-- End of Page Wrapper -->

<!-- Start of Sticky Footer -->
@include('template::wolmart.layout.stickyfooter')

<!-- Root element of PhotoSwipe. Must have class pswp -->
@include('template::wolmart.layout.product-details-photoSwipe')
<!-- End of PhotoSwipe -->


