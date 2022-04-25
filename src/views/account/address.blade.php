@include('laravel-shop::common.header')

<div class="container">
    <nav aria-label="breadcrumb" class="row col-12 mt-lg-3">
        <ol class="breadcrumb breadcrumb-wrapper col-12 m-0 pt-0 pb-0 font-14">
            <li class="breadcrumb-item"><a href="/index"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="/account/account">Account</a></li>
            <li class="breadcrumb-item"><a href="/account/address">Address Book</a></li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between">
        @include('laravel-shop::account.leftmenu')
        <div class="main-section">
            <div class="gs-account">
                <div class="top-desc text-left">
                    <h1 class="d-flex justify-content-between">
                        Shipping Address
                        <span class="pull-right h1-action"><a href="/account/address/add"><i class="fa fa-plus"></i> Add Address</a></span>
                    </h1>
                </div>
                <div class="row account-info">
                    @foreach($res['list']['data'] as $val)
                    <div class="col-12 mt-5">
                        <p class="address-name">Name: a a </p>
                        <p class="address-cont">Address: aaa , aaa , Angus , United Kingdom</p>
                        <p class="address-phone">Postcode: aaa</p>
                        <p class="col01">
                            <a href="index.php?route=account/address/edit&amp;address_id=14">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="javascript:;" data-address-id="14" class="delete-address ml-5">
                                <i class="fa fa-trash"></i> Remove
                            </a>
                        </p>
                    </div>
                    @endforeach
                    <div class="col-12 mt-5">
                        <p class="address-name">Name: i i <span class="badge badge-success pull-right">default</span></p>
                        <p class="address-cont">Address: aaa , aaa , Ceredigion , United Kingdom</p>
                        <p class="address-phone">Postcode: aaa</p>
                        <p class="col01">
                            <a href="index.php?route=account/address/edit&amp;address_id=19">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="javascript:;" data-address-id="19" class="delete-address ml-5">
                                <i class="fa fa-trash"></i> Remove
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('laravel-shop::common.footer')
