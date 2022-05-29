{{-- @dd($products) --}}
@extends('main')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <h1>Product List</h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <a href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>

                {{-- button multi delete --}}
                <button type="submit" class="btn btn-danger" onclick="deleteSelected()">Delete Selected</button>

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>
                                    <input type="checkbox" name="id[]" id="id[]" value="{{ $product->id }}">
                                </td>
                                <td>{{ $no++ }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                @if ($product->category)
                                    <td>{{ $product->category->name }}</td>
                                @else
                                    <td>No Category</td>
                                @endif
                                <td>
                                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="/product/{{ $product->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                        {{-- button onclick confirm --}}
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteSelected() {
            var id = [];
            $('input:checkbox[name="id[]"]:checked').each(function() {
                id.push($(this).val());
            });
            if (id.length > 0) {
                // confirm
                if (confirm('Are you sure?')) {
                    $.ajax({
                        url: '/product/multi-delete',
                        type: 'POST',
                        data: {
                            ids: id,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            console.log(data);
                            location.reload();
                        }
                    });
                }
            } else {
                alert('Please select at least one product');
            }
        }
    </script>
@endsection
