@include(config('shop.pre').'::front.common.header')

<section class="information">
    <div class=" container">
        <div class="d-flex all_breadcrumb">
            <a href="{{url('/')}}"><span>Home</span></a>
            <i class="common-iconfont icon-xiangb"></i>
            <span>Cookie Policy</span>
        </div>
        <div class="d-flex ">
            @include(config('shop.pre').'::front.common.information.left')
            <div class="information_right">
                <h2>Cookie Policy</h2>
                <div class="content">
                    <h3>1. What Are Cookies?</h3>
                    <p>Cookies are small text files stored on your device (computer, tablet or mobile phone) when you visit a website. They help the website recognize your device and remember certain information about your visit.</p>

                    <h3>2. Types of Cookies We Use</h3>
                    <p>We use two categories of cookies on this website:</p>
                    <ul>
                        <li><strong>Strictly Necessary Cookies</strong>: Required for basic website functions, such as keeping your consent choice, shopping cart session and page navigation. These do not require your consent and cannot be disabled.</li>
                        <li><strong>Analytics & Advertising Cookies</strong>: Non‑essential cookies including Google Analytics, Google Ads and other third‑party tracking tools. These collect data to analyze traffic, show relevant advertisements and measure campaign performance. <strong>These cookies will only be loaded if you click “Accept” on our cookie banner.</strong></li>
                    </ul>

                    <h3>3. Third-Party Cookies</h3>
                    <p>When you accept non‑essential cookies, third‑party providers including Google may set their own cookies. These third parties have their own privacy and cookie policies, and we do not control how they process your data.</p>

                    <h3>4. Your Cookie Choices</h3>
                    <p>When you first visit our site, you may choose to <strong>Accept</strong> or <strong>Reject</strong> non‑essential cookies.</p>
                    <ul>
                        <li>If you <strong>Accept</strong>: Analytics and advertising cookies will be enabled for 180 days.</li>
                        <li>If you <strong>Reject</strong>: No tracking or ad cookies will be placed on your device.</li>
                    </ul>
                    <p>You can clear cookies through your browser settings at any time to reset your preference. You may also withdraw your consent later by clearing browser cookies and revisiting the site.</p>

                    <h3>5. How to Manage Cookies in Your Browser</h3>
                    <p>Most web browsers allow you to view, delete, block or restrict cookies. Please check your browser’s help section for instructions. Blocking necessary cookies may affect website functions.</p>

                    <h3>6. Data Protection</h3>
                    <p>This cookie notice is designed to comply with the GDPR and the EU ePrivacy Directive. All personal data collected via cookies is handled in accordance with our <a href="/privacy-policy">Privacy Policy</a>.</p>

                </div>

            </div>
        </div>
    </div>
</section>

<style>
    .information h2{margin: 20px 0 10px 0;font-size: 24px;text-align: center}
    .information h3{margin: 10px 0 5px 0;}
    .information{margin-top: 20px}
    .contact_us{margin-top: 20px;}
    .information img{max-width: 100%;}
    img[data-href]{cursor: pointer}
</style>

<script>

</script>
@include(config('shop.pre').'::front.common.footer')
