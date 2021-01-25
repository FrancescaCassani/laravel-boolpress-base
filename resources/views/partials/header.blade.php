<header class="mb-5">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{route('homepage')}}">Heroes' blog</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                {{-- Rotta Home --}}
              <a class="nav-link" href="{{route('homepage')}}">Home</a>
            </li>
            {{-- Rotta About --}}
            <li class="nav-item active">
                <a class="nav-link" href="{{route('about')}}">About</a>
            </li>
            {{-- Rotta Index dei post --}}
            <li class="nav-item active">
                <a class="nav-link" href="{{route('posts.index')}}">Blog</a>
            </li>
            {{-- Rotta Create post --}}
            <li class="nav-item active">
                <a class="nav-link" href="{{route('posts.create')}}">New Post</a>
            </li>
          </ul>
        </div>
      </nav>
</header>
