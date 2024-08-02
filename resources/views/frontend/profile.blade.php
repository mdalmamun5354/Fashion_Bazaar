@extends('frontend.layouts.master')
@section('page', $user->name)
@section('styles')
    <link href="{{asset('frontend/css/profile.css')}}" rel="stylesheet" />
@endsection
@section('content')
    <section class="h-100 gradient-custom-2">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center">
                <div class="col col-lg-12 col-xl-10">
                    <div class="card">
                        <div class="top-area rounded-top text-white d-flex flex-row" style="height:200px;">
                            <div class="ml-4 mt-5 d-flex flex-column" style="width: 150px;">
                                <img src="{{ asset('storage/' . $user->img) }}"
{{--////////////////////////////////////////////////////////////    set a def img    /////////////////////////////////////////////////////////////--}}
                                     alt="profile image" class="img-fluid img-thumbnail mt-4 mb-2"
                                     style="width: 150px; z-index: 1">
                                <button  type="button" data-mdb-button-init data-mdb-ripple-init class="btn-edit-profile btn btn-outline-danger  text-body" data-mdb-ripple-color="dark" style="z-index: 1;">
                                    Edit profile
                                </button>
                            </div>
                            <div class="ml-3" style="margin-top: 130px;">
                                <h5>{{ $user->name }}</h5>
                                <p>{{ $user->location }}</p>
                            </div>
                        </div>
                        <div class="p-4 text-black bg-body-tertiary">
                            <div class="d-flex justify-content-end text-center py-1 text-body">
                                <div>
                                    <p class="mb-1 h5">253</p>
                                    <p class="small text-muted mb-0">Photos</p>
                                </div>
                                <div class="px-3">
                                    <p class="mb-1 h5">1026</p>
                                    <p class="small text-muted mb-0">Followers</p>
                                </div>
                                <div>
                                    <p class="mb-1 h5">478</p>
                                    <p class="small text-muted mb-0">Following</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4 text-black">
                            <div class="mb-5  text-body">
                                <p class="lead fw-normal mb-1">About</p>
                                <div class="p-4 bg-body-tertiary">
                                    {{ $user->bio }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4 text-body">
                                <p class="lead fw-normal mb-0">Recent photos</p>
                                <p class="mb-0"><a href="#!" class="text-muted">Show all</a></p>
                            </div>
                            <div class="row g-2">
                                <div class="col mb-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(112).webp" alt="image 1"
                                         class="w-100 rounded-3">
                                </div>
                                <div class="col mb-2">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(107).webp" alt="image 1"
                                         class="w-100 rounded-3">
                                </div>
                            </div>
                            <div class="row g-2">
                                <div class="col">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(108).webp" alt="image 1"
                                         class="w-100 rounded-3">
                                </div>
                                <div class="col">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Lightbox/Original/img%20(114).webp" alt="image 1"
                                         class="w-100 rounded-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
