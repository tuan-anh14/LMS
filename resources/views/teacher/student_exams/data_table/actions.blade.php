<a href="{{ route('teacher.student_exams.show', $studentExam->id) }}" wire:navigate class="btn btn-primary btn-sm"><i data-feather="eye"></i></a>


@if (auth()->user()->hasPermission('delete_exams') && $studentExam->canBeDeletedByTeacher())
    <form action="{{ route('teacher.student_exams.destroy', $studentExam->id) }}" class="" method="post" style="display: inline-block;">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm delete"><i data-feather="trash-2"></i></button>
    </form>

@else
    <a href="" class="btn btn-danger btn-sm disabled" disabled><i data-feather="trash"></i></a>
@endif

<script>
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
</script>