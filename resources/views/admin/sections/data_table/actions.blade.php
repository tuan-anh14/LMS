@if (auth()->user()->hasPermission('update_sections'))
    <a href="{{ route('admin.sections.edit', $section->id) }}" wire:navigate class="btn btn-warning btn-sm"><i data-feather="edit"></i> </a>
@endif

@if ($section->canBeDeleted())

    @if (auth()->user()->hasPermission('delete_sections'))
        <form action="{{ route('admin.sections.destroy', $section->id) }}" class="ajax-form" method="post" style="display: inline-block;">
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