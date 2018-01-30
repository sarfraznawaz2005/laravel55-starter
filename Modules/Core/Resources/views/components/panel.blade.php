{{--
///////////////////////////////////////
This is for bootstrap 3 only.
///////////////////////////////////////

Usage:

@section('panel_id.component_panel_body_before')
    This is content before body
@endsection

@section('panel_id.component_panel_content')
    This is content
@endsection

@section('panel_id.component_panel_buttons')
        <button class="btn btn-success btn-sm">Submit</button>
@endsection

@section('panel_id.component_panel_footer')
    This is footer
@endsection

@include('core::components.panel', [
    'id' => 'panel_id',
    'panel_type' => 'success',
    'panel_heading' => 'My Panel',
    'show_panel_footer' => true
])

--}}

<div class="panel panel-{{(isset($panel_type) && $panel_type) ? $panel_type : 'default'}}">
    @if (isset($panel_heading) && $panel_heading)
        <div class="panel-heading page-header">
            <div class="pull-left" style="padding-top: 5px;">{!! $panel_heading !!}</div>
            <div class="pull-right">@yield($id . '.component_panel_buttons')</div>
            <div class="clearfix"></div>
        </div>
    @endif
    @yield($id . '.component_panel_body_before')
    <div class="panel-body">@yield($id . '.component_panel_content')</div>
    @if ($show_panel_footer)
        <div class="panel-footer clearfix">@yield($id . '.component_panel_footer')</div>
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