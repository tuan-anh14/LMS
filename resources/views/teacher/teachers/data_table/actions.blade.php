@if (auth()->user()->hasPermission('update_teachers', session('selected_center')['id']))
    <a href="{{ route('teacher.teachers.edit', $id) }}" class="btn btn-warning btn-sm"><i data-feather="edit"></i> </a>
@endif

@if (auth()->user()->hasPermission('delete_teachers', session('selected_center')['id']))
    <form action="{{ route('teacher.teachers.destroy', $id) }}" class="" method="post" style="display: inline-block;">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm delete"><i data-feather="trash-2"></i></button>
    </form>
@endif

<script>
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
</script>