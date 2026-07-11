<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @include('layouts.head')
    {{-- Page related scripts --}}
    @stack('scripts')
    <body>
        <div class="container py-6">
            <h1 class="display-1">
                <strong>
                    @yield('page_name')
                </strong>
            </h1>
            <hr/>
            @yield('content')
        </div>
    </body>
</html>

    