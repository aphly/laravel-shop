**laravel shop**<br>

环境<br>
php8.1+<br>
laravel10.0+<br>
mysql5.7+<br>

安装<br>
`composer require aphly/laravel-shop` <br>
`php artisan vendor:publish --provider="Aphly\LaravelShop\ShopServiceProvider"` <br>

初始化<br>
`php artisan laravel-shop:init` <br>


env中添加<br>
`
GOOGLE_CLIENT_ID=你的客户端ID
GOOGLE_CLIENT_SECRET=你的客户端密钥
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

FACEBOOK_CLIENT_ID=你的AppID
FACEBOOK_CLIENT_SECRET=你的AppSecret
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback
`

配置 config/services.php<br>
`
'google' => [
'client_id' => env('GOOGLE_CLIENT_ID'),
'client_secret' => env('GOOGLE_CLIENT_SECRET'),
'redirect' => env('GOOGLE_REDIRECT_URI'),
],

'facebook' => [
    'client_id'     => env('FACEBOOK_CLIENT_ID'),
    'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
    'redirect'      => env('FACEBOOK_REDIRECT_URI'),
],
`
