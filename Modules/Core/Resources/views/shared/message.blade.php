@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
        <div class="animated shake alert
                    alert-{{ $message['level'] }}
        {{ $message['important'] ? 'alert-important' : '' }}"
             role="alert"
        >

            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-hidden="true"
            >&times;
            </button>

            <strong><i class="glyphicon glyphicon-info-sign"></i>
                {!! ucwords($message['message']) !!}
            </strong>
        </div>
    @endif
@endforeach

{{ session()->forget('flash_notification') }}

@if (session()->has('selected_tab'))
    <script>
        var selected_tab = '{{session('selected_tab')}}';
    </script>
@endif
