@extends('main')

@section('content')
    {{-- all category --}}
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>All Category</h1>
            </div>
        </div>
        <div class="row">


            <div class="col-md-12">
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
                <a href="/category/create" class="btn btn-primary">Add Category</a>
                <button type="submit" class="btn btn-danger" onclick="deleteSelected()">Delete Selected</button>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    <input type="checkbox" name="id[]" id="id[]" value="{{ $category->id }}">
                                </td>
                                <td>{{ $no++ }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        {{-- button with confirm --}}
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure want to delete this category?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            if (id.length === 0) {
                alert('Please select at least one item');
            } else {
                $.ajax({
                    url: '/category/multi-delete',
                    type: 'POST',
                    data: {
                        ids: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            alert(data.message);
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    }
                });
            }
        }
    </script>
@endsection
