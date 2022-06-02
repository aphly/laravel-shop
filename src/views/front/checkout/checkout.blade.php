@include('laravel-shop::front.common.header')
<style>

</style>
<div class="container">
    <div class="cart row">
        <div class="col-8 ">
            <div>
                <ul>
                    @foreach($res['list'] as $val)
                    <li>{{$val['id']}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-4 d-flex">

        </div>
    </div>
</div>
<style>

</style>
<script>
$(function () {

})
</script>
@include('laravel-shop::front.common.footer')
