@extends('layouts.base')
@section('title', 'Edit User')
@section('content')
    <div class="main-container">
        <div class="content">
            <div class="block block-rounded col-xl-8">
                <div class="block-header block-header-default py-3 ps-4 mb-4">
                    <h2 class="block-title fs-lg">Edit Users</h2>
                </div>
                <div class="block-content block-content-full">
                    <div class="col-lg-8 col-xl-11 mx-auto">
                        <form id="form-create-user" action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="name" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-user"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control form-control-lg form-control-alt @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="John Doe.." aria-invalid="true"
                                        value="{{ old('name', $user->name) }}">
                                    @error('name')
                                        <div id="name-error" class="invalid-feedback animate fadeIn">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-envelope"></i>
                                    </span>
                                    <input type="email"
                                        class="form-control form-control-lg form-control-alt @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="example@gmail.com.." aria-invalid="true"
                                        value="{{ old('email', $user->email) }}">
                                    @error('email')
                                        <div id="email-error" class="invalid-feedback animate fadeIn">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="si si-lock"></i>
                                    </span>
                                    <input type="password"
                                        class="form-control form-control-lg form-control-alt @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="New password (optional)"
                                        aria-invalid="true">
                                    @error('password')
                                        <div id="password-error" class="invalid-feedback animate fadeIn">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="si si-lock"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg form-control-alt"
                                        id="password_confirmation" name="password_confirmation"
                                        placeholder="Confirm new password" aria-invalid="true">
                                    <div class="invalid-feedback animate fadeIn" id="password_empty-error">
                                        Please enter password confirmation
                                    </div>
                                    <div class="invalid-feedback animate fadeIn d-none" id="password_confirmation-error">
                                        Password does not match
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5">
                                <button type="submit" class="btn btn-primary" class="">Create User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
