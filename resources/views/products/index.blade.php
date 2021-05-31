@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-title">Prodects</div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th colspan="4">
                                        <form action="{{ route('product.index') }}" method="get">
                                            <div class="input-group mb-3">
                                                <input type="text" name="keyword" value="{{ old('keyword',request()->input('keyword')) }}" class="form-control" placeholder="{{ __('prodects.keyword') }}">
                                                <div class="input-gourp-append">
                                                    <button type="submit" class="btn btn-outline-primary">{{ __('prodects.search') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </th>
                                </tr>
                                <tr>
                                    <th>{{ __('prodects.id') }}</th>
                                    <th>{{ __('prodects.title') }}</th>
                                    <th>{{ __('prodects.price') }}</th>
                                    <th>{{ __('prodects.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->slug) }}"><i class="fa fa-edit"></i></a>
                                        <a href="javascript:void(0);"
                                        onclick="if (confirm('Are you Sure?')) {document.getElementById('delete-product-{{ $product->id }}').submit();} else{return false;}"><i class="fa fa-trash text-danger"></i></a>
                                        <form action="{{ route('products.destroy', $product) }}" method="post" id="delete-product-{{ $product->id }}" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
