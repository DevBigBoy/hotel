@extends('frontend.layouts.master')


@section('content')
    <!-- Inner Banner -->
    <div class="inner-banner inner-bg7">
        <div class="container">
            <div class="inner-title">
                <ul>
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li> Check Out</li>
                </ul>
                <h3> Check Out</h3>
            </div>
        </div>
    </div>
    <!-- Inner Banner End -->
    <!-- Checkout Area -->
    <section class="checkout-area pt-100 pb-70">
        <div class="container">
            <form>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="billing-details">
                            <h3 class="title">Billing Details</h3>
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label for="country">Country <span class="required">*</span></label>
                                        <select style="max-height: 200px" class="form-select" size="3"
                                            aria-label="size 3 select example">
                                            <option value="" selected disabled>Select a country</option>
                                            @foreach ($countries as $countryCode => $countryName)
                                                <option value="{{ $countryCode }}">{{ $countryName }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>First Name <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Last Name <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Company Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div class="form-group">
                                        <label>Address <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div class="form-group">
                                        <label>Town / City <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>State / County <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Postcode / Zip <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Email Address <span class="required">*</span></label>
                                        <input type="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>Phone <span class="required">*</span></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <p>Session Value : {{ json_encode(session('book_date')) }}</p>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="create-an-account">
                                        <label class="form-check-label" for="create-an-account">Create an account?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4">
                        <section class="checkout-area pb-70">
                            <div class="card-body">
                                <div class="billing-details">
                                    <h3 class="title">Booking Summary</h3>
                                    <hr>

                                    <div style="display: flex">
                                        <img style="height:100px; width:120px;object-fit: cover" src=" "
                                            alt="Images" alt="Images">
                                        <div style="padding-left: 10px;">
                                            <a href=" " style="font-size: 20px; color: #595959;font-weight: bold">Room
                                                Name</a>
                                            <p><b>120 / Night</b></p>
                                        </div>

                                    </div>

                                    <br>

                                    <table class="table" style="width: 100%">

                                        <tr>
                                            <td>
                                                <p>Total Night ( 4)</p>
                                            </td>
                                            <td style="text-align: right">
                                                <p>Room Name</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Total Room</p>
                                            </td>
                                            <td style="text-align: right">
                                                <p>3</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Subtotal</p>
                                            </td>
                                            <td style="text-align: right">
                                                <p>200</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Discount</p>
                                            </td>
                                            <td style="text-align:right">
                                                <p>Discount</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <p>Total</p>
                                            </td>
                                            <td style="text-align:right">
                                                <p>Total</p>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-8 col-md-8">
                        <div class="payment-box">
                            <div class="payment-method">
                                <p>
                                    <input type="radio" id="direct-bank-transfer" name="radio-group" checked>
                                    <label for="direct-bank-transfer">Direct Bank Transfer</label>
                                    Make your payment directly into our bank account. Please use your Order
                                    ID as the payment reference. Your order will not be shipped until the funds have cleared
                                    in our account.
                                </p>
                                <p>
                                    <input type="radio" id="paypal" name="radio-group">
                                    <label for="paypal">PayPal</label>
                                </p>
                                <p>
                                    <input type="radio" id="cash-on-delivery" name="radio-group">
                                    <label for="cash-on-delivery">Cash On Delivery</label>
                                </p>
                            </div>
                            <a href="#" class="order-btn three">
                                Place to Order
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- Checkout Area End -->
@endsection
