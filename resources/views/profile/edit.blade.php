@extends('layout.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Edit Profile
                    </h2>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    <div class="col-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img src="{{ auth()->user()->foto_url }}" class="img-fluid rounded-circle"
                                        alt="{{ auth()->user()->name }}">
                                    <h3 class="mt-3">
                                        {{ auth()->user()->name }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-10">
                        <div id="update-profile" class="card">
                            <div class="card-header">
                                <h3 class="card-title">Update Profile</h3>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    {{-- Name & Email --}}
                                    <div class="row">
                                        <div class="mb-4 col-sm">
                                            <div class="input-icon">
                                                <span class="input-icon-addon">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                                                    </svg>
                                                </span>
                                                <input type="text" value="{{ auth()->user()->name }}" id="name"
                                                    class="form-control" placeholder="Nama" name="name">
                                            </div>
                                            @error('name')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-4 col-sm">
                                            <div class="input-icon">
                                                <span class="input-icon-addon">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                                        <path d="M3 7l9 6l9 -6" />
                                                    </svg>
                                                </span>
                                                <input type="email" value="{{ auth()->user()->email }}" id="email"
                                                    class="form-control" placeholder="Email" name="email">
                                            </div>
                                            @error('email')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Password --}}
                                    <div class="row">
                                        <div class="mb-4 col-sm">
                                            <div class="input-icon">
                                                <span class="input-icon-addon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-lock">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                                        <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                                        <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                                    </svg>
                                                </span>
                                                <input type="password" value="" id="password" class="form-control"
                                                    placeholder="Password" name="password">
                                            </div>
                                            @error('password')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="mb-4 col-sm">
                                            <div class="input-icon">
                                                <span class="input-icon-addon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-lock">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
                                                        <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                                        <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                                                    </svg>
                                                </span>
                                                <input type="password" value="" id="password_confirmation"
                                                    class="form-control" placeholder="Password Confirmation"
                                                    name="password_confirmation">
                                            </div>
                                            @error('password_confirmation')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Picture --}}
                                    <div class="row">
                                        <div class="mb-4 col-sm">
                                            <div class="input-icon">
                                                <span class="input-icon-addon">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-photo-scan">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M15 8h.01" />
                                                        <path d="M6 13l2.644 -2.644a1.21 1.21 0 0 1 1.712 0l3.644 3.644" />
                                                        <path d="M13 13l1.644 -1.644a1.21 1.21 0 0 1 1.712 0l1.644 1.644" />
                                                        <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                                        <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                                        <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                                        <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                                    </svg>
                                                </span>
                                                <input type="file" class="form-control" id="foto" name="foto"
                                                    accept="image/*">
                                            </div>
                                            <div class="text-muted">
                                                <small>Image must be less than 2MB</small>
                                            </div>
                                            @error('foto')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Button --}}
                                    <div class="row mt-4 d-flex justify-content-end">
                                        <div class="col-xl-4 col-md-6 col-12">
                                            <div class="form-group text-center">
                                                <button class="btn btn-primary w-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                                        <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                        <path d="M14 4l0 4l-6 0l0 -4" />
                                                    </svg>
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
