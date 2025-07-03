@if (auth()->user()->hasPermission('update_admins'))
    <a href="{{ route('admin.admins.edit', $id) }}" wire:navigate class="btn btn-warning btn-sm"><i data-feather="edit"></i></a>
@endif

@if (auth()->user()->hasPermission('delete_admins'))
    <form action="{{ route('admin.admins.destroy', $id) }}" class="my-1 my-xl-0 ajax-form" method="post" style="display: inline-block;">
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