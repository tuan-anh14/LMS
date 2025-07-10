@extends('layouts.teacher.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('exams.exams')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item active">@lang('exams.exams')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row mb-2">
                <div class="col-md-12">
                    <a href="{{ route('teacher.exams.create') }}" class="btn btn-primary">
                        <i data-feather="plus"></i> @lang('exams.new_exam')
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>@lang('exams.name')</th>
                                        <th>@lang('projects.project')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exams as $exam)
                                        <tr>
                                            <td>{{ $exam->name }}</td>
                                            <td>{{ $exam->project->name ?? '' }}</td>
                                            <td>
                                                <a href="{{ route('teacher.exams.edit', $exam->id) }}" class="btn btn-sm btn-warning">@lang('site.edit')</a>
                                                <form action="{{ route('teacher.exams.destroy', $exam->id) }}" method="POST" style="display:inline-block" class="ajax-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger delete">@lang('site.delete')</button>
                                                </form>
                                                <a href="{{ route('teacher.exams.questions.index', $exam->id) }}" class="btn btn-sm btn-info">@lang('exams.manage_questions')</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- @push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-delete').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xoá bài kiểm tra này?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Không',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush  --> 