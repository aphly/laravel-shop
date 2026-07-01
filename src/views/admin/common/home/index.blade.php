<div class="top-bar">
   <h5 class="nav-title">首页</h5>
</div>
<style>
    .adminHome12 {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    .adminHome12 .adminHome121 {
        width: calc(25% - 10px);
        padding: 15px;
        background: #f5f5f5;
        border-radius: 8px;
        margin-bottom: 10px;
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
    <div class="adminHome12">
        <div  class="adminHome121">
            <div  class="adminHome1211">订单总数</div>
            <div  class="adminHome1212">{{$res['orderCount']}}</div>
            <div  class="adminHome1213">
                <div >24小时内</div>
                <div >{{$res['order24Count']}}</div>
            </div>
        </div>
        <div  class="adminHome121">
            <div  class="adminHome1211">未支付</div>
            <div  class="adminHome1212">{{$res['orderCount1']}}</div>
            <div  class="adminHome1213">
                <div >24小时内</div>
                <div >{{$res['order24Count1']}}</div>
            </div>
        </div>
        <div  class="adminHome121">
            <div  class="adminHome1211">已支付</div>
            <div  class="adminHome1212">{{$res['orderCount2']}}</div>
            <div  class="adminHome1213">
                <div >24小时内</div>
                <div >{{$res['order24Count2']}}</div>
            </div>
        </div>
        <div  class="adminHome121">
            <div  class="adminHome1211">已发货</div>
            <div  class="adminHome1212">{{$res['orderCount3']}}</div>
            <div  class="adminHome1213">
                <div >24小时内</div>
                <div >{{$res['order24Count3']}}</div>
            </div>
        </div>
    </div>

    <div class="adminHome12">
        <div  class="adminHome121">
            <div  class="adminHome1211">售后处理中</div>
            <div  class="adminHome1212">{{$res['afterSalesCount']}}</div>
            <div  class="adminHome1213">
                <div >24小时内</div>
                <div >{{$res['afterSales24Count']}}</div>
            </div>
        </div>
        <div  class="adminHome121">
            <div  class="adminHome1211">售后已完成</div>
            <div  class="adminHome1212">{{$res['afterSalesCount1']}}</div>
            <div  class="adminHome1213">
                <div >24小时内</div>
                <div >{{$res['afterSales24Count1']}}</div>
            </div>
        </div>

    </div>

</div>

