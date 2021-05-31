@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('prodects.edit_product') }}</div>
                    <div class="card-body">

                        @if ($errors->any())

                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                        @endif

                            <form action="{{ route('products.update',$product) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <ul class="nav nav-tabs " id="mytab" role="tablist">
                                    @foreach (config('locales.languages') as $key => $value)
                                        <li class="nav-item" role="presentation">
                                            <a href="#{{ $key }}" class="nav-link {{ $loop->index == 0 ? 'active': '' }}" data-toggle="tab" id="{{ $key }}-tab" role="tab"
                                                aria-controls="{{ $key }}" aria-selected="true">{{ $value['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>


                                <div class="tab-content" id="myTabContent">
                                @foreach (config('locales.languages') as $key => $value)

                                    <div class="tab-pane fade {{ $loop->index == 0 ? 'active show': '' }}" id="{{ $key }}"
                                        role="tabpanel" aria-labelledby="{{ $key }}-tab">
                                        <div class="form-group">
                                            <label for="title">{{ __('prodects.title') }} ({{ $key }})</label>
                                            <input type="text" name="title[{{ $key }}]" value="{{ old('title'.$key, $product->getTranslation('title',$key)) }}" class="form-control" placeholder="Enter Title Product" aria-describedby="helpId">
                                            @error('title') <snap class="text-danger">{{ $message }}</snap>  @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="dec">{{ __('prodects.dec') }} ({{ $key }})</label>
                                            <textarea class="form-control" name="dec[{{ $key }}]" value="{{ old('dec'.$key,$product->getTranslation('dec',$key)) }}" rows="3"></textarea>
                                            @error('dec') <snap class="text-danger">{{ $message }}</snap>  @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="price">{{ __('prodects.price') }} ({{ $key }})</label>
                                            <input type="text" class="form-control" name="price[{{ $key }}]" value="{{ old('price'.$key, $product->getTranslation('title',$key)) }}" aria-describedby="helpId" placeholder="0.0">
                                            @error('price') <snap class="text-danger">{{ $message }}</snap>  @enderror
                                        </div>
                                    </div>
                                @endforeach

                                </div>
                                <div class="form-group">
                                    <button type="submit"  name="submit" class="btn btn-primary"> {{ __('prodects.edit_product') }}</button>
                                </div>
                            </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
