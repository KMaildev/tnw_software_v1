@extends('layouts.menu.marketing')
@section('content')
    <div class="page">
        <div class="page-header">
            <h1 class="page-title">
                Makerting Team
            </h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('marketing_team.index') }}">
                        Makerting Team
                    </a>
                </li>
                <li class="breadcrumb-item active">
                    Create
                </li>
            </ol>
        </div>

        <div class="page-content container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Marketing Data
                            </h3>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('marketing_team.store') }}" method="POST" autocomplete="off"
                                id="create-form" role="form" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group form-material">
                                    <div>
                                        <div class="radio-custom radio-default radio-inline">
                                            <input type="radio" id="sale_offer" name="offer_status" value="sale_offer"
                                                checked />
                                            <label for="sale_offer">
                                                Sale Offer
                                            </label>
                                        </div>

                                        <div class="radio-custom radio-default radio-inline">
                                            <input type="radio" id="rent_offer" name="offer_status" value="rent_offer" />
                                            <label for="rent_offer">
                                                Rent Offer
                                            </label>
                                        </div>

                                        <div class="radio-custom radio-default radio-inline" hidden>
                                            <input type="radio" id="buy_offer" name="offer_status" value="buy_offer" />
                                            <label for="buy_offer">
                                                Buy Offer
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="mb-b fw-normal" style="color: red; font-weight: bold; font-size: 19px;">
                                    1. Property Information
                                </h6>
                                <hr>

                                <div class="mb-4 row">
                                    <label for="html5-text-input" class="col-md-3 col-form-label">
                                        Date
                                    </label>
                                    <div class="col-md-9">
                                        <input id="datetimepicker4"
                                            class="form-control @error('marketing_date') is-invalid @enderror"
                                            type="text" name="marketing_date" value="{{ old('marketing_date') }}" />
                                        @error('marketing_date')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-4 row">
                                    <label for="html5-text-input" class="col-md-3 col-form-label">
                                        No / အိမ်အမှတ်
                                    </label>
                                    <div class="col-md-9">
                                        <input class="form-control @error('no') is-invalid @enderror" type="text"
                                            name="no" value="{{ old('no') }}" id="No"
                                            oninput="getAlreadyMarketingProperty()" />
                                        @error('no')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4 row">
                                    <label for="html5-text-input" class="col-md-3 col-form-label">
                                        Road / လမ်း
                                    </label>
                                    <div class="col-md-9">
                                        <input class="form-control @error('road') is-invalid @enderror" type="text"
                                            name="road" value="{{ old('road') }}" id="Road"
                                            oninput="getAlreadyMarketingProperty()" />
                                        @error('road')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Township Group --}}
                                <div class="mb-3 row">
                                    <label for="select2Multiple" class="col-md-3 form-label">
                                        Township
                                    </label>
                                    <div class="col-md-3">
                                        <select class="form-control form-control-lg" data-plugin="select2"
                                            name="township_id">
                                            <option value="">--Select Township--</option>
                                            @foreach ($regions as $region)
                                                <optgroup label="{{ $region->region ?? '' }}">
                                                    @foreach ($region->townships_table as $township)
                                                        <option value="{{ $township->id ?? '' }}">
                                                            - {{ $township->township ?? '' }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        @error('township_id')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon">Ward</span>
                                                <input list="WardList"
                                                    class="form-control @error('ward') is-invalid @enderror" type="text"
                                                    name="ward" value="{{ old('ward') }}" id="WardNo"
                                                    oninput="getAlreadyMarketingProperty()" />
                                                <datalist id="WardList"></datalist>
                                                @error('ward')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Property Type --}}
                                <div class="mb-4 row">
                                    <label for="html5-text-input" class="col-md-3 col-form-label">
                                        Property Type
                                    </label>
                                    <div class="col-md-3">
                                        <select class="form-control" data-plugin="select2" name="property_type_id">
                                            <option value="">--Select Property Type--</option>
                                            @foreach ($property_types as $property_type)
                                                <option value="{{ $property_type->id }}">
                                                    {{ $property_type->property_type ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('property_type_id')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6" id="FloorStatus">
                                        <div class="input-group">
                                            <span class="input-group-addon">Floor</span>
                                            <input list="floorList"
                                                class="form-control @error('floor') is-invalid @enderror" type="text"
                                                name="floor" value="{{ old('floor') }}" />
                                            <datalist id="floorList">
                                                <option value="Ground Floor">Ground Floor</option>
                                                <option value="Penthouse">Penthouse</option>
                                                @for ($i = 1; $i < 25; $i++)
                                                    <option value="{{ $i }}">
                                                @endfor
                                            </datalist>
                                            @error('floor')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="HouseStatus">
                                        <div class="input-group">
                                            <span class="input-group-addon">House Style</span>
                                            <input list="HouseStyleList"
                                                class="form-control @error('house_style') is-invalid @enderror"
                                                type="text" name="house_style" value="{{ old('house_style') }}" />
                                            <datalist id="HouseStyleList">
                                                <option value="ပျဉ်ထောင်အိမ်">
                                                    ပျဉ်ထောင်အိမ်
                                                </option>
                                                <option value="RC">
                                                    RC
                                                </option>
                                                <option value="Steel Structure">
                                                    Steel Structure
                                                </option>
                                                <option value="Brick Nogging House">
                                                    Brick Nogging House
                                                </option>
                                                <option value="ပျဉ်ထောင် အုတ်တွဲ">
                                                    ပျဉ်ထောင် အုတ်တွဲ
                                                </option>
                                                <option value="ထရံအိမ်">
                                                    ထရံအိမ်
                                                </option>
                                            </datalist>
                                            @error('house_style')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Price --}}
                                <div class="mb-4 row">
                                    <label for="html5-text-input" class="col-md-3 col-form-label">
                                        Price
                                    </label>
                                    <div class="col-md-3">
                                        <div class="input-daterange">
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    name="price" />
                                                <span class="input-group-addon">
                                                    Lakhs
                                                </span>
                                            </div>
                                            @error('price')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Rent Offer --}}
                                <div class="py-5 row" id="RentOfferDiv">
                                    <br>
                                    <div class="col-md-12">
                                        <h6 class="mb-b fw-normal"
                                            style="color: red; font-weight: bold; font-size: 19px;">
                                            3. Rent Offer
                                        </h6>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-material">
                                                    <label class="form-control-label">
                                                        Contract Status
                                                    </label>
                                                    <div>
                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="MolthlyContract"
                                                                name="rent_offer_contract_status"
                                                                value="monthly_contract" />
                                                            <label for="MolthlyContract">
                                                                လချုပ်
                                                            </label>
                                                        </div>

                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="YearlyContracy"
                                                                name="rent_offer_contract_status"
                                                                value="yearly_contract" />
                                                            <label for="YearlyContracy">
                                                                နှစ်ချုပ်
                                                            </label>
                                                        </div>

                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="Deposit"
                                                                name="rent_offer_contract_status" value="deposit" />
                                                            <label for="Deposit">
                                                                Deposit
                                                            </label>
                                                        </div>
                                                        @error('rent_offer_contract_status')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row py-4" id="DepositAmount">
                                            <div class="col-md-4">
                                                <div class="input-daterange">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            Deposit Amount
                                                        </span>
                                                        <input type="text"
                                                            class="form-control @error('deposit_amount') is-invalid @enderror"
                                                            name="deposit_amount" value="0" />
                                                        @error('deposit_amount')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                {{-- Area --}}
                                <div class="py-5 row">
                                    <div class="col-md-12">
                                        <h6 class="mb-b fw-normal"
                                            style="color: red; font-weight: bold; font-size: 19px;">
                                            2. Area Specifications
                                        </h6>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="input-daterange" id="AreaWidthHeight">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">W</span>
                                                        <input type="text" class="form-control" name="area_width"
                                                            id="AreaWidth" oninput="setAreaCalc()" />
                                                        @error('area_width')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror

                                                        <span class="input-group-addon">H</span>
                                                        <input type="text" class="form-control" name="area_height"
                                                            id="AreaHeight" oninput="setAreaCalc()" />
                                                        @error('area_height')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="input-daterange" id="Area">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="area" />
                                                        @error('area_height')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-2" id="AreaTypeStatus">
                                                <div class="row">
                                                    <div class="input-group">
                                                        <div class="col-md-12">
                                                            <select class="form-control" name="area_type"
                                                                style="width: 100%">
                                                                <option value="Sqft">
                                                                    Sqft
                                                                </option>
                                                                <option value="Acre">
                                                                    Acre
                                                                </option>
                                                            </select>
                                                            @error('area_type')
                                                                <div class="invalid-feedback"> {{ $message }} </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4" id="AreaResult">
                                                <div class="input-daterange">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="SqftResult"
                                                            readonly />
                                                        <span class="input-group-addon">
                                                            Sqft
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Property Specifications --}}
                                <br>
                                <div class="py-5 row">
                                    <div class="col-md-12">
                                        <h6 class="mb-b fw-normal"
                                            style="color: red; font-weight: bold; font-size: 19px;">
                                            3. Property Specifications
                                        </h6>
                                        <hr>
                                        <div class="row" id="Apartment">
                                            <div class="col-md-4" id="BCCStatus">
                                                <div class="form-group form-material">
                                                    <label class="form-control-label">
                                                        BCC Status
                                                    </label>
                                                    <div>
                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="BCCTrue" name="bcc_status"
                                                                value="true" />
                                                            <label for="BCCTrue">
                                                                BCC ကျပြီး
                                                            </label>
                                                        </div>

                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="BCCFalse" name="bcc_status"
                                                                value="false" />
                                                            <label for="BCCFalse">
                                                                BCC မကျပြီး
                                                            </label>
                                                        </div>
                                                        @error('bcc_status')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4" id="OwnerStatus">
                                                <div class="form-group form-material">
                                                    <label class="form-control-label">
                                                        Owner Status
                                                    </label>
                                                    <div>
                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="OwnLand" name="owner_status"
                                                                value="မြေရှင်" />
                                                            <label for="OwnLand">
                                                                မြေရှင်
                                                            </label>
                                                        </div>

                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="OwnApartent" name="owner_status"
                                                                value="တိုက်ခန်း" />
                                                            <label for="OwnApartent">
                                                                တိုက်ခန်း
                                                            </label>
                                                        </div>

                                                        @error('owner_status')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4" id="ListStatus">
                                                <div class="form-group form-material">
                                                    <label class="form-control-label">
                                                        Lift Status (ဓာတ်လှေကား)
                                                    </label>
                                                    <div>
                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="ListTrue" name="lift_status"
                                                                value="Yes" />
                                                            <label for="ListTrue">
                                                                ပါ
                                                            </label>
                                                        </div>

                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="ListFalse" name="lift_status"
                                                                value="No" />
                                                            <label for="ListFalse">
                                                                မပါ
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4">
                                                <div class="form-group form-material">
                                                    <label class="form-control-label">
                                                        Status
                                                    </label>
                                                    <div>
                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="Hall" name="property_status"
                                                                value="Hall" />
                                                            <label for="Hall">
                                                                Hall
                                                            </label>
                                                        </div>

                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="Bedroom" name="property_status"
                                                                value="Bedroom" />
                                                            <label for="Bedroom">
                                                                အိပ်ခန်း
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-4" id="ExtraChargeStatus">
                                                <div class="form-group form-material">
                                                    <label class="form-control-label">
                                                        Extra Charge
                                                    </label>
                                                    <div>
                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="ExtraChargeTrue"
                                                                name="extra_charge" value="Yes" />
                                                            <label for="ExtraChargeTrue">
                                                                ပါ
                                                            </label>
                                                        </div>

                                                        <div class="radio-custom radio-default radio-inline">
                                                            <input type="radio" id="ExtraChargeFalse"
                                                                name="extra_charge" value="No" />
                                                            <label for="ExtraChargeFalse">
                                                                မပါ
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Room Specifications --}}
                                <br>
                                <div class="py-5 row">
                                    <div class="col-md-12">
                                        <h6 class="mb-b fw-normal"
                                            style="color: red; font-weight: bold; font-size: 19px;">
                                            4. Room Specifications
                                        </h6>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Rooms</span>
                                                        <input class="form-control @error('rooms') is-invalid @enderror"
                                                            type="text" name="rooms"
                                                            value="{{ old('rooms') }}" />
                                                        @error('rooms')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Shrine</span>
                                                        <input class="form-control @error('shrine') is-invalid @enderror"
                                                            type="text" name="shrine"
                                                            value="{{ old('shrine') }}" />
                                                        @error('shrine')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Bathrooms</span>
                                                        <input
                                                            class="form-control @error('bathrooms') is-invalid @enderror"
                                                            type="text" name="bathrooms"
                                                            value="{{ old('bathrooms') }}" />
                                                        @error('bathrooms')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Dining</span>
                                                        <input class="form-control @error('dining') is-invalid @enderror"
                                                            type="text" name="dining"
                                                            value="{{ old('dining') }}" />
                                                        @error('dining')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Living</span>
                                                        <input class="form-control @error('living') is-invalid @enderror"
                                                            type="text" name="living"
                                                            value="{{ old('living') }}" />
                                                        @error('living')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Bedrooms</span>
                                                        <input
                                                            class="form-control @error('bedrooms') is-invalid @enderror"
                                                            type="text" name="bedrooms"
                                                            value="{{ old('bedrooms') }}" />
                                                        @error('bedrooms')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Master Bedrooms</span>
                                                        <input
                                                            class="form-control @error('master_bedrooms') is-invalid @enderror"
                                                            type="text" name="master_bedrooms"
                                                            value="{{ old('master_bedrooms') }}" />
                                                        @error('master_bedrooms')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">Other</span>
                                                        <input
                                                            class="form-control @error('other_rooms') is-invalid @enderror"
                                                            type="text" name="other_rooms"
                                                            value="{{ old('other_rooms') }}" />
                                                        @error('other_rooms')
                                                            <div class="invalid-feedback"> {{ $message }} </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- Permission --}}
                                <br>
                                <div class="py-5 row">
                                    <div class="col-md-12">
                                        <h6 class="mb-b fw-normal"
                                            style="color: red; font-weight: bold; font-size: 19px;">
                                            3. Premission
                                        </h6>
                                        <hr>
                                    </div>
                                    <label for="html5-text-input" class="col-md-2 col-form-label">
                                        Premission
                                    </label>
                                    <div class="col-md-3">
                                        <select class="form-control" data-plugin="select2" name="permission_type">
                                            <option value="">
                                                -- Select Premission --
                                            </option>
                                            <option value="grant">
                                                ဂရံ
                                            </option>
                                            <option value="permit">
                                                Permit
                                            </option>
                                            <option value="ancestral_land">
                                                ဘိုးဘွားပိုင်မြေ
                                            </option>
                                        </select>
                                        @error('permission_type')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>

                                    <div class="col-md-3" id="GrantType">
                                        <div class="row">
                                            <div class="input-group">
                                                <div class="col-md-12">
                                                    <select class="select-control" data-plugin="select2"
                                                        name="grant_type" style="width: 100%">
                                                        <option value="">-- Select --</option>
                                                        <option value="အမည်ပေါက်">
                                                            အမည်ပေါက်
                                                        </option>
                                                        <option value="SP">
                                                            SP
                                                        </option>
                                                        <option value="GP">
                                                            GP
                                                        </option>
                                                    </select>
                                                    @error('grant_type')
                                                        <div class="invalid-feedback"> {{ $message }} </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12 py-4">
                                        <div class="form-group form-material">
                                            <div>
                                                <div class="radio-custom radio-default radio-inline">
                                                    <input type="radio" id="Orginal" name="orginal_or_copy"
                                                        value="Orginal" />
                                                    <label for="Orginal">
                                                        မူရင်း
                                                    </label>
                                                </div>

                                                <div class="radio-custom radio-default radio-inline">
                                                    <input type="radio" id="Copy" name="orginal_or_copy"
                                                        value="Copy" />
                                                    <label for="Copy">
                                                        မိတ္တူ
                                                    </label>
                                                </div>

                                                @error('orginal_or_copy')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                {{-- Owner & Agent Info --}}
                                <br>
                                <div class="py-5 row">
                                    <div class="col-md-12">
                                        <h6 class="mb-b fw-normal"
                                            style="color: red; font-weight: bold; font-size: 19px;">
                                            3. Owner / Agent Info
                                        </h6>
                                        <hr>
                                    </div>
                                    <div class="col-md-8 py-4">
                                        <div class="form-group form-material">
                                            <div>
                                                <div class="radio-custom radio-default radio-inline">
                                                    <input type="radio" id="Owner" name="owner_agent"
                                                        value="Owner" checked />
                                                    <label for="Owner">
                                                        Owner
                                                    </label>
                                                </div>

                                                <div class="radio-custom radio-default radio-inline">
                                                    <input type="radio" id="Agent" name="owner_agent"
                                                        value="Agent" />
                                                    <label for="Agent">
                                                        Agent
                                                    </label>
                                                </div>

                                                @error('owner_agent')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="mb-4 row">
                                            <label for="html5-text-input" class="col-md-3 col-form-label">
                                                Name
                                            </label>
                                            <div class="col-md-9">
                                                <input class="form-control @error('name') is-invalid @enderror"
                                                    type="text" name="name" value="{{ old('name') }}" />
                                                @error('name')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row">
                                            <label for="html5-text-input" class="col-md-3 col-form-label">
                                                Phone
                                            </label>
                                            <div class="col-md-9">
                                                <input class="token-example-field form-control @error('phone') is-invalid @enderror"
                                                    type="text" name="phone" value="{{ old('phone') }}"
                                                    data-plugin="tokenfield" id="tokenfield"/>
                                                @error('phone')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row">
                                            <label for="html5-text-input" class="col-md-3 col-form-label">
                                                Email
                                            </label>
                                            <div class="col-md-9">
                                                <input class="form-control @error('email') is-invalid @enderror"
                                                    type="text" name="email" value="{{ old('email') }}" />
                                                @error('email')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row">
                                            <label for="html5-text-input" class="col-md-3 col-form-label">
                                                Address
                                            </label>
                                            <div class="col-md-9">
                                                <input class="form-control @error('address') is-invalid @enderror"
                                                    type="text" name="address" value="{{ old('address') }}" />
                                                @error('address')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4 row">
                                            <label for="html5-text-input" class="col-md-3 col-form-label">
                                                Remark
                                            </label>
                                            <div class="col-md-9">
                                                <input class="form-control @error('remark') is-invalid @enderror"
                                                    type="text" name="remark" value="{{ old('remark') }}" />
                                                @error('remark')
                                                    <div class="invalid-feedback"> {{ $message }} </div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                             

                                        <div class="col-md-12 py-5">
                                            <button type="submit" class="mr-2 btn btn-success float-right">Save</button>
                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="example-wrap">
                        <div class="alert dark alert-icon alert-danger alert-dismissible" role="alert">
                            <i class="icon md-notifications" aria-hidden="true"></i>
                            This property has been already existed!
                        </div>

                        <h3 style="color: red; text-shadow: 5px 5px 5px grey;">
                            Result: <span id="CountAlreadyProperty">0</span>
                        </h3>

                        <div class="example table-responsive">
                            <div id="AlreadyMarketingPropertyLists"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\StoreMarketingTeam', '#create-form') !!}
    <script type="text/javascript">
        $(document).ready(function() {
            // 1 = Apartment
            // 2 = Condo
            // 3 = House
            $('select[name="property_type_id"]').on('change', function() {
                var propertyType = $(this).val();
                if (propertyType == 1) {
                    $("#FloorStatus").show();
                    $("#HouseStatus").hide();
                } else if (propertyType == 2) {
                    $("#FloorStatus").show();
                    $("#HouseStatus").hide();
                } else if (propertyType == 3) {
                    $("#FloorStatus").hide();
                    $("#HouseStatus").show();
                }

            });
            $("#FloorStatus").hide();
            $("#HouseStatus").hide();


            // Area 
            $('select[name="area_type"]').on('change', function() {
                var areaType = $(this).val();
                if (areaType === 'Sqft') {
                    $("#AreaWidthHeight").show();
                    $("#AreaResult").show();
                    $("#Area").hide();
                } else if (areaType === 'Acre') {
                    $("#AreaWidthHeight").hide();
                    $("#AreaResult").hide();
                    $("#Area").show();
                }
            });
            $("#Area").hide();


            // Premission
            $('select[name="permission_type"]').on('change', function() {
                var contractStatus = $(this).val();
                if (contractStatus === 'grant') {

                } else if (contractStatus === 'permit') {
                    $("#GrantType").hide();
                } else if (contractStatus === 'ancestral_land') {
                    $("#GrantType").hide();
                }
            });
            $("#Area").hide();


            $('input[name="offer_status"]').change(function() {
                var offerType = $(this).val();
                if (offerType === 'sale_offer') {
                    $("#RentOfferDiv").hide();
                } else if (offerType === 'rent_offer') {
                    $("#RentOfferDiv").show();
                } else if (offerType === 'buy_offer') {
                    $("#RentOfferDiv").hide();
                }
            });
            $("#RentOfferDiv").hide();

            // Rent Offer
            $('input[name="rent_offer_contract_status"]').change(function() {
                var permissionType = $(this).val();
                if (permissionType === 'monthly_contract') {
                    $("#DepositAmount").hide();
                } else if (permissionType === 'yearly_contract') {
                    $("#DepositAmount").hide();
                } else if (permissionType === 'deposit') {
                    $("#DepositAmount").show();
                }
            });
            $("#DepositAmount").hide();

            // Twonship Selected
            $('select[name="township_id"]').on('change', function() {
                var townshipId = $(this).val();
                var url = '{{ url('ward_list_ajax') }}';
                $.ajax({
                    method: 'GET',
                    url: url,
                    data: {
                        townshipId: townshipId,
                    },
                    success: function(data) {
                        let wardList = '';
                        $.each(JSON.parse(data), function(key, value) {
                            console.log(value.ward_no);
                            wardList += '<option value="' + value.ward_no + '">'
                        });
                        $('#WardList').html(wardList);
                    },
                    error: function(data) {
                        // location.reload();
                    }
                });
            });
        });


        var SqftResult = document.getElementById("SqftResult");

        function setAreaCalc() {
            var AreaWidth = document.getElementById("AreaWidth").value;
            var AreaHeight = document.getElementById("AreaHeight").value;
            var SqftResultTotal = parseInt(AreaWidth) * parseInt(AreaHeight);
            SqftResult.value = SqftResultTotal;
        }


        function getAlreadyMarketingProperty() {
            var No = document.getElementById("No").value;
            var WardNo = document.getElementById("WardNo").value;
            var Road = document.getElementById("Road").value;

            var url = '{{ url('already_live_filter_search') }}';
            $.ajax({
                method: 'GET',
                url: url,
                data: {
                    WardNo: WardNo,
                    Road: Road,
                    No: No,
                },
                success: function(data) {
                    let CountAlreadyPropertyNumber = 0;
                    let marketing = '';
                    $.each(JSON.parse(data), function(key, value) {
                        CountAlreadyPropertyNumber++;
                        var offer_status = value.offer_status;
                        var offer_status = offer_status.split('_').join(' ');
                        var offer_status = offer_status.toUpperCase();

                        marketing += '<table class="table">';
                        marketing += '<tr>';
                        marketing += '<th class="data-property">Date & Time</th>';
                        marketing += '<td class="data-value">' + value.marketing_date + '</td>'
                        marketing += '</tr>';

                        marketing += '<tr>';
                        marketing += '<th class="data-property">Type</th>';
                        marketing += '<td class="data-value">' + offer_status + '</td>'
                        marketing += '</tr>';


                        marketing += '<tr>';
                        marketing += '<th class="data-property">Code</th>';
                        marketing += '<td class="data-value">' + value.code + '</td>'
                        marketing += '</tr>';

                        marketing += '<tr>';
                        marketing += '<th class="data-property">No/အိမ်အမှတ်</th>';
                        marketing += '<td class="data-value">' + value.no + '</td>'
                        marketing += '</tr>';

                        marketing += '<tr>';
                        marketing += '<th class="data-property">Road/လမ်း</th>';
                        marketing += '<td class="data-value">' + value.road + '</td>'
                        marketing += '</tr>';

                        marketing += '<tr>';
                        marketing += '<th class="data-property">Ward/ရပ်ကွက်</th>';
                        marketing += '<td class="data-value">' + value.ward + '</td>'
                        marketing += '</tr>';

                        marketing += '<tr>';
                        marketing += '<th class="data-property">Price</th>';
                        marketing += '<td class="data-value">' + value.price + '</td>'
                        marketing += '</tr>';

                        marketing += '<tr>';
                        marketing += '<th class="data-property">Wide</th>';
                        marketing += '<td class="data-value">' + value.area_width * value
                            .area_height +
                            ' Sqft</td>'
                        marketing += '</tr>';


                        marketing += '<tr>';
                        marketing += '<th class="data-property">Owner/Agent</th>';
                        marketing += '<td class="data-value">' + value.owner_agent + '</td>'
                        marketing += '</tr>';


                        marketing += '<tr>';
                        marketing += '<th class="data-property">Action</th>';
                        marketing +=
                            '<td class="data-value"><a href="#" class="btn btn-primary btn-sm">View Detail</a></td>'
                        marketing += '</tr>';

                        marketing += '</table>';

                    });
                    $('#AlreadyMarketingPropertyLists').html(marketing);
                    document.getElementById('CountAlreadyProperty').textContent =
                        CountAlreadyPropertyNumber;
                },
                error: function(data) {
                    // location.reload();
                    document.getElementById('CountAlreadyProperty').textContent = 0;
                    $('#AlreadyMarketingPropertyLists').html('');
                }
            });
        }
        
        
        $('#tokenfield').tokenfield({
          createTokensOnBlur:true,
          beautify:true,
        })
    </script>
@endsection
