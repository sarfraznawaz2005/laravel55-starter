@if (count($errors) > 0)
    <div class="alert alert-danger red-text animated shake">
        <strong><i class="glyphicon glyphicon-info-sign"></i> We found some errors:</strong><br>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    @push('scripts')
        <script>
            if ($('.nav-tabs a[href="#create"]').length) {
                $('a[href="#create"]').tab('show');
            }
            else if ($('.nav-tabs a[href="#edit"]').length) {
                $('a[href="#edit"]').tab('show');
            }
        </script>
    @endpush
@endif