<script src="{{ asset('ui/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('ui/libs/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('ui/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ asset('ui/libs/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('ui/js/swipgle.min.js') }}"></script>
<script src="{{ asset('ui/js/backend/jquery.priceformat.min.js') }}"></script>
<script src="{{ asset('ui/js/backend/app.js') }}"></script>
@if(Request::path() == "admin/dashboard")
<script src="{{ asset('ui/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
<script src="{{ asset('ui/js/backend/charts.js')}}"></script>
@endif
@if(\Request::segment(2) == "pages")
<script src="{{ asset('ui/libs/ckeditor/ckeditor.js')}}"></script>
<script>
$(function($){
    'use strict';
    var $ckfield = CKEDITOR.replace( 'content' );
    $ckfield.on('change', function() {
      $ckfield.updateElement();         
    });
});
</script>
@endif