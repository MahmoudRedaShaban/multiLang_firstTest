@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ $product->title  ?? '' }}</div>
                    <div class="card-body">
                        {{ $product->dec ?? ''  }}
                    </div>
                    <div class="card-footer flax">
                        <span class="flax-start">{{ $product->price ?? ''  }}</span>
                        <button type="button" class="btn btn-outline-info flax-end">PyNow</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
