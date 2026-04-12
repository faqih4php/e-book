@extends('layouts.base')
@section('title', 'Create User')
@section('content')
    <div class="main-container">
        <div class="content">
            <div class="block block-rounded col-xl-8">
                <div class="block-header block-header-default py-3 ps-4 mb-4">
                    <h2 class="block-title fs-lg">Create Users</h2>
                </div>
                <div class="block-content block-content-full">
                    <div class="col-lg-8 col-xl-11 mx-auto">
                        <form id="form-create-user" action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-lg form-control-alt" id="name" name="name"
                                        placeholder="John Doe.." aria-invalid="true">
                                    <div id="name-error" class="invalid-feedback animate fadeIn">
                                        Please enter your username
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="far fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control form-control-lg form-control-alt" id="email" name="email"
                                        placeholder="example@gmail.com.." aria-invalid="true">
                                    <div id="email-error" class="invalid-feedback animate fadeIn">
                                        Please enter your email
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="si si-lock"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg form-control-alt" id="password" name="password"
                                        placeholder="Minimum 6 characters.." aria-invalid="true">
                                    <div id="password-error" class="invalid-feedback animate fadeIn">
                                        Please enter your password
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text form-control-lg form-control-alt me-1">
                                        <i class="si si-lock"></i>
                                    </span>
                                    <input type="password" class="form-control form-control-lg form-control-alt" id="password_confirmation"
                                        name="password_confirmation" placeholder="Minimum 6 characters.."
                                        aria-invalid="true">
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
@section('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form                       = document.getElementById('form-create-user');
            const nameInput                  = document.getElementById('name');
            const emailInput                 = document.getElementById('email');
            const passwordInput              = document.getElementById('password');
            const passwordConfirmationInput  = document.getElementById('password_confirmation');
            const errorEmpty                 = document.getElementById('password_empty-error');
            const errorMismatch              = document.getElementById('password_confirmation-error');

            // --- Helper: validate confirmation field ---
            function validateConfirmation() {
                const pw   = passwordInput.value;
                const conf = passwordConfirmationInput.value;

                if (conf === '') {
                    passwordConfirmationInput.classList.add('is-invalid');
                    errorEmpty.classList.remove('d-none');
                    errorMismatch.classList.add('d-none');
                    return false;
                } else if (pw !== conf) {
                    passwordConfirmationInput.classList.add('is-invalid');
                    errorEmpty.classList.add('d-none');
                    errorMismatch.classList.remove('d-none');
                    return false;
                } else {
                    passwordConfirmationInput.classList.remove('is-invalid');
                    errorEmpty.classList.add('d-none');
                    errorMismatch.classList.add('d-none');
                    return true;
                }
            }

            // --- Real-time validation ---
            nameInput.addEventListener('input', function() {
                this.classList.toggle('is-invalid', !this.value.trim());
            });

            emailInput.addEventListener('input', function() {
                const valid = this.value.trim() && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value);
                this.classList.toggle('is-invalid', !valid);
            });

            passwordInput.addEventListener('input', function() {
                const len = this.value.length;
                this.classList.toggle('is-invalid', !this.value.trim() || len < 6 || len > 8);
                // re-check confirmation whenever password changes
                if (passwordConfirmationInput.value !== '') validateConfirmation();
            });

            passwordConfirmationInput.addEventListener('input', validateConfirmation);

            // --- Submit validation ---
            form.addEventListener('submit', function(e) {
                let isValid = true;

                // Name
                if (!nameInput.value.trim()) {
                    nameInput.classList.add('is-invalid');
                    isValid = false;
                }

                // Email
                if (!emailInput.value.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
                    emailInput.classList.add('is-invalid');
                    isValid = false;
                }

                // Password
                const len = passwordInput.value.length;
                if (!passwordInput.value.trim() || len < 6 || len > 8) {
                    passwordInput.classList.add('is-invalid');
                    isValid = false;
                }

                // Password Confirmation
                if (!validateConfirmation()) {
                    isValid = false;
                }

                if (!isValid) e.preventDefault();
            });
        });
    </script>
@endsection
