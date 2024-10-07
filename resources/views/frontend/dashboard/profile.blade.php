@extends('layouts.frontend.app')
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Profile</li>
@endsection
@section('title')
    {{config('app.name')}} | Profile
@endsection
@section('body')
    <!-- Dashboard Start -->
    <div class="dashboard container">
        <!-- Sidebar -->
        <aside class="col-md-3 nav-sticky dashboard-sidebar">
            <!-- User Info Section -->
            <div class="user-info text-center p-3">
                <img src="{{asset(auth()->guard('web')->user()->image)}}" alt="User Image" class="profile-img rounded-circle" style="width: 100px; height: 100px;" />
                <h5 class="mb-0" style="color: #ff6f61">{{auth()->guard('web')->user()->name}}</h5>
            </div>

            <!-- Sidebar Menu -->
            <div class="list-group profile-sidebar-menu">
                <a href="{{route('frontend.dashboard.profile')}}" class="list-group-item list-group-item-action active menu-item" data-section="profile">
                    <i class="fas fa-user"></i> Profile
                </a>
                <a href="./notifications.html" class="list-group-item list-group-item-action menu-item" data-section="notifications">
                    <i class="fas fa-bell"></i> Notifications
                </a>
                <a href="{{route('frontend.setting.index')}}" class="list-group-item list-group-item-action menu-item" data-section="settings">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Profile Section -->
            <section id="profile" class="content-section active">
                <h2>User Profile</h2>
                <div class="user-profile mb-3">
                    <img src="{{asset(auth()->guard('web')->user()->image)}}" alt="User Image" class="profile-img rounded-circle" style="width: 100px; height: 100px;" />
                    <span class="username">{{auth()->guard('web')->user()->name}}</span>
                </div>
                <br>

                <!-- Add Post Section -->
                 @if(session()->has('errors'))
                     <div class="alert alert-danger">
                         @foreach(session('errors')->all() as $error)
                             <li>{{$error}}</li>
                         @endforeach
                     </div>
                 @endif
                    <form action="{{route('frontend.dashboard.post.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <section id="add-post" class="add-post-section mb-5">
                            <h2>Add Post</h2>
                            <div class="post-form p-3 border rounded">
                                <!-- Post Title -->
                                <input name="title" type="text" id="postTitle" class="form-control mb-2" placeholder="Post Title" />

                                <!-- Post Content -->
                                <textarea name="desc" id="postContent" class="form-control mb-2" rows="3" placeholder="What's on your mind?"></textarea>

                                <!-- Image Upload -->
                                <input name="images[]" type="file" id="postImage" class="form-control mb-2" accept="image/*" multiple />
                                <div class="tn-slider mb-2">
                                    <div id="imagePreview" class="slick-slider"></div>
                                </div>

                                <!-- Category Dropdown -->
                                <select name="category_id" id="postCategory" class="form-select mb-2">
                                     <option value="" selected>Select Category</option>
                                     @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                     @endforeach
                                </select><br>

                                <!-- Enable Comments Checkbox -->
                                <label class="form-check-label mb-2 ml-4">
                                    <input name="comment_able" type="checkbox" class="form-check-input" /> Enable Comments
                                </label><br>

                                <!-- Post Button -->
                                <button type="submit" class="btn btn-primary post-btn">Post</button>
                            </div>
                        </section>
                    </form>



                <!-- Posts Section -->
                <section id="posts" class="posts-section">
                    <h2>Recent Posts</h2>
                    <div class="post-list">
                        <!-- Post Item -->
                            @forelse($posts as $post)
                            <div class="post-item mb-4 p-3 border rounded">
                                <div class="post-header d-flex align-items-center mb-2">
                                    <img src="{{asset($post->images()->first()->path)}}" alt="User Image" class="profile-img rounded-circle" style="width: 50px; height: 50px;" />
                                    <div class="ms-3">
                                        <h5 class="mb-0">{{auth()->user()->name}}</h5>
                                        <small class="text-muted">2 hours ago</small>
                                    </div>
                                </div>
                                <h4 class="post-title">{{$post->title}}</h4>
                                <p class="post-content">{!! chunk_split($post->desc , 30) !!}</p>

                                <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                                        <li data-target="#newsCarousel" data-slide-to="1"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                         @foreach($post->images as $image)
                                            <div class="carousel-item @if($loop->index==0) active @endif ">
                                                <img src="{{asset($image->path)}}" class="d-block w-100" alt="First Slide">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>{{$post->title}}</h5>

                                                </div>
                                            </div>
                                         @endforeach

                                        <!-- Add more carousel-item blocks for additional slides -->
                                    </div>
                                    <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                                <div class="post-actions d-flex justify-content-between">
                                    <div class="post-stats">
                                        <!-- View Count -->
                                        <span class="me-3">
                                  <i class="fas fa-eye"></i> {{$post->num_of_views}} views
                              </span>
                                    </div>

                                    <div>
                                        <a href="{{route('frontend.dashboard.post.edit',$post->slug)}}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="javascript:void(0)" onclick="
                                          if(confirm('Are You Sure To Delete This Post ?')){
                                              document.getElementById('deleteForm_{{$post->id}}').submit()
                                          }
                                          return false
                                        " class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-thumbs-up"></i> Delete
                                        </a>
                                        <button id="commentbtn_{{$post->id}}" class="btn btn-sm btn-outline-secondary getComments" post-id="{{$post->id}}">
                                            <i class="fas fa-comment"></i> Comments
                                        </button>
                                        <button id="hide_{{$post->id}}" style="display: none" class="btn btn-sm btn-outline-secondary hideComments" post-id="{{$post->id}}">
                                            <i class="fas fa-comment" ></i>Hide Comments
                                        </button>

                                        <form id="deleteForm_{{$post->id}}" action="{{route('frontend.dashboard.post.delete')}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input name="slug" value="{{$post->slug}}" hidden>
                                        </form>
                                    </div>
                                </div>

                                <!-- Display Comments -->
                                <div id="displayComments_{{$post->id}}" class="comments" style="display: none">
                                    <div class="comment">
                                        <img src="{{asset('assets/frontend/img/ads-2.jpg')}}" alt="User Image" class="comment-img" />
                                        <div class="comment-content">
                                            <span class="username"></span>
                                            <p class="comment-text">first comment</p>
                                        </div>
                                    </div>
                                    <!-- Add more comments here for demonstration -->
                                </div>
                            </div>

                            @empty
                                <div class="alert alert-info">
                                    No Posts!
                                </div>
                            @endforelse
                        <!-- Add more posts here dynamically -->
                    </div>
                </section>
            </section>
        </div>
    </div>
    <!-- Dashboard End -->
