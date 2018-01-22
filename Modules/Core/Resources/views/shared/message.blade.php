@if (session()->has('flash_notification.message'))
    <div class="animated shake alert
                    alert-{{ session('flash_notification.level') }}
    {{ session()->has('flash_notification.important') ? 'alert-important' : '' }}"
    >
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        <strong><i class="glyphicon glyphicon-info-sign"></i>
            {!! session('flash_notification.message') !!}
        </strong>
    </div>
@endif

@if (session()->has('selected_tab'))
    <script>
        var selected_tab = '{{session('selected_tab')}}';
    </script>
@endif
