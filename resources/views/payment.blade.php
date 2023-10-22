<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

@php
    $url = "https://pay.juralacuity.com/public/imgs/bg_image.jpeg";
@endphp
<body style="background: url({{$url}}) top center">


<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" action="{{ route('payment') }}" method="get" id="paymentForm">
                    @csrf
                    <div class="col-md-6">
                        <label for="first-name" class="form-label">
                            First Name
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="first-name" name="first_name" required>
                        <span class="error text-danger" id="first-name-error"></span>

                    </div>
                    <div class="col-md-6">
                        <label for="last-name" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="last-name" name="last_name" required>
                        <span class="error text-danger" id="last-name-error"></span>

                    </div>
                    <div class="col-12">
                        <label for="company" class="form-label">Company (optional)</label>
                        <input type="text" class="form-control" id="company" name="company">
                        <span class="error text-danger" id="company-error"></span>

                    </div>
                    <div class="col-12">
                        <label for="country" class="form-label">Country / Region <span
                                class="text-danger">*</span></label>
                        <select id="country" name="country" class="form-select" required>
                            <option value="" selected>Select</option>
                        </select>
                        <span class="error text-danger" id="country-error"></span>

                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Street Address <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="address" name="address"
                            placeholder="1234 Main St" required>
                        <input type="text" class="mt-2 form-control" id="address2" name="address2"
                            placeholder="Apartment, studio, or floor etc.. (optional)">
                        <span class="error text-danger" id="address-error"></span>
                        <span class="error text-danger" id="address2-error"></span>
                    </div>
                    <div class="col-12">
                        <label for="city" class="form-label">Town / City <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="city" name="city" required>
                        <span class="error text-danger" id="city-error"></span>

                    </div>
                    <div class="col-12">
                        <label for="post-code" class="form-label">Post Code / Zip (optional)</label>
                        <input type="text" class="form-control" id="post-code" name="post_code"
                            >
                        <span class="error text-danger" id="post-code-error"></span>

                    </div>
                    <div class="col-12">
                        <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="phone"
                            name="phone" required>
                        <span class="error text-danger" id="phone-error"></span>

                    </div>
                    <div class="col-12">
                        <label for="email" class="form-label">Email
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="email" name="email" required
                            placeholder="some@example.com">
                        <span class="error text-danger" id="email-error"></span>

                    </div>
                    <div class="col-12">
                        <label for="invoice" class="form-label">Invoice (optional)</label>
                        <input type="text" class="form-control" id="invoice" name="invoice">
                        <span class="error text-danger" id="invoice-error"></span>
                    </div>
                    <div class="col-12">
                        <label for="amount" class="form-label">Amount
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="amount" name="amount" required
                            placeholder="e.g: $10" min="10">
                        <span class="error text-danger" id="amount-error"></span>

                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms"
                                value="true" required>
                            <label class="form-check-label" for="terms">
                                I have read and agree to the website terms and conditions <span
                                    class="text-danger">*</span>
                            </label>
                        </div>
                        <span class="error text-danger" id="terms-error"></span>

                    </div>
                    <div class="col-12 mx-auto text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

<script>
    $(document).ready(function() {
        $('#paymentModal').modal('show');
        $("#paymentForm").validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 3,
                },
                last_name: {
                    required: true,
                    minlength: 3,
                },
                company: {
                    minlength: 3,
                },
                country: {
                    required: true,
                },
                address: {
                    required: true,
                    minlength: 3,
                },
                address2: {
                    minlength: 3,
                },
                city: {
                    required: true,
                    minlength: 3,
                },
                phone: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                amount: {
                    required: true,
                },
                terms: {
                    required: true,
                },
            },
            messages: {
                first_name: {
                    required: "Please enter your first name",
                    minlength: "Your first name must be at least 3 characters long",
                },
                last_name: {
                    required: "Please enter your last name",
                    minlength: "Your last name must be at least 3 characters long",
                },
                company: {
                    minlength: "Your company name must be at least 3 characters long",
                },
                country: {
                    required: "Please select your country",
                },
                address: {
                    required: "Please enter your address",
                    minlength: "Your address must be at least 3 characters long",
                },
                address2: {
                    minlength: "Your address must be at least 3 characters long",
                },
                city: {
                    required: "Please enter your city",
                    minlength: "Your city name must be at least 3 characters long",
                },
                phone: {
                    required: "Please enter your phone number",
                },
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address",
                },
                amount: {
                    required: "Please enter your amount",
                },
                terms: {
                    required: "Please accept our terms and conditions",
                },
            },
            errorPlacement: function(error, element) {
                error.appendTo("#" + element.attr("id") + "-error");
            },
        });
        country();
    });
    const country = async () => {
        const url = 'https://restcountries.com/v3.1/all';

        try {
            const response = await fetch(url);
            const result = await response.json();
            // sort country by name
            result.sort((a, b) => {
                if (a.name.common < b.name.common) {
                    return -1;
                }
                if (a.name.common > b.name.common) {
                    return 1;
                }
                return 0;
            });
            const  country = result.reduce((acc, country) => {
                acc += `<option value="${country.name.common}">${country.name.common}</option>`;
                return acc;
            }, '');
            $('#country').append(country);
        } catch (error) {
            console.error(error);
        }
    }
</script>
