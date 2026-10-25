<!-- Cookie Consent 极简弹窗 - Bootstrap4.6.1 + jQuery -->
<style>
    .cookie-bar{position:fixed;left:0;right:0;bottom:0;background:#fff;border-top:1px solid #eee;padding:1rem;z-index:9999;display:none;}
    .cookie-wrap{margin:0 auto;display:flex;align-items:center;gap:1rem;flex-wrap:wrap;}
    .cookie-text{flex:1;min-width:260px;font-size:14px;color:#444;}
    .cookie-buttons{display:flex;gap:0.75rem;flex-wrap:wrap;}
    @media (max-width: 1200px) {
        .cookie-wrap{display: block;}
        .cookie-text{margin-bottom: 10px;}
        .cookie-buttons{justify-content: space-between;}
    }
</style>

<div class="cookie-bar" id="cookieBar">
    <div class="cookie-wrap container">
        <div class="cookie-text">
            We use cookies to improve your experience. By accepting, you agree to our <a href="/cookie-policy" target="_blank">Cookie Policy</a>.
        </div>
        <div class="cookie-buttons">
            <button class="btn btn-sm btn-dark" id="cookieAccept">Accept</button>
            <button class="btn btn-sm btn-outline-secondary" id="cookieReject">Reject</button>
        </div>
    </div>
</div>
<script>
    let cookie_policy_name = 'cookie_policy_name'
    function setCookie(name,value,days){
        let d = new Date();
        d.setTime(d.getTime() + days*24*60*60*1000);
        document.cookie = name + "=" + value + ";expires="+d.toUTCString()+";path=/";
    }
    function getCookie(name){
        let ca = document.cookie.split(';');
        for(let i=0;i<ca.length;i++){
            let c = ca[i].trim();
            if(c.indexOf(name+"=")===0) return c.substring(name.length+1);
        }
        return "";
    }
    function delCookie(name) {
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    }
    function loadScript(src,cb){
        const s=document.createElement('script');
        s.src=src;
        s.async=true;
        if(cb)s.onload=cb;
        document.head.appendChild(s);
    }

    $(function(){
        if(!getCookie(cookie_policy_name)){
            $('#cookieBar').show();
        }
        $('#cookieAccept').on('click',function(){
            setCookie(cookie_policy_name,'accept',180);
            $('#cookieBar').hide();

        })
        $('#cookieReject').on('click',function(){
            setCookie(cookie_policy_name,'reject',180);
            $('#cookieBar').hide();
        })
        // $('#cookieReset').on('click',function(){
        //     $('#cookieBar').show();
        //     delCookie(cookie_policy_name)
        // })
    })
</script>
