<main class="main">
    {{-- <div class="container"> --}}

        <div class="banner banner-fashion appear-animate br-sm mb-9" style="
                background-image: url({{$section['contents'][0]['image']}});
                background-color: #383839;
            ">
            <div class="banner-content align-items-center">
                {{-- <div class="content-left d-flex align-items-center mb-3">
                    <div class="banner-price-info font-weight-bolder text-secondary text-uppercase lh-1 ls-25">
                        25
                        <sup class="font-weight-bold">%</sup><sub class="font-weight-bold ls-25">تخفیف
                        </sub>
                    </div>
                    <hr class="banner-divider bg-white mt-0 mb-0 mr-8" />
                </div> --}}
                <div class="content-right d-flex align-items-center flex-1 flex-wrap">
                    <div class="banner-info mb-0 mr-auto pr-4 mb-3">
                        {!! $section['contents'][0]['body'] !!}
                    </div>
                    <a href="{{$section['contents'][0]['link']}}"
                        class="btn btn-white btn-outline btn-rounded btn-icon-right mb-3">{{$section['contents'][0]['buttonLabel']}}
                        <i class="w-icon-long-arrow-left"></i></a>
                </div>
            </div>
        </div>
    {{-- </div> --}}
</main>
