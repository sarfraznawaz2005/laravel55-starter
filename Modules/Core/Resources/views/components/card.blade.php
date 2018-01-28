{{--
Usage:

@section('card_id.component_card_body_before')
    This is content before body
@endsection

@section('card_id.component_card_content')
    This is content
@endsection

@section('card_id.component_card_buttons')
        <button class="btn btn-success btn-sm">Submit</button>
@endsection

@section('card_id.component_card_footer')
    This is footer
@endsection

@include('core::components.card', [
    'id' => 'main_frontend_card',
    'card_heading' => 'Some Title',
    'card_type' => 'light',
    'card_heading_type' => 'secondary',
    'card_heading_color' => 'text-white',
    'show_card_footer' => false
])

--}}

<div class="card bg-{{$card_type ?? 'light'}} mb-3">
    @if (isset($card_heading) && $card_heading)
        <div class="card-header bg-{{$card_heading_type ?? 'light'}} {{$card_heading_color ?? ''}}">
            <div class="pull-left" style="padding-top: 5px;"><strong>{!! $card_heading !!}</strong></div>
            <div class="pull-right">@yield($id . '.component_card_buttons')</div>
            <div class="clearfix"></div>
        </div>
    @endif
    @yield($id . '.component_card_body_before')
    <div class="card-body">
        <p class="card-text">@yield($id . '.component_card_content')</p>
    </div>
    @if ($show_card_footer)
        <div class="card-footer">@yield($id . '.component_card_footer')</div>
    @endif
</div>

{{-- any styles of this component here --}}
@push('styles')
    <style>

    </style>
@endpush

{{-- any scripts of this component here --}}
@push('scripts')
    <script>

    </script>
@endpush