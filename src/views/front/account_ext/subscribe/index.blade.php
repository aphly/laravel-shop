@include(config('base.view_namespace_front_blade').'::common.header')
<section class="container">
    <div class="account_info">
        @include(config('base.view_namespace_front_blade').'::account.left_menu')
        <div class="account-main-section" style="background: transparent;">
            <div class="order">
                <div class="top-desc d-flex justify-content-between">
                    <h2>Subscribe</h2>
                </div>

                <form action="/account_ext/subscribe" method="post" class="form_request" data-fn="save_res">
                    <div style="margin-top: 20px;">
                    @if(!empty($res['info']) && $res['info']->status==1)
                        <input type="checkbox" id="checkbox_status" name="status" checked value="1">
                        <label for="checkbox_status">
                            General Subscription
                        </label>
                    @else
                        <input type="checkbox" id="checkbox_status" name="status" value="1">
                        <label for="checkbox_status">
                            General Subscription
                        </label>
                    @endif
                    </div>
                    <div class="form-group d-flex" style="margin-top: 30px;">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</section>

<script>
    function save_res(res,_this) {
        alert_res(res)
    }


$(function () {

})
</script>

@include(config('base.view_namespace_front_blade').'::common.footer')
