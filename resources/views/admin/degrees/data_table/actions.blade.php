@if (auth()->user()->hasPermission('update_degrees'))
    <a href="{{ route('admin.degrees.edit', $degree->id) }}" class="btn btn-warning btn-sm"><i data-feather="edit"></i> </a>
@endif

@if ($degree->canBeDeleted())
    @if (auth()->user()->hasPermission('delete_degrees'))
        <form action="{{ route('admin.degrees.destroy', $degree->id) }}" class="" method="post" style="display: inline-block;">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger btn-sm delete"><i data-feather="trash-2"></i></button>
        </form>
    @endif

@else

    <a href="#" class="btn btn-danger btn-sm disabled" disabled><i data-feather="trash"></i> </a>

@endif

<script>
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
</script>