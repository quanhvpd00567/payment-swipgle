<script>
    "use strict";
     const BASE_URL  = "{{ url('/') }}";
     const MAX_FILES = {{ $settings->max_files }};   
     const MAX_FILE_SIZE = {{ $settings->max_upload_size }}; 
     const LODER_COLOR = "{{ $settings->website_sec_color }}";    
</script>
<style>
     :root {
         --swipgle-primary-color: {{ $settings->website_main_color }};
         --swipgle-secondary-color: {{ $settings->website_sec_color }};
     }
</style>