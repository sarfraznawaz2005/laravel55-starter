<div class="loading-indicator-with-overlay">Loading&#8230;</div>

@push('scripts')
    <script>
        $(document).ready(hideLoader);

        function showLoader() {
            $('.loading-indicator-with-overlay').show();
        }

        function hideLoader() {
            $('.loading-indicator-with-overlay').hide();
        }
    </script>
@endpush


