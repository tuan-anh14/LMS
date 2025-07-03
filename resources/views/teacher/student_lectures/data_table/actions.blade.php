<a href="" class="btn btn-primary btn-sm ajax-modal"
   data-url="{{ route('teacher.student_lectures.edit', $studentLecture->id) }}"
   data-modal-title="@lang('site.edit') {{ $studentLecture->lecture->name }}"
>
    <i data-feather="edit"></i>
</a>

<script>
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
</script>