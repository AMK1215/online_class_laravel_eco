 @include('user_layouts.head')
    <body>
        <!-- Navigation-->
        @include('user_layouts.navbar')
        <!-- Header-->
        @include('user_layouts.header')
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                @yield('content')
            </div>
        </section>
        <!-- Footer-->
        @include('user_layouts.footer')