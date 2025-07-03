@extends('layouts.admin.app')
@section('title')@lang('admins.admins')@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('admins.admins')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.admins.index') }}">@lang('admins.admins')</a></li>
                                <li class="breadcrumb-item active">@lang('site.create')</li>
                            </ol>

                        </div><!-- end of breadcrumb -->
                    </div>
                </div><!-- end of row -->

            </div><!-- end of content header -->

        </div><!-- end of content header -->

        <div class="content-body">

            <div class="row">

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-body">

                            <form method="post" action="{{ route('admin.admins.store') }}" class="ajax-form">
                                @csrf
                                @method('post')

                                <div class="row">

                                    {{--first_name--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.first_name') <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" class="form-control" autofocus value="{{ old('first_name') }}" required>
                                            @error('name') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{--second_name--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.second_name') <span class="text-danger">*</span></label>
                                            <input type="text" name="second_name" class="form-control" value="{{ old('second_name') }}" required>
                                            @error('name') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{--nickname--}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('users.nickname') <span class="text-danger">*</span></label>
                                            <input type="text" name="nickname" class="form-control" value="{{ old('nickname') }}" required>
                                        </div>
                                    </div>

                                    {{--email--}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('users.email') <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                                            @error('email') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{--password--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.password') <span class="text-danger">*</span></label>
                                            <input type="password" name="password" class="form-control" value="" required>
                                            @error('password') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    {{--password_confirmation--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.password_confirmation') <span class="text-danger">*</span></label>
                                            <input type="password" name="password_confirmation" class="form-control" value="" required>
                                            @error('password_confirmation') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                </div><!-- end of row -->

                                {{--role_id--}}
                                <div class="form-group">
                                    <label>@lang('roles.role') <span class="text-danger">*</span></label>
                                    <select name="role_id" class="form-control select2" required>
                                        <option value="">@lang('site.choose') @lang('roles.role')</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> @lang('site.create')</button>
                                </div>

                            </form><!-- end of form -->

                        </div><!-- end of card body -->

                    </div><!-- end of card -->

                </div><!-- end of col -->

            </div><!-- end of row -->

        </div><!-- end of content body -->

    </div><!-- end of content wrapper -->

@endsection

