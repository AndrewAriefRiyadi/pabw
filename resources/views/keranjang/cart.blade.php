@extends('layouts.base')
@section('content')
<section class="breadcrumb-section section-b-space" style="padding-top:20px;padding-bottom:20px;">
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Cart</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-produk">
                            <a href="/">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-produk active" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Cart Section Start -->
<section class="cart-section section-b-space">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @empty($produks)
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Your Cart is Empty !</h2>
                    <h5 class='mt-3'>Add produks to it now</h5>
                    <a href="/" class="btn btn-warning mt-5">Shop Now</a>
                </div>
            </div>
        @endempty
        <div class="row">
            <div class="col-md-12 text-center">
                <table class="table cart-table">
                    <thead>
                        <tr class="table-head">
                            <th scope="col">image</th>
                            <th scope="col">product name</th>
                            <th scope="col">price</th>
                            <th scope="col">quantity</th>
                            <th scope="col">total</th>
                            <th scope="col">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produks as $produk)
                        <tr>
                            <td>
                                <a href="/produk/{{$produk->produk->user->username}}/{{$produk->produk->id}}">
                                    <img src="{{asset('storage/'.$produk->produk->foto)}}" class="blur-up lazyloaded"
                                        alt="{{ $produk->produk->foto }}">
                                </a>
                            </td>
                            <td>
                                <a href="/produk/{{$produk->produk->user->username}}/{{$produk->produk->id}}">{{ $produk->produk->nama }}</a>
                                <div class="mobile-cart-content row">
                                    <div class="col">
                                        <div class="qty-box">
                                            <div class="input-group">
                                                <input type="text" name="quantity" class="form-control input-number"
                                                    value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h2>Rp {{ $produk->produk->harga }}</h2>
                                    </div>
                                    <div class="col">
                                        <h2 class="td-color">
                                            <a href="javascript:void(0)">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h2>Rp {{ $produk->produk->harga }}</h2>
                            </td>
                            <td>
                                <div class="qty-box flex flex-row gap-3 justify-center">
                                    <form action="/keranjang/{{Auth::user()->username}}/kurang" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="id_produk" value="{{$produk->produk->id}}">
                                        <button type="submit" class=" bg-blue-300 px-2 rounded center"> - </button>
                                    </form>
                                    <p>{{$produk->jumlah}}</p>
                                    <form action="/keranjang/{{Auth::user()->username}}/tambah" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="id_produk" value="{{$produk->produk->id}}">
                                        <button type="submit" class=" bg-green-400 px-2 rounded center"> + </button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <h2 class="td-color">Rp {{ $produk->jumlah * $produk->produk->harga}}</h2>
                            </td>
                            <td>
                                <form action="/keranjang/{{Auth::user()->username}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_produk" value="{{$produk->produk->id}}">
                                    <button type="submit" class=" bg-red-400 p-2 rounded center"> DELETE </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-12 mt-md-5 mt-4">
                <div class="row">
                    <div class="col-sm-7 col-5 order-1">
                        {{-- <div class="left-side-button text-end d-flex d-block justify-content-end">
                            <a href="javascript:void(0)"
                                class="text-decoration-underline theme-color d-block text-capitalize">clear
                                all produks</a>
                        </div> --}}
                    </div>
                    <div class="col-sm-5 col-7">
                        <div class="left-side-button float-start">
                            <a href="/" class="btn btn-solid-default btn fw-bold mb-0 ms-0">
                                <i class="fas fa-arrow-left"></i> Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
            @if (!empty($produks))
            <div class="cart-checkout-section">
                <div class="row g-4">
                    <div class="col-lg-4 col-sm-6">
                        {{-- <div class="promo-section">
                            <form class="row g-3">
                                <div class="col-7">
                                    <input type="text" class="form-control" id="number" placeholder="Coupon Code">
                                </div>
                                <div class="col-5">
                                    <button class="btn btn-solid-default rounded btn">Apply Coupon</button>
                                </div>
                            </form>
                        </div> --}}
                    </div>

                    <div class="col-lg-4 col-sm-6 ">
                        
                    </div>

                    <div class="col-lg-4">
                        <div class="cart-box">
                            <div class="cart-box-details">
                                <div class="total-details">
                                    <div class="top-details">
                                        <h3>Cart Totals</h3>
                                        <h3>Rp {{$keranjang->harga_total}}</h3>
                                    </div>
                                    <div class="bottom-details">
                                        <form action="/pesanan/{{Auth::user()->username}}" method="post" class="self-end">
                                            @csrf
                                            <input type="hidden" name="id_keranjang" value="{{$keranjang->id}}">
                                            <button type="submit" class=" bg-yellow-400 p-2 rounded center w-full"> Buat Pesanan </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            @endif
            
        </div>     
    </div>
</section>
@endsection