@endsection
@push('jsCode')
    <script>
        $(function(){
            $('#postImage').fileinput({
                theme : 'fa5',
                maxFileCount: 4,
                showUpload : false
            })
        })
        $('#postContent').summernote({
            placeholder : "Text",
            height : '300px',
        });

    //     get post comments
        $(document).on('click','.getComments',function (e){
              e.preventDefault();
           var post_id = $(this).attr('post-id')
              $.ajax({
                  type : "get",
                  url : '{{route('frontend.dashboard.post.getComments',":post_id")}}'.replace(':post_id' , post_id),
                  success : function(data){
                      console.log(data)
                      $('#displayComments_'+post_id).empty()
                      $.each(data.data , function (index , comments){
                          $('#displayComments_'+post_id).append(`
                             <div class="comment">
                        <img src="${comments.user.image}" alt="User Image" class="comment-img" />
                        <div class="comment-content">
                            <span class="username">${comments.user.name}</span>
                            <p class="comment-text">${comments.comment}</p>
                        </div>
                    </div>
                    `).show();
                      })
                      $('#commentbtn_'+post_id).hide()
                      $('#hide_'+post_id).show()
                  },
                  error : function(){

                  }
              })
        })

        // hide post
        $(document).on('click','.hideComments',function(e){
            e.preventDefault();
           var post_id = $(this).attr('post-id')
            $('#displayComments_'+post_id).hide();
            $('#hide_'+post_id).hide();
            $('#commentbtn_'+post_id).show()
        })
    </script>
@endpush
