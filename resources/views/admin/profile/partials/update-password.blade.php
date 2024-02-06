<div class="card">
    <div class="card-header">
        <h5 class="card-title">Update Password</h5>
    </div>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0 pt-1">Current Password</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input id="update_password_current_password" name="current_password" type="password"
                        @class([
                            'form-control',
                            'is-invalid' => $errors->getBag('updatePassword')->first('current_password'),
                        ]) autocomplete="current-password" />

                    @error('current_password', 'updatePassword')
                        <span class="text text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">New Password</h6>
                </div>

                <div class="col-sm-9 text-secondary">
                    <input id="update_password_password" name="password" type="password" @class([
                        'form-control',
                        'is-invalid' => $errors->getBag('updatePassword')->first('password'),
                    ]) />

                    @error('password', 'updatePassword')
                        <span class="text text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Confirm Password</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                        @class([
                            'form-control',
                            'is-invalid' => $errors->getBag('updatePassword')->first('password_confirmation'),
                        ]) />

                    @error('password_confirmation', 'updatePassword')
                        <span class="text text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9 text-secondary">
                    <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
