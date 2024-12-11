<div>
    <section class="content pb-3 mt-3">
        <div class="container-fluid h-100">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                    <div class="col-3">
    <div class="card card-row card-secondary">
        <div class="card-header">
            <h3 class="card-title">
                Orders
            </h3>
        </div>
        <div class="card-body" style="height: 600px; overflow-y: auto;">
            @foreach ($orders1 as $order)
            @if ($order->date == now()->format('Y-m-d'))
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="heading{{$order->id}}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Queue: {{$order->queue}}</span>
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                                    </svg>
                                </button>
                                <button class="btn btn-link" wire:click="orderStatusChange({{$order->id}})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div id="collapse{{$order->id}}" class="collapse show" aria-labelledby="heading{{$order->id}}" data-parent="#accordion">
                            <div class="card-body">
                                @foreach ($order->foods as $food)
                                <div class="form-check">
                                    <li>{{$food->name}} x
                                        @foreach ($food->orderItems as $item)
                                            @if ($item->order_id == $order->id)
                                                {{$item->count}}
                                            @endif
                                        @endforeach
                                    </li>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
               
            @endif
                
            @endforeach
        </div>
    </div>
</div>

<div class="col-3">
    <div class="card card-row card-primary">
        <div class="card-header">
            <h3 class="card-title">
                In progress
            </h3>
        </div>
        <div class="card-body" style="height: 600px; overflow-y: auto;">
            @foreach ($orders2 as $order)
            @if ($order->date == now()->format('Y-m-d'))
            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="heading{{$order->id}}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Queue: {{$order->queue}}</span>
                            <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$order->id}}" aria-expanded="true" aria-controls="collapse{{$order->id}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                                </svg>
                            </button>

                            <button class="btn btn-link" wire:click="orderStatusChange3({{$order->id}})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div id="collapse{{$order->id}}" class="collapse show" aria-labelledby="heading{{$order->id}}" data-parent="#accordion">
                        <div class="card-body">
                            @foreach ($order->foods as $food)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:change="statusChange({{$order->id}}, {{$food->id}})"
                                @foreach ($food->orderItems as $item)
                                    @if ($order->id == $item->order_id)
                                    {{$item->status == 3 ? 'checked' : ''}}
                                    
                                    @endif
                                @endforeach
                                
                                >
                                <label class="form-check-label" for="flexCheckDefault"
                                    style="
                                        @foreach ($food->orderItems as $item)
                                            @if ($order->id == $item->order_id && $item->status == 3)
                                                text-decoration-line: line-through;
                                            @break
                                            @endif
                                        @endforeach
                                        ">
                                            {{$food->name}} x 
                                        @foreach ($food->orderItems as $item)
                                            @if ($item->order_id == $order->id)
                                                {{$item->count}}
                                            @endif
                                        @endforeach
                                </label>

                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            @endforeach
        </div>
    </div>
</div>


                        <div class="col-3">
    <div class="card card-row card-default">
        <div class="card-header bg-info">
            <h3 class="card-title">
                Done
            </h3>
        </div>

        <div class="card-body" style="height: 600px; overflow-y: auto;">
            @foreach ($orders3 as $order)
                @if ($order->date == now()->format('Y-m-d'))
                <div id="accordion">
                    <div class="card">
                        <div class="card-header" id="heading{{$order->id}}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Queue: {{$order->queue}}</span> 
                                    <button class="btn btn-link" data-toggle="collapse"
                                        data-target="#collapse{{$order->id}}" aria-expanded="true"
                                        aria-controls="collapse{{$order->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                                        </svg>
                                    </button>
                            </div>
                        </div>

                        <div id="collapse{{$order->id}}" class="collapse show" aria-labelledby="heading{{$order->id}}"
                            data-parent="#accordion">
                            <div class="card-body">
                                @foreach ($order->foods as $food)
                                <div class="form-check">
                                <li>{{$food->name}} x
                                    @foreach ($food->orderItems as $item)
                                        @if ($item->order_id == $order->id)
                                            {{$item->count}}
                                        @endif
                                    @endforeach
                                </li>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
            @endforeach
        </div>
    </div>
</div>


                        <div class="col-3">
                            <div class="card card-row card-success">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Delivered
                                    </h3>
                                </div>
                                <div class="card-body" style="height: 600px;" >
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>