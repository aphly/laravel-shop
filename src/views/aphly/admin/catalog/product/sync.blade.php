<div class="top-bar">
    <h5 class="nav-title">本地数据库改成远程，图片请自行上传到远程oss中</h5>
</div>
<div class="imain">
    <form method="post" action="/shop_admin/product/sync" class="save_form">
        @csrf
        <div class="form-group sync">
            <label >
                <input type="checkbox" name="type[]" class="form-control " value="product"> 商品图片
            </label>
            <label>
                <input type="checkbox" name="type[]" class="form-control " value="option"> 选项图片
            </label>
            <label>
                <input type="checkbox" name="type[]" class="form-control " value="review"> 评价图片
            </label>
            <label>
                <input type="checkbox" name="type[]" class="form-control " value="service"> 售后图片
            </label>
        </div>
        <button class="btn btn-primary" type="submit">保存</button>
    </form>
</div>
<style>
    .sync label{margin-right: 20px;}
</style>
<script>
    $(function () {

    })
</script>


