@include('website::wolmart.layout.header-html')
<!-- End of Page-wrapper-->
<div class="page-wrapper">
    @yield('content')
</div>
<!-- Start of Scroll Top -->
@include('website::wolmart.layout.scroll')
<!-- End of Scroll Top -->

<!-- Start of Mobile Menu -->
@include('website::wolmart.layout.mobilemenu')
<!-- End of Mobile Menu -->

<!-- Start of Quick View -->
@include('website::wolmart.layout.quickview')
<!-- End of Quick view -->

@include('website::wolmart.layout.footer-html')
