@if (request()->student_id)

    <a href="{{ route('teacher.students.lectures.edit', ['student' => request()->student_id, 'lecture' => $lecture->id,]) }}"
       class="btn btn-warning btn-sm ajax-modal"
       data-url="{{ route('teacher.students.lectures.edit', ['student' => request()->student_id, 'lecture' => $id]) }}"
       data-modal-title="@lang('lectures.edit_lecture')"
    >
        <i data-feather="eye"></i>
    </a>

@elseif(auth()->user()->hasPermission('update_lectures', session('selected_center')['id']))

    <a href="{{ route('teacher.lectures.edit', $lecture->id) }}" wire:navigate class="btn btn-warning btn-sm"><i data-feather="edit"></i> </a>

@endif

@if ($lecture->canBeDeleted())

    <form action="{{ route('teacher.lectures.destroy', $lecture->id) }}" class="ajax-form" method="post" style="display: inline-block;">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm delete"><i data-feather="trash-2"></i></button>
    </form>

@else
    <button class="btn btn-danger btn-sm" disabled><i data-feather="trash"></i></button>
@endif

<script>
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
</script>