<a href="{{ route('admin.students.show', $id) }}" wire:navigate class="btn btn-primary btn-sm"><i
        data-feather="eye"></i></a>

@if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
    <a href="{{ route('admin.students.impersonate', $id) }}" class="btn btn-secondary btn-sm"><i
            data-feather="user"></i></a>
@endif


@if (auth()->user()->hasPermission('update_students'))
    <a href="{{ route('admin.students.edit', $id) }}" wire:navigate class="btn btn-warning btn-sm"><i
            data-feather="edit"></i> </a>
@endif

@if (auth()->user()->hasPermission('delete_students'))
    <form action="{{ route('admin.students.destroy', $id) }}" class="ajax-form" method="post"
          style="display: inline-block;">
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
