<div>
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light"
        style="background-color:black" id="ftco-navbar">
        <div class="container">
            <a class="navbar-brand" href="/">Taste.<span>it</span></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav"
                aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="oi oi-menu"></span> Menu
            </button>

            <div class="collapse navbar-collapse" id="ftco-nav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ $selectedCategoryId == null ? 'active' : '' }}"><a wire:click="categoryFilter('')" class="nav-link">Barchasi</a></li>
                    @foreach ($categoriesSort as $category)
                        <li class="nav-item {{ $selectedCategoryId === $category->id ? 'active' : '' }}">
                            <a wire:click="categoryFilter({{ $category->id }})" class="nav-link">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
    <section class="ftco-section">
        <div class="container">
            <div class="row mt-3">
                @foreach ($categories as $category)
                    <div class="col-md-6 col-lg-4">
                        <div class="menu-wrap">

                            <h3>{{$category->name}}</h3>

                            @foreach ($models as $food)
                                @if ($food->category_id == $category->id)
                                    <div class="d-flex">
                                        <img src="{{asset('storage/' . $food->image)}}" width="100px" height="100px" class="mx-2">
                                        <h4 class="mx-2">{{$food->name}}</h4>
                                    </div>
                                    <p>Price: ${{$food->price}}</p>
                                @endif

                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

    </section>
</div>