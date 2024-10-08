{{--    $pdoducts needed, first define $products    --}}

<div class="card-body px-0 pt-0 pb-2">
    <div class="table-responsive p-0">
        <table class="table align-items-center justify-content-center mb-0">
            <thead>
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">sn</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">User</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Actions</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $key => $value)
                <tr>
                    <td>
                        <div class="ms-3">
                            {{$key+1}}
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('pro.show', $value->id) }}" class="text-sm font-weight-bold mb-0" target="_blank">{{$value->name}}</a>
                    </td>
                    <td>
                        <span class="text-xs font-weight-bold">{{ $value->category ? $value->category->category_name : ''}}</span>
                    </td>
                    <td class="align-middle text-center">
                        @if($value->user)
                            <a href="{{ route('user', $value->user->id) }}" class="text-sm mb-0" target="_blank">{{$value->user->name }}</a>
                        @endif
                    </td>
                    <td class="align-middle text-center">
                        @if(auth()->user()->type == 1 || ($value->user && auth()->user()->id == $value->user->id))
                            <a href="{{ route('admin.pro.edit', $value->id) }}" class="btn btn-warning p-2 mb-0">Update</a>
                            <a onclick="return confirm('Are you sure to delete this product?')" href="{{ route('admin.pro.del', $value->id) }}" class="btn btn-danger p-2 mb-0">Delete</a>
                        @else
                            <a href="{{ route('toast.wa') }}" class="btn btn-secondary p-2 mb-0">Update</a>
                            <a href="{{ route('toast.wa') }}" class="btn btn-secondary p-2 mb-0">Delete</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>