<div>
    <h1>Category Page</h1>
    <button type="button" class="btn btn-outline-primary" wire:click="{{$activeForm ? 'close' : 'open'}}">
        {{$activeForm ? 'Close' : 'Create'}}
    </button>
    @if ($activeForm)
        <div class="row mt-2">
            <div class="col-4">
                <form wire:submit.prevent="save">
                    <label for="">Category Name</label>
                    <input type="text" wire:model.blur="name" placeholder="Name" class="form-control mt-2">
                    @error('name')
                        <span class="text-danger">{{$message}}</span><br>
                    @enderror
                    <button type="submit" class="btn btn-primary mt-2">Create</button>
                </form>
            </div>
        </div>
    @endif
    @if (!$activeForm)
        <table class="table table-striped table-bordered mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Sort</th>
                    <th>Options</th>
                </tr>
            </thead>
            <tbody wire:sortable="updateCategoryOrder">
                @foreach ($models as $model)
                    @if ($editFormCategory != $model->id)
                        <tr draggable="true" wire:sortable.item="{{ $model->id }}">
                            <td>{{$model->id}}</td>
                            <td>
                                {{$model->name}}
                            </td>
                            <td>{{$model->sort}}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <button class="btn btn-danger" wire:click="delete({{$model->id}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                            <path
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                        </svg>
                                    </button>
                                    <button class="btn btn-warning" wire:click="editForm({{$model->id}})">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-pen" viewBox="0 0 16 16">
                                            <path
                                                d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endif
                    @if ($editFormCategory == $model->id)
                        <tr draggable="true" wire:sortable.item="{{ $model->id }}">
                            <td>{{$model->id}}</td>
                            <td>
                                <input type="text" class="form-control" wire:model="nameEdit" placeholder="Name"
                                    value="{{$model->name}}">
                            </td>
                            <td>{{$model->sort}}</td>
                            <td>
                                <button class="btn btn-warning" wire:click="update({{$model->id}})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-pen" viewBox="0 0 16 16">
                                        <path
                                            d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endif

                @endforeach
            </tbody>
        </table>

    @endif

</div>