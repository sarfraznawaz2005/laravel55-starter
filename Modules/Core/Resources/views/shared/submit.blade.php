<div class="clearfix"></div>
<div class="panel-footer clearfix">

    @if (isset($back))
        <a class="pull-left btn btn-primary btn-raised" href="{{$back}}">
            <span class="glyphicon glyphicon-arrow-left"></span> {{isset($backTitle) ? $backTitle : 'Back'}}
        </a>
    @endif

    @if (isset($view))
        <div class="pull-left">&nbsp;</div>
        <a class="pull-left btn btn-primary btn-raised" href="{{$view}}">
            {{isset($viewTitle) ? $viewTitle : 'View'}} <span class="glyphicon glyphicon-arrow-right"></span>
        </a>
    @endif

    {!! BootForm::submit('<span class="glyphicon glyphicon-ok"></span> ' . (isset($name) ? $name : 'Save'))->class('pull-right btn btn-success btn-raised') !!}
</div>