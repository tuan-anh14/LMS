@if (auth()->user()->hasPermission('update_projects'))
    <a href="{{ route('admin.projects.edit', $project->id) }}" wire:navigate class="btn btn-warning btn-sm"><i data-feather="edit"></i> </a>
@endif

@if ($project->canBeDeleted())

    @if (auth()->user()->hasPermission('delete_projects'))
        <form action="{{ route('admin.projects.destroy', $project->id) }}" class="ajax-form" method="post" style="display: inline-block;">
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