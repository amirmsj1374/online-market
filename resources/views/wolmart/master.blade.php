@include('template::wolmart.layout.header-html')
<!-- End of Page-wrapper-->
<div class="page-wrapper">
    @yield('content')
</div>
<!-- Start of Scroll Top -->
@include('template::wolmart.layout.scroll')
<!-- End of Scroll Top -->

<!-- Start of Mobile Menu -->
@include('template::wolmart.layout.mobilemenu')
<!-- End of Mobile Menu -->

<!-- Start of Quick View -->
@include('template::wolmart.layout.quickview')
<!-- End of Quick view -->

@include('template::wolmart.layout.footer-html')
