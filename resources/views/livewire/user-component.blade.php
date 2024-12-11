<div>
    <div class="row">
        <div class="col-12">
            <h1>Users</h1>

            <button type="button" class="btn btn-outline-primary" wire:click="{{$activeForm ? 'close' : 'open'}}">
                {{$activeForm ? 'Close' : 'Create'}}
            </button>
            @if ($activeForm == false)
                <table class="table table-striped table-bordered mt-2">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Role</td>
                            <td>Image</td>
                            <td>Options</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            @if ($editFormUser != $user->id)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role}}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $user->image) }}" alt="" width="100px">
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <button class="btn btn-danger" wire:click="delete({{$user->id}})">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                    class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path
                                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                    <path
                                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                </svg>
                                            </button>
                                            <button class="btn btn-warning" wire:click="editForm({{$user->id}})">
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
                            @if ($editFormUser == $user->id)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>
                                        <input type="text" class="form-control" wire:model="nameEdit" placeholder="Name"
                                            value="{{$user->name}}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" wire:model="emailEdit" placeholder="Email"
                                            value="{{$user->email}}">
                                    </td>
                                    <td>
                                        <select class="form-control" wire:model="roleEdit">
                                            <option value="">Select Role</option>
                                            <option value="admin">Admin</option>
                                            <option value="waiter">Waiter</option>
                                            <option value="chef">Chef</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="file" wire:model="imageEdit" class="form-control">
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" wire:click="update({{$user->id}})">
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
            @else
                <form wire:submit.prevent="save">
                    <div class="col-5">
                        <label for="">Name</label>
                        <input type="text" wire:model.blur="name" class="form-control" placeholder="Name">
                        @error('name')
                            <span class="text-danger">{{$message}}</span><br>
                        @enderror
                        <label for="">Email</label>
                        <input type="email" wire:model.blur="email" class="form-control" placeholder="Name">
                        @error('email')
                            <span class="text-danger">{{$message}}</span><br>
                        @enderror
                        <label for="">Password</label>
                        <input type="text" wire:model.blur="password" class="form-control" placeholder="Password">
                        @error('password')
                            <span class="text-danger">{{$message}}</span><br>
                        @enderror
                        <label for="">Role</label>
                        <select class="form-control" wire:model.blur="role">
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="waiter">Waiter</option>
                            <option value="chef">Chef</option>
                        </select>
                        @error('role')
                            <span class="text-danger">{{$message}}</span><br>
                        @enderror
                        <label for="">Image</label>
                        <input type="file" wire:model.blur="image" class="form-control">
                        @error('image')
                            <span class="text-danger">{{$message}}</span><br>
                        @enderror
                        <button type="submit" class="btn btn-primary mt-2">Create</button>
                    </div>
                </form>
            @endif


        </div>
    </div>



</div>