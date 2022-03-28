<main class="main">
    <section class="intro-section">
        <div class="owl-carousel owl-theme owl-nav-inner owl-dot-inner owl-nav-lg animation-slider gutter-no row cols-1"
            data-owl-options="{'nav': false,'dots': true,'items': 1,'responsive': {'1600': {'nav': true,'dots': false}}}">
            @foreach ($section['contents'] as $key => $content)
                <div class="banner banner-fixed intro-slide intro-slide{{$key +1}}" style="
                        background-image: url({{$content['image']}});
                        background-color: #ebeef2;
                    ">
                    <div class="container">
                        {{-- <figure class="slide-image skrollable slide-animate">
                            <img src="{{$content['image']}}" alt="Banner"
                                data-bottom-top="transform: translateY(10vh);"
                                data-top-bottom="transform: translateY(-10vh);" width="474" height="397" />
                        </figure> --}}
                        <div class="banner-content y-50 text-right">
                            <span class="banner-subtitle font-weight-normal text-default ls-50 lh-1 mb-2 slide-animate"
                                data-animation-options="{
                            'name': 'fadeInRightShorter',
                            'duration': '1s',
                            'delay': '.2s'
                        }">
                               {!! $content['body'] !!}
                            </span>

                            @if ($content['link'])
                                <a href="{{$content['link']}}"
                                    class="btn btn-dark btn-outline btn-rounded btn-icon-right slide-animate"
                                    data-animation-options="{
                                'name': 'fadeInRightShorter',
                                'duration': '1s',
                                'delay': '.8s'
                            }">{{$content['buttonLabel']}}
                                    <i class="w-icon-long-arrow-left"></i></a>

                            @endif
                        </div>
                        <!-- End of .banner-content -->
                    </div>
                    <!-- End of .container -->
                </div>
            @endforeach
            <!-- End of .intro-slide -->
        </div>
        <!-- End of .owl-carousel -->
    </section>
</main>
