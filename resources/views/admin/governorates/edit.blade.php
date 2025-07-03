@extends('layouts.admin.app')
@section('title')@lang('governorates.governorates')@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('governorates.governorates')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.governorates.index') }}">@lang('governorates.governorates')</a></li>
                                <li class="breadcrumb-item active">@lang('site.edit')</li>
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

                            <form method="post" action="{{ route('admin.governorates.update', $governorate->id) }}" class="ajax-form">
                                @csrf
                                @method('put')

                                {{--country_id--}}
                                <div class="form-group">
                                    <label>@lang('countries.country') <span class="text-danger">*</span></label>
                                    <select name="country_id" class="form-control select2" required>
                                        <option value="">@lang('site.choose') @lang('countries.country')</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" {{ $country->id == $governorate->country_id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                {{--name--}}
                                <div class="form-group">
                                    <label>@lang('governorates.name')<span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ $governorate->name }}" autofocus required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i data-feather="edit"></i> @lang('site.update')</button>
                                </div>

                            </form><!-- end of form -->

                        </div><!-- end of card body -->

                    </div><!-- end of card -->

                </div><!-- end of col -->

            </div><!-- end of row -->

        </div><!-- end of content body -->

    </div><!-- end of content wrapper -->

@endsection
