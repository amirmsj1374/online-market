<header class="header header-border">
    <div class="header-top">
        <div class="container">
            <div class="header-left">
                <span class="welcome-msg">{!! $header->notification !!}</span>
            </div>
            <div class="header-right">
                <div class="dropdown">
                    <a href="#currency">تومان </a>
                    <div class="dropdown-box">
                        <a href="#USD">تومان </a>
                        <a href="#EUR">دلار </a>
                    </div>
                </div>
                <!-- End of DropDown Menu -->

                <div class="dropdown">
                    <a href="#language"><img src="../../theme_vendor/wolmart/images/flags/eng.png" alt="ENG Flag"
                            width="14" height="8" class="dropdown-image" /> تومان </a>
                    <div class="dropdown-box">
                        <a href="#ENG">
                            <img src="../../theme_vendor/wolmart/images/flags/eng.png" alt="ENG Flag" width="14"
                                height="8" class="dropdown-image" />
                            فارسی </a>
                        <a href="#FRA">
                            <img src="../../theme_vendor/wolmart/images/flags/fra.png" alt="FRA Flag" width="14"
                                height="8" class="dropdown-image" />
                            انگلیسی </a>
                    </div>
                </div>
                <!-- End of Dropdown Menu -->
                <span class="divider d-lg-show"></span>
                <a href="blog.html" class="d-lg-show">وبلاگ </a>
                <a href="contact-us.html" class="d-lg-show">تماس با ما </a>
                <a href="my-account.html" class="d-lg-show">حساب کاربری من </a>
                <a href="../../theme_vendor/wolmart/ajax/login.html" class="d-lg-show login sign-in"><i
                        class="w-icon-account"></i>ورود </a>
                <span class="delimiter d-lg-show">/</span>
                <a href="../../theme_vendor/wolmart/ajax/login.html" class="ml-0 d-lg-show login register">ثبت
                    نام </a>
            </div>
        </div>
    </div>
    <!-- End of Header Top -->

    <div class="header-middle">
        <div class="container">
            <div class="header-left mr-md-4">
                <a href="#" class="mobile-menu-toggle  w-icon-hamburger">
                </a>
                <a href="demo1.html" class="logo ml-lg-0">
                    <img src="../../theme_vendor/wolmart/images/logo.png" alt="logo" width="144" height="45" />
                </a>
                <form method="get" action="#"
                    class="header-search hs-expanded hs-round d-none d-md-flex input-wrapper">
                    <div class="select-box">
                        <select id="category" name="category">
                            <option value="">تمام دسته بندیها</option>
                            <option value="4">مدلینگ </option>
                            <option value="5">مبلمان </option>
                            <option value="6">کفشها </option>
                            <option value="7">اسپورتی </option>
                            <option value="8">گیم/بازی </option>
                            <option value="9">کامپیوترها </option>
                            <option value="10">الکترونیکی </option>
                            <option value="11">آشپرخانه </option>
                            <option value="12">لباس </option>
                        </select>
                    </div>
                    <input type="text" class="form-control" name="search" id="search" placeholder="جستجو ..."
                        required />
                    <button class="btn btn-search" type="submit"><i class="w-icon-search"></i>
                    </button>
                </form>
            </div>
            <div class="header-right ml-4">
                <div class="header-call d-xs-show d-lg-flex align-items-center">
                    <a href="tel:#" class="w-icon-call"></a>
                    <div class="call-info d-lg-show">
                        <h4 class="chat font-weight-normal font-size-md text-normal ls-normal text-light mb-0">
                            <a href="mailto:#" class="text-capitalize">چت زنده </a> یا :
                        </h4>
                        <a href="tel:#" class="phone-number font-weight-bolder ls-50">0(800)123-456</a>
                    </div>
                </div>
                <a class="wishlist label-down link d-xs-show" href="wishlist.html">
                    <i class="w-icon-heart"></i>
                    <span class="wishlist-label d-lg-show">لیست علاقه مندیها </span>
                </a>
                <a class="compare label-down link d-xs-show" href="compare.html">
                    <i class="w-icon-compare"></i>
                    <span class="compare-label d-lg-show">مقایسه کردن </span>
                </a>
                <div class="dropdown cart-dropdown cart-offcanvas mr-0 mr-lg-2">
                    <div class="cart-overlay"></div>
                    <a href="#" class="cart-toggle label-down link">
                        <i class="w-icon-cart">
                            <span class="cart-count">2</span>
                        </i>
                        <span class="cart-label">سبد خرید </span>
                    </a>
                    <div class="dropdown-box">
                        <div class="cart-header">
                            <span>سبد خرید فروشگاه </span>
                            <a href="#" class="btn-close">بستن <i class="w-icon-long-arrow-left"></i></a>
                        </div>

                        <div class="products">
                            <div class="product product-cart">
                                <div class="product-detail">
                                    <a href="product-default.html" class="product-name">لوازم آرایشی <br>با کیف
                                        چرم </a>
                                    <div class="price-box">
                                        <span class="product-quantity">1</span>
                                        <span class="product-price">250000 تومان</span>
                                    </div>
                                </div>
                                <figure class="product-media">
                                    <a href="product-default.html">
                                        <img src="../../theme_vendor/wolmart/images/cart/product-1.jpg"
                                            alt="product" height="84" width="94" />
                                    </a>
                                </figure>
                                <button class="btn btn-link btn-close">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <div class="product product-cart">
                                <div class="product-detail">
                                    <a href="product-default.html" class="product-name">زود پز <br>استیل برقی
                                    </a>
                                    <div class="price-box">
                                        <span class="product-quantity">1</span>
                                        <span class="product-price">320000 تومان</span>
                                    </div>
                                </div>
                                <figure class="product-media">
                                    <a href="product-default.html">
                                        <img src="../../theme_vendor/wolmart/images/cart/product-2.jpg"
                                            alt="product" width="84" height="94" />
                                    </a>
                                </figure>
                                <button class="btn btn-link btn-close">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="cart-total">
                            <label>مجموع کل: </label>
                            <span class="price">570000 تومان</span>
                        </div>

                        <div class="cart-action">
                            <a href="cart.html" class="btn btn-dark btn-outline btn-rounded">نمایش سبد </a>
                            <a href="checkout.html" class="btn btn-primary  btn-rounded">پرداخت </a>
                        </div>
                    </div>
                    <!-- End of Dropdown Box -->
                </div>
            </div>
        </div>
    </div>
    <!-- End of Header Middle -->

    @if ($menu)
        <div class="header-bottom sticky-content fix-top sticky-header">
            <div class="container">
                <div class="inner-wrap">
                    <div class="header-left">
                        @if ($menu->where('type', 'Category')->isNotEmpty())
                            <div class="dropdown category-dropdown has-border" data-visible="true">
                                <a href="#" class="category-toggle" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="true" data-display="static"
                                    title="جستجوی دسته بندیها">
                                    <i class="w-icon-category"></i>
                                    <span>دسته بندیها</span>
                                </a>

                                <div class="dropdown-box">
                                    <ul class="menu vertical-menu category-menu">
                                        {{-- this is megamenu type 1 with side banner --}}
                                        {{-- <li>
                                            <a href="shop-fullwidth-banner.html">
                                                <i class="w-icon-tshirt2"></i>مدل
                                            </a>
                                            <ul class="megamenu">
                                                <li>
                                                    <h4 class="menu-title">زنانه </h4>
                                                    <hr class="divider">
                                                    <ul>
                                                        <li><a href="shop-fullwidth-banner.html">تازه رسیده ها </a>
                                                        </li>
                                                        <li><a href="shop-fullwidth-banner.html">فروش برتر </a>
                                                        </li>
                                                        <li><a href="shop-fullwidth-banner.html">پرطرفدار </a></li>
                                                        <li><a href="shop-fullwidth-banner.html">لباس </a></li>
                                                        <li><a href="shop-fullwidth-banner.html">کفش </a></li>
                                                        <li><a href="shop-fullwidth-banner.html">کیسه ها </a></li>
                                                        <li><a href="shop-fullwidth-banner.html">تجهیزات جانبی </a>
                                                        </li>
                                                        <li><a href="shop-fullwidth-banner.html">جواهرات و ساعت</a></li>
                                                        <li><a href="shop-fullwidth-banner.html">ویژه </a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <h4 class="menu-title">مردانه </h4>
                                                    <hr class="divider">
                                                    <ul>
                                                        <li><a href="shop-fullwidth-banner.html">تازه رسیده ها </a>
                                                        </li>
                                                        <li><a href="shop-fullwidth-banner.html">فروش برتر </a>
                                                        </li>
                                                        <li><a href="shop-fullwidth-banner.html">پرطرفدار </a></li>
                                                        <li><a href="shop-fullwidth-banner.html">لباس </a></li>
                                                        <li><a href="shop-fullwidth-banner.html">کفش </a></li>
                                                        <li><a href="shop-fullwidth-banner.html">کیسه ها </a></li>
                                                        <li><a href="shop-fullwidth-banner.html">تجهیزات جانبی </a>
                                                        </li>
                                                        <li><a href="shop-fullwidth-banner.html">جواهرات و ساعت</a></li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <div class="banner-fixed menu-banner menu-banner2">
                                                        <figure>
                                                            <img src="../../theme_vendor/wolmart/images/menu/banner-2.jpg"
                                                                alt="بنر منو" width="235" height="347" />
                                                        </figure>
                                                        <div class="banner-content">
                                                            <div class="banner-price-info mb-1 ls-normal">دریافت تخفیف
                                                                <strong class="text-primary text-uppercase">شروع با 30%
                                                                </strong>
                                                            </div>
                                                            <h3 class="banner-title ls-normal">حراجی داغ </h3>
                                                            <a href="shop-banner-sidebar.html"
                                                                class="btn btn-dark btn-sm btn-link btn-slide-right btn-icon-right">
                                                                اکنون میخرم <i class="w-icon-long-arrow-left"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li> --}}
                                        @foreach ($menu->where('type', 'Category') as $category)
                                            <li>
                                                <a href="{{$category->slug}}">
                                                    {{-- <i class="w-icon-furniture"></i> --}}
                                                    {{$category->name}}
                                                </a>
                                                @if ($category->children->isNotEmpty())
                                                    <ul class="megamenu type2">
                                                        <li class="row">
                                                            @foreach ($category->children as $firstChild)
                                                                <div class="col-md-3 col-lg-3 col-6">
                                                                    <h4 class="menu-title">
                                                                        <a href="{{$firstChild->slug}}">{{$firstChild->name}}</a>
                                                                    </h4>
                                                                    <hr class="divider" />
                                                                    @if ($firstChild->children->isNotEmpty())
                                                                        <ul>
                                                                            @foreach ($firstChild->children as $secondChild)
                                                                                <li>
                                                                                    <a href="{{$secondChild->slug}}">{{$secondChild->name}}</a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </li>

                                                        {{-- this is for banner in megamenu type 2 --}}

                                                        {{-- <li class="row">
                                                            <div class="col-6">
                                                                <div class="banner banner-fixed menu-banner5 br-xs">
                                                                    <figure>
                                                                        <img src="../../theme_vendor/wolmart/images/menu/banner-5.jpg"
                                                                            alt="Banner" width="410" height="123"
                                                                            style="background-color: #D2D2D2;" />
                                                                    </figure>
                                                                    <div class="banner-content text-right y-50">
                                                                        <h4
                                                                            class="banner-subtitle font-weight-normal text-default text-capitalize">
                                                                            تازه رسیده ها </h4>
                                                                        <h3
                                                                            class="banner-title font-weight-bolder text-capitalize ls-normal">
                                                                            مبل شگفت انگیز </h3>
                                                                        <div class="banner-price-info font-weight-normal ls-normal">
                                                                            شروع از <strong>125000 تومان</strong></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="banner banner-fixed menu-banner5 br-xs">
                                                                    <figure>
                                                                        <img src="../../theme_vendor/wolmart/images/menu/banner-6.jpg"
                                                                            alt="Banner" width="410" height="123"
                                                                            style="background-color: #9F9888;" />
                                                                    </figure>
                                                                    <div class="banner-content y-50">
                                                                        <h4
                                                                            class="banner-subtitle font-weight-normal text-white text-capitalize">
                                                                            بیشترین فروش </h4>
                                                                        <h3
                                                                            class="banner-title font-weight-bolder text-capitalize text-white ls-normal">
                                                                            صندلی و لامپ</h3>
                                                                        <div
                                                                            class="banner-price-info font-weight-normal ls-normal text-white">
                                                                            از <strong>165000 تومان</strong></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li> --}}
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if ($menu->where('type', 'Menu')->isNotEmpty())
                            <nav class="main-nav">
                                <ul class="menu active-underline">

                                    {{-- menu item for categories --}}
                                    {{-- <li>
                                        <a href="shop-banner-sidebar.html">فروشگاه </a>

                                        <!-- Start of Megamenu -->
                                        <ul class="megamenu">
                                            <li>
                                                <h4 class="menu-title">صفحات فروشگاه </h4>
                                                <ul>
                                                    <li><a href="shop-banner-sidebar.html">بنر با نوار کناری</a></li>
                                                    <li><a href="shop-boxed-banner.html">بنر جعبه ای </a></li>
                                                    <li><a href="shop-fullwidth-banner.html">بنر عرض کامل </a></li>
                                                    <li><a href="shop-horizontal-filter.html">فیلتر افقی<span
                                                                class="tip tip-hot">داغ </span></a></li>
                                                    <li><a href="shop-off-canvas.html">نوار کناری <span
                                                                class="tip tip-new">جدید </span></a></li>
                                                    <li><a href="shop-infinite-scroll.html">اسکرول بی نهایت آژاکس</a>
                                                    </li>
                                                    <li><a href="shop-right-sidebar.html">نوار کناری چپ</a></li>
                                                    <li><a href="shop-both-sidebar.html">دو نوار کناری </a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <h4 class="menu-title">چیدمان فروشگاه </h4>
                                                <ul>
                                                    <li><a href="shop-grid-3cols.html">3 حالت ستون ها </a></li>
                                                    <li><a href="shop-grid-4cols.html">4 حالت ستون ها </a></li>
                                                    <li><a href="shop-grid-5cols.html">5 حالت ستون ها </a></li>
                                                    <li><a href="shop-grid-6cols.html">6 حالت ستون ها </a></li>
                                                    <li><a href="shop-grid-7cols.html">7 حالت ستون ها </a></li>
                                                    <li><a href="shop-grid-8cols.html">8 حالت ستون ها </a></li>
                                                    <li><a href="shop-list.html">حالت لیست </a></li>
                                                    <li><a href="shop-list-sidebar.html">حالت لیست با نوار کناری</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <h4 class="menu-title">صفحات محصول </h4>
                                                <ul>
                                                    <li><a href="product-variable.html">محصول متغیر </a></li>
                                                    <li><a href="product-featured.html">ویژه و حراج </a></li>
                                                    <li><a href="product-accordion.html">داده ها در آکاردئون</a></li>
                                                    <li><a href="product-section.html">داده ها در بخش ها</a></li>
                                                    <li><a href="product-swatch.html">سواچ تصویر</a></li>
                                                    <li><a href="product-extended.html">اطلاعات گسترده </a>
                                                    </li>
                                                    <li><a href="product-without-sidebar.html">بدون نوار کناری </a></li>
                                                    <li><a href="product-video.html">360<sup>درجه </sup> ویدئو <span
                                                                class="tip tip-new">جدید </span></a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <h4 class="menu-title">طرح بندی محصولات </h4>
                                                <ul>
                                                    <li><a href="product-default.html">پیشفرض <span class="tip tip-hot">داغ
                                                            </span></a></li>
                                                    <li><a href="product-vertical.html">تصاویر عمودی محصول </a></li>
                                                    <li><a href="product-grid.html">تصاویر شبکه ای </a></li>
                                                    <li><a href="product-masonry.html">ساختمانی </a></li>
                                                    <li><a href="product-gallery.html">گالری </a></li>
                                                    <li><a href="product-sticky-info.html">اطلاعات چسبناک </a></li>
                                                    <li><a href="product-sticky-thumb.html">تصاویر کوچک چسبناک</a></li>
                                                    <li><a href="product-sticky-both.html">چسبناک هر دو </a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                        <!-- End of Megamenu -->
                                    </li> --}}
                                    @foreach ($menu->where('type', 'Menu') as $item)
                                    {{-- {{dd($item->link, url()->current(), $item->slug == url()->current())}} --}}
                                        <li class="{{$item->link == url()->current() || $item->slug == url()->current() ? 'active' : ''}}">
                                            <a href="{{$item->link ?? $item->slug}}">{{$item->name}}</a>
                                            @if ($item->children->isNotEmpty())
                                                <ul>
                                                    @foreach ($item->children as $firstLevel)
                                                        <li>
                                                            <a href="{{$firstLevel->link ?? $firstLevel->slug}}">{{$firstLevel->name}}</a>
                                                            @if ($firstLevel->children->isNotEmpty())
                                                                <ul>
                                                                    @foreach ($firstLevel->children as  $secondLevel)
                                                                        <li>
                                                                            <a href="{{$secondLevel->link ?? $secondLevel->slug}}">{{$secondLevel->name}}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </nav>

                        @endif
                    </div>

                    {{-- <div class="header-right">
                        <a href="#" class="d-xl-show"><i class="w-icon-map-marker mr-1"></i>پیگیری سفارش</a>
                        <a href="#"><i class="w-icon-sale"></i>فروش ویژه </a>
                    </div> --}}
                </div>
            </div>
        </div>

    @endif
</header>
