<div class="banner-form-area">
    <div class="container">
        <div class="banner-form">
            <form action="{{ route('checkAvailability') }}" method="GET">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label>CHECK IN TIME</label>
                            <div class="input-group">
                                <input autocomplete="off" id="check_in_date" type="text" name="check_in_date"
                                    class="form-control dt_picker" placeholder="yyy-mm-dd">
                                <span class="input-group-addon"></span>
                            </div>
                            <i class='bx bxs-chevron-down'></i>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label>CHECK OUT TIME</label>
                            <div class="input-group">
                                <input autocomplete="off" class="form-control dt_picker" type="text"
                                    name="check_out_date" placeholder="yyy-mm-dd">
                                <span class="input-group-addon"></span>
                            </div>
                            <i class='bx bxs-chevron-down'></i>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>GUESTS</label>
                            <select class="form-control" name="number_of_persons">
                                <option value="1">01</option>
                                <option value="2">02</option>
                                <option value="3">03</option>
                                <option value="4">04</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <div class="form-group">
                            <label>Rooms</label>
                            <select class="form-control" name="number_of_rooms">
                                <option value="1">01</option>
                                <option value="2">02</option>
                                <option value="3">03</option>
                                <option value="4">04</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <button type="submit" class="default-btn btn-bg-one border-radius-5">
                            Book
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
