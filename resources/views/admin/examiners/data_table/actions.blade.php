@if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))
    <a href="{{ route('admin.examiners.impersonate', $id) }}" class="btn btn-secondary btn-sm"><i
            data-feather="user"></i></a>
@endif

@if (auth()->user()->hasPermission('update_examiners'))
    <a href="{{ route('admin.examiners.edit', $id) }}" wire:navigate class="btn btn-warning btn-sm"><i
            data-feather="edit"></i> </a>
@endif

@if (auth()->user()->hasPermission('delete_examiners'))
    <form action="{{ route('admin.examiners.destroy', $id) }}" class="ajax-form" method="post"
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
