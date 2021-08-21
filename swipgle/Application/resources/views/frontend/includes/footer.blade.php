@if($__env->yieldContent('title') != "Page not found" && request()->segment(1) != 'download')
<footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
      <div class="row text-center align-items-center flex-row-reverse">
        <div class="col-lg-auto ms-lg-auto">
          <ul class="list-inline list-inline-dots mb-0">
            @foreach($footer_pages as $footer_page)
            <li class="list-inline-item"><a href="{{ route('view.page', $footer_page->slug) }}" class="link-secondary">{{ $footer_page->title }}</a></li>
            @endforeach
          </ul>
        </div>
        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
          <ul class="list-inline list-inline-dots mb-0 m-0">
            <li class="list-inline-item">
                {{__('frontend.copyright')}} <script>document.write(new Date().getFullYear())</script>
                <a href="{{ url('/') }}" class="link-secondary">{{ $settings->website_name }}</a>.
                {{__('frontend.all_right_reserved')}}
             </li>
          </ul>
        </div>
      </div>
    </div>
</footer>
@endif
<script src="{{ asset('ui/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('ui/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('ui/js/swipgle.min.js') }}"></script>
<script src="{{ asset('ui/libs/jqueryloadingoverlay/loadingoverlay.min.js') }}"></script>
<script src="{{ asset('ui/libs/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('ui/js/config.js') }}"></script>
@if(request()->segment(1) == "login" || request()->segment(1) == "register" || request()->segment(2) == "reset" || request()->path() == 'page/contact')
{!! NoCaptcha::renderJs() !!}
@endif
@if(request()->path() == '/')
<script src="{{ asset('ui/libs/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('ui/js/app.js') }}"></script>
@elseif(request()->segment(1) == "user") 
<script src="{{ asset('ui/js/user.js') }}"></script>
@elseif(request()->segment(1) == "download") 
<script src="{{ asset('ui/js/download.js') }}"></script>
@elseif(request()->segment(1) == 'checkout' && isset($transaction) && $transaction->method == "stripe")
<script src="https://js.stripe.com/v3/"></script>
<script>
  var publishable_key = '{{ env('STRIPE_PUBLISHABLE_KEY') }}';
</script>
<script src="{{ asset('ui/js/checkout.js') }}"></script>
@endif
@if($settings->google_analytics != null)
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->google_analytics }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{{ $settings->google_analytics }}');
</script>
@endif