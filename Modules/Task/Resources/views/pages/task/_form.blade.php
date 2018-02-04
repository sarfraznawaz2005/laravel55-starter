@if (isset($task) && $task->exists)
    {!! Former::open_for_files()->action(route('task.update', $task))->method('put')->class('validate') !!}
    {{--{!! Former::setOption('automatic_label', false) !!}--}}
    {!! Former::populate($task) !!}
@else
    {!! Former::open_for_files()->action(route('task.store'))->method('post')->class('validate') !!}
@endif

{!! Former::textarea('description', 'Task Description')->required()->class('editor') !!}

@if (isset($task) && $task->file)
    <img src="{!! $task->getImagePath('file', 'thumb'); !!}" alt="Image">
@endif

{!! Former::file('file', 'Optional Image')->accept('image/jpeg', 'image/png')->max(2, 'MB') !!}

{!!
Former::actions(Former::primary_button('<i class="fa fa-save"></i> Save')
->type('submit')
->class('btn btn-success'))
!!}

{!! Former::close() !!}