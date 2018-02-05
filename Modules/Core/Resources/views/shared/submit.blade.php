<div class="card-footer border-light" style="margin: 30px 0 0 0;">
    {!!
    Former::actions(Former::primary_button($title ??'<i class="fa fa-save"></i> Save')
    ->type('submit')
    ->class($btnClass ?? 'btn btn-success'))
    !!}
</div>