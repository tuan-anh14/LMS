@foreach ($projects as $project)
    <option value="{{ $project->id }}"
            data-sections-url="{{ route('admin.projects.sections', $project->id) }}"
    >
        {{ $project->name }}
    </option>
@endforeach


