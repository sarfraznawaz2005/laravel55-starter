@extends('crud::layout')

@section('content')

    <div class="pull-right">
        <button data-placement="bottom" data-tooltip data-original-title="Add New Module" data-label="Add New Module"
                class="btn btn-success" data-toggle="modal" data-target="#create-module-modal">
            <i class="fa fa-plus-square"></i> Add New Module
        </button>

        <a data-placement="bottom" data-tooltip data-original-title="Update Composer Dependencies of All modules"
           data-label="Update Composer Dependencies of All modules" class="btn btn-warning"
           href="{{route('crud.update_all')}}">
            <i class="fa fa-refresh"></i> Update Composer Dependencies
        </a>

        <a data-placement="bottom" data-tooltip data-original-title="Run Migrations"
           data-label="Run Migrations" class="btn btn-primary" href="{{route('crud.migrate')}}">
            <i class="fa fa-database"></i> Migrate
        </a>

        <a data-placement="bottom" data-tooltip
           data-original-title="Publish all modules' assets/config/migrations/views/etc"
           data-label="Publish all modules' assets/config/migrations/views/etc" class="btn btn-info"
           href="{{route('crud.publish')}}">
            <i class="fa fa-globe"></i> Publish
        </a>
    </div>
    <div class="clearfix">&nbsp;</div>
    <div class="clearfix">&nbsp;</div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#list"><i class="fa fa-list"></i> Modules</a></li>
        <li><a data-toggle="tab" href="#new_file"><i class="fa fa-plus-square"></i> Create</a></li>
    </ul>

    <div class="tab-content">
        <div id="list" class="tab-pane fade in active">

            <h4><span class="label label-primary">Total Modules: {{Module::count()}}</span></h4>

            <table class="table table-striped table-bordered table-hover dt-responsive nowrap">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Alias</th>
                    <th>Description</th>
                    <th>Order</th>
                    <th width="60" align="center">Details</th>
                    <th width="60" align="center">Status</th>
                    <th width="60" align="center">Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach(Module::all() as $module)
                    <tr>
                        <td>{{$module->name}}</td>
                        <td>{{$module->alias}}</td>
                        <td>{{$module->description}}</td>
                        <td>{{$module->order}}</td>
                        <td align="center">
                            <a href="#" data-toggle="modal" data-target="#details-modal-{{$module->alias}}">
                                <b class="btn btn-primary btn-sm glyphicon glyphicon-eye-open"></b>
                            </a>

                            @php
                                $modelDetails = '<strong>Providers:</strong><br>';
                                $modelDetails .= implode("<br>", $module->providers);

                                $modelDetails .= '<br><br><strong>Aliases:</strong><br>';
                                $modelDetails .= implode("<br>", $module->aliases);

                                $modelDetails .= '<br><br><strong>Files:</strong><br>';
                                $modelDetails .= implode("<br>", $module->files);

                                $modelDetails .= '<br><br><strong>Requires:</strong><br>';
                                $modelDetails .= implode("<br>", $module->requires);

                                $modelDetails .= '<br><br>';
                            @endphp

                            @include('core::popups.general', [
                            'id' => 'details-modal-' . $module->alias,
                            'header_class' => 'modal-header-primary',
                            'title_icon' => '<b class="glyphicon glyphicon-user"></b>',
                            'title' => 'Details',
                            'content' => $modelDetails,
                            'actionbutton' => '',
                            ])

                        </td>
                        <td>
                            @if($module->name !== 'Core' && $module->name !== 'Crud')
                                @if($module->active == 1)
                                    <a data-placement="top" data-tooltip="Disable"
                                       data-original-title="Disable"
                                       href="{{route('crud.toggle_status', $module->name)}}"
                                       title="Disable">
                                        <b class="btn btn-success btn-sm glyphicon glyphicon-ok"></b>
                                    </a>
                                @else
                                    <a data-placement="top" data-tooltip="Enable"
                                       data-original-title="Enable"
                                       href="{{route('crud.toggle_status', $module->name)}}"
                                       title="Enable">
                                        <b class="btn btn-default btn-sm glyphicon glyphicon-ok"></b>
                                    </a>
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                        <td align="center">
                            @if (! in_array($module->name, Module::getSystemModules()))
                                {!! listingDeleteButton(route('crud.destroy', [$module->name]), 'Module')!!}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div id="new_file" class="tab-pane fade">

            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">

                        {!! Former::horizontal_open()->action(route('crud.createfile'))->method('post')->rules(['name' => 'required']) !!}

                        {{--{!! BootForm::openHorizontal(['sm' => [4, 8],'lg' => [2, 10]])->action( route('crud.createfile') )->post() !!}--}}

                        @section('panel_create_file.component_panel_content')
                            {!! Former::select('module')->options(['' => 'Select'] + Module::all())->autofocus()->required()->style('width:100%;') !!}

                            {!! Former::select('command')->label('Type')->style('width:100%;')->required()->options([
                                ''=>'Select',
                                'module:make-controller'=>'Controller',
                                'module:make-model'=>'Model',
                                'module:make-migration'=>'Migration',
                                'module:make-command'=>'Command',
                                'module:make-event'=>'Event',
                                'module:make-job'=>'Job',
                                'module:make-listener'=>'Listener',
                                'module:make-mail'=>'Mailable',
                                'module:make-middleware'=>'Middleware',
                                'module:make-notification'=>'Notification',
                                'module:make-provider'=>'Provider',
                                'module:make-request'=>'Request',
                                'module:make-seed'=>'Seed',
                                'module:route-provider'=>'Route Provider',
                                'make:widget'=>'Widget',
                            ]) !!}

                            <div id="name_container">
                                {!! Former::text('name')->required() !!}
                            </div>
                        @endsection

                        @section('panel_create_file.component_panel_footer')
                            <div class="clearfix">
                                <div class="pull-right col-md-5">
                                    {!! Former::submit('<i class="fa fa-paper-plane"></i> Create File')->class('btn btn-block btn-primary btn-raised') !!}
                                </div>
                            </div>
                        @endsection

                        @include('core::components.panel', [
                            'id' => 'panel_create_file',
                            'panel_type' => $errors->any() ? 'danger' : 'default',
                            'panel_heading' => '<i class="fa fa-paper-plane"></i> Create Module File',
                            'show_panel_footer' => true,
                        ])

                        {!! Former::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="create-module-modal" class="modal fade" tabindex="-1" role="dialog" style="z-index: 99999;">
        {!! Former::open()->action(route('crud.store'))->method('post')->rules(['name' => 'required']) !!}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <h4 class="modal-title">Create Module</h4>
                </div>

                <div class="modal-body" style="padding: 10px 10px 0 10px;">
                    {!! Former::text('name')->label('Module Name (CamelCase)')->required() !!}
                </div>

                <div class="modal-footer" style="padding: 7px 10px 5px 10px;">
                    {!! Former::submit('<b class="glyphicon glyphicon-ok"></b> Create Module')->class('btn btn-success') !!}

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        {!! Former::close() !!}
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            $('#command').change(function () {
                if (this.value === 'module:route-provider') {
                    $('#name').removeAttr('required');
                    $('#name_container').slideUp('fast');
                }
                else {
                    $('#name').attr('required', true);
                    $('#name_container').slideDown('fast');
                }
            });
        });
    </script>
@endpush

