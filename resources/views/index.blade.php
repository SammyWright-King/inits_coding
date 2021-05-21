<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SuperFreighters</title>

    <!-- Font Icon -->
    <link rel="stylesheet"  href="{{ asset('assets/fonts/material-icon/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href={{ asset("assets/vendor/nouislider/nouislider.min.css") }}>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src='http://code.jquery.com/jquery-1.9.1.min.js'></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <!-- Main css -->
    <link rel="stylesheet" href= {{ asset("assets/css/style.css") }}>
</head>
<body>

    <div class="main">

        <div class="container">
            <div class="signup-content">
                <div class="signup-img">
                    <img src={{ asset("assets/images/shipping.png")}} alt="">
                    <div class="signup-img-content">
                        <h2>SuperFreighters</h2>
                        <p>Fast and Reliable Delivery!</p>
                    </div>
                </div>
                <div class="signup-form">
                    <form method="POST" action="{{route('pay')}}" class="register-form" id="register-form">
                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="first_name" class="required">Name</label>
                                    <input type="text" name="name" id="first_name" />
                                </div>
                                <div class="form-input">
                                    <label for="email" class="required">Email</label>
                                    <input type="text" name="email_" id="email_" />
                                </div>
                                <div class="form-input">
                                    <label for="phone_no" class="required">Phone number</label>
                                    <input type="text" name="phone_no" id="phone_no" />
                                </div>
                                <div class="form-input">
                                    <label for="address" class="required">Address</label>
                                    <input type="text" name="address" id="address" />
                                </div>

                                <div class="form-input">
                                    <div class="label-flex">
                                        <label for="meal_preference" class="required">Country</label>
                                        <a href="#" class="form-link">choose your location</a>
                                    </div>
                                    <select name="country" class="form-select" id="country">
                                        @foreach($countries as $country)
                                            <option value="{{$country}}">{{$country}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <div class="form-input">
                                    <label for="product" class="required">Product</label>
                                    <input type="text" name="product" id="product" />
                                </div>

                                <div class="form-input">
                                    <label for="exampleFormControlTextarea1">Product Description</label>
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>

                                <div class="form-input">
                                    <div class="label-flex">
                                        <label for="meal_preference" class="required">Destination</label>
                                        <a href="#" class="form-link">select delivery destination</a>
                                    </div>
                                    <select name="destination" class="form-select" id="destination">
                                        <option value="Ghana">Ghana</option>
                                        <option value="India">India</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="sweden">Sweden</option>
                                    </select>
                                </div>

                                <div class="form-input">
                                    <label class="required">Weight</label>
                                    <input type="number" name="weight" id="weight"/>
                                </div>

                                <div class="form-input">
                                    <div class="label-flex">
                                        <label for="meal_preference">Mode</label>
                                        <a href="#" class="form-link">select mode of delivery</a>
                                    </div>
                                    <select name="mode" class="form-select" id="mode">
                                        @foreach($modes as $mode)
                                            <option value="{{$mode}}">{{$mode}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-input">
                                    <label for="product" class="required">Total</label>
                                    <input type="text" name="total" id="total" value="60800" readonly/>
{{--                                    <input type="button" value="calculate" class="button-success" id="calculate">--}}
                                </div>

                                <div>
                                    <input type="hidden" id="email" name="email" value="otemuyiwa@gmail.com"> {{-- required --}}
                                    <input type="hidden" name="orderID" value="345">
                                    <input type="hidden" id="amount" name="amount" value="60800"> {{-- required in kobo --}}
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="currency" value="NGN">
                                    <input type="hidden" name="metadata" value="{{ json_encode($array = ['key_name' => 'value',]) }}" > {{-- For other necessary things you want to add to your payload. it is optional though --}}
{{--                                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">--}}
                                    <input type="hidden" name="reference" id="ref" value="{{ Paystack::genTranxRef() }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-input">
                            <div class="row">
                                <div class="col">
                                    <input type="button" value="Submit Order" class="button-success submit" id="order"/>
                                </div>
                                <div class="col">
                                    <input type="submit" value="Pay" class="pay" id="submit" name="submit" />
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- JS -->

    <script src={{ asset("assets/vendor/jquery/jquery.min.js")}}></script>
    <script src= {{ asset("assets/vendor/nouislider/nouislider.min.js") }}></script>
    <script src={{ asset("assets/vendor/wnumb/wNumb.js")}}></script>
    <script src={{ asset("assets/vendor/jquery-validation/dist/jquery.validate.min.js")}}></script>
    <script src={{ asset("assets/vendor/jquery-validation/dist/additional-methods.min.js")}}></script>
    <script src={{ asset("assets/js/main.js")}}></script>
    <script>
        $(document).ready(function (){
            function calculate(){
                total = 0;
                if($('#country').children(':selected').text() == 'Uk'){
                    flat_rate = 800
                }else{
                    flat_rate = 1500
                }

                if($('#mode').children(':selected').text() == 'Air'){
                    base_fare = 50000
                    rate = 10000
                }else{
                    base_fare = 15000
                    rate = 2000
                }

                if($('#weight').val() == ""){
                    qty = 1
                }else{
                    qty = $('#weight').val()
                }

                total = flat_rate + (rate * qty) + base_fare
                $('#total').val(total)
                $('#amount').val(total)
            }

            $('#calculate').on('click', function (){
                calculate()
            });

            $('#country').on('change', function (){
                total = $('#total').val()
                if($('#country').children(':selected').text() == 'Uk'){
                    total = (total - 50000) + 15000
                    $('#total').val(total)
                }else{
                    //total = (total - 15000) + 50000
                    $('#total').val(total)
                }
                $('#amount').val(total)
                $('#email').val($('#email_').val())
            });

            $('#order').click(function(e){
                e.preventDefault();

                if($('#first_name').val() == ""){
                    toastr.warning('Name is Empty')
                }else if($('#email_').val() == ""){
                    toastr.warning('Email is Empty')
                }else if($('#phone_no').val() == ""){
                    toastr.warning('Phone No is Empty')
                }else if($('#address').val() == ""){
                    toastr.warning('Address is Empty')
                }else if($('#country').val() == ""){
                    toastr.warning('Pickup Country is Empty')
                }else if($('#product').val() == ""){
                    toastr.warning('Product is Empty')
                }else if($('#destination').val() == ""){
                    toastr.warning('Delivery Destination is Empty')
                }else if($('#weight').val() == ""){
                    toastr.warning('Weight is Required')
                }else if($('#mode').val() == ""){
                    toastr.warning('Delivery Mode is Required')
                }else{
                    form = $('#register-form').serialize()

                    $.ajax({
                        url: "/shipping/order",
                        type:"POST",
                        data: form,
                        success:function(response){
                            calculate()
                            $('#ref').val(response)
                            toastr.success("Shipping Order Created Successfully!")
                        },
                    });
                }

            })

        })
    </script>
</body>
</html>
