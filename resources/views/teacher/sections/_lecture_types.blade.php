@php use App\Enums\LectureTypeEnum; @endphp

<option value="{{ LectureTypeEnum::EDUCATIONAL }}">@lang('lectures.educational')</option>

@if ($section->project->hasTajweedLectures())
    <option value="{{ LectureTypeEnum::EDUCATIONAL_AND_TAJWEED }}">@lang('lectures.educational_and_tajweed')</option>
@endif

@if ($section->project->hasUpbringingLectures())
    <option value="{{ LectureTypeEnum::EDUCATIONAL_AND_UPBRINGING }}">@lang('lectures.educational_and_upbringing')</option>
@endif