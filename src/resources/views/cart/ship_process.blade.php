<div class="ship-process padding-top-30 padding-bottom-30">
    <div class="container">
        <ul class="row">

            <li class="col-sm-3 {{ ($step ?? 1) == 1 ? 'current' : '' }}">
                <div class="media-left">
                    <a href="{{ route('layout.cart') }}"> <i class="flaticon-shopping"></i></a>
                </div>
                <div class="media-body">
                    <span>Bước 1</span>
                    <h6>Giỏ hàng</h6>
                </div>
            </li>

            <li class="col-sm-3 {{ ($step ?? 1) == 2 ? 'current' : '' }}">
                <div class="media-left">
                    <i class="flaticon-business"></i>
                </div>
                <div class="media-body">
                    <span>Bước 2</span>
                    <h6>Thanh toán</h6>
                </div>
            </li>

            <li class="col-sm-3 {{ ($step ?? 1) == 3 ? 'current' : '' }}">
                <div class="media-left">
                    <i class="flaticon-delivery-truck"></i>
                </div>
                <div class="media-body">
                    <span>Bước 3</span>
                    <h6>Xác nhận</h6>
                </div>
            </li>

            <li class="col-sm-3 {{ ($step ?? 1) == 4 ? 'current' : '' }}">
                <div class="media-left">
                    <i class="fa fa-check"></i>
                </div>
                <div class="media-body">
                    <span>Bước 4</span>
                    <h6>Xác nhận</h6>
                </div>
            </li>

        </ul>
    </div>
</div>