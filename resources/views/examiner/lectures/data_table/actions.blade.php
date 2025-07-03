@if (request()->student_id)

    <a href="{{ route('teacher.students.lectures.edit', ['student' => request()->student_id, 'lecture' => $id,]) }}"
       class="btn btn-warning btn-sm ajax-modal"
       data-url="{{ route('teacher.students.lectures.edit', ['student' => request()->student_id, 'lecture' => $id]) }}"
       data-modal-title="@lang('lectures.edit_lecture')"
    >
        <i data-feather="eye"></i>
    </a>

@elseif(auth()->user()->hasPermission('update_lectures', session('selected_center')['id']))

    <a href="{{ route('teacher.lectures.edit', $id) }}" wire:navigate class="btn btn-warning btn-sm"><i data-feather="edit"></i> </a>

@endif

<script>
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
</script>