<main class="main">
    <div class="container">
        <div class="row category-banner-wrapper appear-animate pt-6 pb-8">
            @foreach ($section['contents'] as $banner)
                <div class="col-md-6 mb-4">
                    <div class="banner banner-fixed br-xs">
                        <figure>
                            <img src="{{$banner['image']}}"
                                alt="Category Banner" width="610" height="160" style="background-color: #ecedec;max-width:610px;max-height:160px;" />
                        </figure>
                        <div class="banner-content y-50 mt-0">
                            <span class="font-weight-normal">
                                {!! $banner['body'] !!}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- End of Category Banner Wrapper -->
    </div>
</main>
