<a href="{{ route('admin.inquiries.show', $id) }}" wire:navigate class="btn btn-primary btn-sm"><i data-feather="eye"></i> </a>

@if (auth()->user()->hasPermission('delete_inquiries'))
    <form action="{{ route('admin.inquiries.destroy', $id) }}" class="ajax-form" method="post" style="display: inline-block;">
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