@extends('layouts.frontend.app')
@section('title')
    Contact Us
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Contact</li>
@endsection
@section('body')
    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="contact-form">
                        <form action="{{route('frontend.contact.store')}}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <input
                                        type="text"
                                        class="form-control "
                                        placeholder="Your Name"
                                        value="{{old('name')}}"
                                        name="name"
                                    />
                                  <sub class="text-danger">  @error('name')
                                      {{$message}}
                                      @enderror
                                  </sub>
                                </div>
                                <div class="form-group col-md-4">
                                    <input
                                        type="email"
                                        class="form-control"
                                        placeholder="Your Email"
                                        value="{{old('email')}}"
                                        name="email"
                                    />
                                    <sub class="text-danger">  @error('email')
                                        {{$message}}
                                        @enderror
                                    </sub>
                                </div>
                                <div class="form-group cols-md-4">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Your Phone"
                                        name="phone"
                                        value="{{old('phone')}}"

                                    />
                                    <sub class="text-danger">  @error('phone')
                                        {{$message}}
                                        @enderror
                                    </sub>
                                </div>
                            </div>

                            <div class="form-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Subject"
                                    name="title"
                                    value="{{old('title')}}"
                                />
                                <sub class="text-danger">  @error('title')
                                    {{$message}}
                                    @enderror
                                </sub>
                            </div>
                            <div class="form-group">
                  <textarea
                      class="form-control"
                      rows="5"
                      placeholder="Message"
                      name="body"
                      value="{{old('body')}}"
                  ></textarea>
                                <sub class="text-danger">  @error('body')
                                    {{$message}}
                                    @enderror
                                </sub>
                            </div>
                            <div>
                                <button class="btn" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <h3>Get in Touch</h3>
                        <p class="mb-4">
                            The contact form is currently inactive. Get a functional and
                            working contact form with Ajax & PHP in a few minutes. Just copy
                            and paste the files, add a little code and you're done.
                        </p>
                        <h4><i class="fa fa-map-marker"></i>{{$getSetting->street}} , {{$getSetting->city}} , {{$getSetting->country}}</h4>
                        <h4><i class="fa fa-envelope"></i>{{$getSetting->email}}</h4>
                        <h4><i class="fa fa-phone"></i>{{$getSetting->phone}}</h4>
                        <div class="social ml-auto">
                            <a href="{{$getSetting->twitter}}" target="_blank" title="twitter"><i class="fab fa-twitter"></i></a>
                            <a href="{{$getSetting->facebook}}" target="_blank" title="facebook"><i class="fab fa-facebook-f"></i></a>
                            {{--                    <a href="{{$getSetting->twitter}}"><i class="fab fa-linkedin-in"></i></a>--}}
                            <a href="{{$getSetting->instagram}}" target="_blank" title="instagram"><i class="fab fa-instagram"></i></a>
                            <a href="{{$getSetting->youtube}}" target="_blank" title="youtube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

@endsection
