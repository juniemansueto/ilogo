<footer class="app-footer">
    <div class="site-footer-right">
        @if (rand(1,100) == 100)
            <i class="logoinc-rum-1"></i> {{ __('logoinc::theme.footer_copyright2') }}
        @else
            {!! __('logoinc::theme.footer_copyright') !!} <a href="http://mylogoinc.com" target="_blank">LOGO Inc., Group - v1.0</a>
        @endif
        <!--@php $version = 1.0; @endphp
        @if (!empty($version))
            - {{ $version }}
        @endif -->
    </div>
</footer>
