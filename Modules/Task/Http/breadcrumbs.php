<?php

// Task
Breadcrumbs::register('task.index', function ($breadcrumbs) {
    $breadcrumbs->push('Task List', route('task.index'));
});

// Edit Task
Breadcrumbs::register('task.edit', function ($breadcrumbs) {
    $breadcrumbs->parent('task.index');
    $breadcrumbs->push('Edit Task');
});
