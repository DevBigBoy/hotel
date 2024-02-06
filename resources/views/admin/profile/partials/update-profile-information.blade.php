<div class="card">
    <div class="card-header">
        <h5 class="card-title pt-1">Profile Information</h5>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="card-body">

            <div class="row mb-3">
                <div id="image-preview" class="image-preview">
                    <label for="image-upload" id="image-label">
                        <i class='bx bx-image-add bx-lg bx-tada-hover'></i>
                    </label>
                    <input type="file" name="photo" id="image-upload" />
                </div>

                @error('photo')
                    <span class="text text-danger text-center">{{ $message }}</span>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Name</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input id="name" name="name" type="text" @class(['form-control', 'is-invalid' => $errors->has('name')])
                        value="{{ old('name', $admin->name) }}" />
                    @error('name')
                        <span class="text text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Email</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input id="email" name="email" type="email" @class(['form-control', 'is-invalid' => $errors->has('email')])
                        value="{{ old('email', $admin->email) }}" />

                    @error('email')
                        <span class="text text-danger">{{ $message }}</span>
                    @enderror
                </div>


                @if ($admin instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$admin->hasVerifiedEmail())
                    <div>
                        <div class="alert alert-warning text-center">
                            Your email address is unverified.<button form="send-verification"
                                class="btn btn-link px-0 py-0 normal">
                                Click here to re-send the verification email.
                            </button>
                        </div>

                        @if (session('status') === 'verification-link-sent')
                            <div class="alert alert-success">
                                A new verification link has been sent to your email address.
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Phone</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" name="phone" @class(['form-control', 'is-invalid' => $errors->has('phone')])
                        value="{{ old('phone', $admin->phone) }}" />
                    @error('phone')
                        <span class="text text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-3">
                    <h6 class="mb-0">Address</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <input type="text" name="address" @class(['form-control', 'is-invalid' => $errors->has('address')])
                        value="{{ old('address', $admin->address) }}" />
                    @error('address')
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
