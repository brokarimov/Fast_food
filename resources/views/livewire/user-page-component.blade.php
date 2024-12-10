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
                    <li class="nav-item {{ $selectedCategoryId == null ? 'active' : '' }}"><a
                            wire:click="categoryFilter('')" class="nav-link">Barchasi</a></li>
                    @foreach ($categoriesSort as $category)
                        <li class="nav-item {{ $selectedCategoryId === $category->id ? 'active' : '' }}">
                            <a wire:click="categoryFilter({{ $category->id }})" class="nav-link">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link" wire:click="toggleCart">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-cart" viewBox="0 0 16 16">
                                <path
                                    d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @if ($activeCart == false)
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
                                        <div class="d-flex">
                                            <p>Price: ${{$food->price}}</p>
                                            <button class="btn btn-outline-primary mb-1 mx-5" wire:click="addCart({{$food->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-cart" viewBox="0 0 16 16">
                                                    <path
                                                        d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                                                </svg>
                                            </button>
                                        </div>

                                    @endif

                                @endforeach
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </section>
    @else
        <div class="container mt-5">
            <div class="row mt-5">
                <div class="col-12 mt-5">
                    <h1 class="mt-5">Cart</h1>
                    <div class="row">
                        <div class="col-8">
                            <table class="table table-striped table-bordered mt-2 mb-2">
                                <tbody>
                                    @if (session('cart'))
                                        @foreach (session('cart') as $id => $item)
                                            <tr>
                                                <td><img src="{{asset('storage/' . $item['image'])}}" width="100px" height="100px"
                                                        class="mx-2"></td>
                                                <td>{{$item['name']}}</td>
                                                <td>${{$item['price']}}</td>
                                                <td>
                                                    <button wire:click="plus({{$item['food_id']}})"
                                                        class="btn btn-outline-primary mx-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                            <path
                                                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                        </svg>
                                                    </button>
                                                    {{$item['quantity']}}
                                                    <button wire:click="minus({{$item['food_id']}})"
                                                        class="btn btn-outline-danger mx-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                            fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                            <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                                        </svg>
                                                    </button>
                                                    <div class="d-flex float-right">
                                                        <button wire:click="removeItem({{$item['food_id']}})"
                                                            class="btn btn-outline-secondary">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                                <path
                                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="col-4 mb-4">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Your cart</span>
                            </h4>
                            <ul class="list-group mb-3">
                                @if (session('cart'))
                                    @foreach (session('cart') as $id => $item)
                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                            <div>
                                                <h6 class="my-0">{{$item['name']}}</h6>
                                                <small class="text-muted">Quantity: {{$item['quantity']}}</small>
                                            </div>
                                            <span class="text-muted">{{$item['price']}}</span>
                                        </li>
                                    @endforeach
                                @endif




                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total (USD)</span>
                                    <strong>${{ collect(session('cart'))->sum('price') }}</strong>
                                </li>
                            </ul>



                        </div>
                    </div>


                </div>
            </div>
        </div>
    @endif

</div>