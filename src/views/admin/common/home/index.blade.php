<div class="top-bar">
   <h5 class="nav-title">首页</h5>
</div>
<style>
    .home_title{font-size: 20px;font-weight: 600;margin-bottom: 5px;}
    .adminHome12 {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .adminHome12 .adminHome121 {
        width: calc(25% - 10px);
        padding: 15px;
        background: #f5f5f5;
        border-radius: 8px;
        margin:0 10px 10px 0;
    }
    .adminHome12 .adminHome121 .adminHome1211 {
        border-bottom: 1px solid #f1f1f1;
        height: 42px;
        line-height: 42px;
    }
    .adminHome12 .adminHome121 .adminHome1212 {
        height: 60px;
        line-height: 60px;
        font-size: 32px;
    }
    .adminHome12 .adminHome121 .adminHome1213 {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #999;
    }
</style>
<div>
    <div class="home_title">
        购物车
    </div>
    <div class="adminHome12">
        <div  class="adminHome121">
            <div  class="adminHome1211">48小时游客次数</div>
            <div  class="adminHome1212">{{$res['guestCart48']->count_product_id}}</div>
            <div  class="adminHome1213">
                <div >商品数量</div>
                <div >{{$res['guestCart48']->sum_quantity?:0}}</div>
            </div>
        </div>
        <div  class="adminHome121">
            <div  class="adminHome1211">会员次数</div>
            <div  class="adminHome1212">{{$res['userCart']->count_product_id}}</div>
            <div  class="adminHome1213">
                <div >商品数量</div>
                <div >{{$res['userCart']->sum_quantity}}</div>
            </div>
        </div>

    </div>

    <div class="home_title">
        订单
    </div>
    <div class="adminHome12">
        <div  class="adminHome121">
            <div  class="adminHome1211">24小时内订单总数</div>
            <div  class="adminHome1212">{{$res['order24Count']}}</div>
            <div  class="adminHome1213">
                <div >订单总数</div>
                <div >{{$res['orderCount']}}</div>
            </div>
        </div>
        <div  class="adminHome121">
            <div  class="adminHome1211">24小时内未支付</div>
            <div  class="adminHome1212">{{$res['order24Count1']}}</div>
            <div  class="adminHome1213">
                <div >未支付总数</div>
                <div >{{$res['orderCount1']}}</div>
            </div>
        </div>
        <div  class="adminHome121">
            <div  class="adminHome1211">24小时内已支付</div>
            <div  class="adminHome1212">{{$res['order24Count2']}}</div>
            <div  class="adminHome1213">
                <div >已支付总数</div>
                <div >{{$res['orderCount2']}}</div>
            </div>
        </div>
        <div  class="adminHome121">
            <div  class="adminHome1211">24小时内已发货</div>
            <div  class="adminHome1212">{{$res['order24Count3']}}</div>
            <div  class="adminHome1213">
                <div >已发货总数</div>
                <div >{{$res['orderCount3']}}</div>
            </div>
        </div>
    </div>

    <div class="home_title">
        售后
    </div>
    <div class="adminHome12">
        <div  class="adminHome121">
            <div  class="adminHome1211">24小时内处理中</div>
            <div  class="adminHome1212">{{$res['afterSales24Count']}}</div>
            <div  class="adminHome1213">
                <div >处理中总数</div>
                <div >{{$res['afterSalesCount']}}</div>
            </div>
        </div>
        <div  class="adminHome121">
            <div  class="adminHome1211">24小时内已完成</div>
            <div  class="adminHome1212">{{$res['afterSales24Count1']}}</div>
            <div  class="adminHome1213">
                <div >已完成总数</div>
                <div >{{$res['afterSalesCount1']}}</div>
            </div>
        </div>

    </div>

</div>

