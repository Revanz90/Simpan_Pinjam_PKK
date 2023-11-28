@include('partials.header')

<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="/img/Logo PKK.png" alt="AdminLTELogo" height="150" width="150" />
</div>

@include('partials.navbar')

@include('partials.sidebar')

<div class="content-wrapper">

    @include('partials.breadcrumb')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @yield('partials.content')
        </div>
    </section>
</div>

@include('partials.footer')
