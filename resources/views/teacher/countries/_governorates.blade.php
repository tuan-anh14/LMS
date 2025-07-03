@foreach ($governorates as $governorate)
    <option value="{{ $governorate->id }}"
            data-areas-url="{{ route('teacher.governorates.areas', $governorate->id) }}"
    >
        {{ $governorate->name }}
    </option>
@endforeach


