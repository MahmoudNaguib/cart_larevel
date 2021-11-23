<?php

use Intervention\Image\Facades\Image;

function tenant() {
    /*$tenant = str_replace(env('PREFIX') . '_', '', config('database.connections.mysql.database'));
    return $tenant;*/
    return 'demo';
}

/*function uploads() {
    return 'uploads/' . config('database.connections.mysql.database');
}*/


function generateToken($email){
    return md5(RandomString(10)).md5(time()).md5($email).md5(RandomString(10));
}

function setlang() {
    $locale = (request()->segment(2));
    $supportedLocales = ['en', 'ar'];
    if (!in_array($locale, $supportedLocales)) {
        $locale = config('app.fallback_locale');
    }
    app()->setLocale($locale);
    return $locale;
}

function uploads() {
    return 'uploads';
}

function getConfigsPairs() {
    $arr = [];
    if (\Schema::hasTable('configs')) {
        $configs = \App\Models\Config::get();
        if ($configs) {
            foreach ($configs as $c) {
                $key = $c->field;
                if ($c->lang) {
                    $arr[$c->lang][$key] = $c->value;
                } else {
                    foreach (langs() as $lang) {
                        $arr[$lang][$key] = $c->value;
                    }
                }
            }
        }
    }
    return $arr;
}

function token() {
    $token = request('token') ?: (request()->header('Authorization')?:request()->header('token'));
    if ($token) {
        $token = str_replace('Bearer ', '', $token);
    }
    return $token;
}

function toId($txt) {
    $txt = str_replace(' ', '_', $txt);
    $txt = str_replace('/', '_', $txt);
    return $txt;
}


function currencies() {
    $key = 'currencies_' . appVersion();
    if (\Cache::has($key)) {
        return \Cache::get($key);
    } else {
        if (\Schema::hasTable('currencies')) {
            $currencies = \App\Models\Currency::get()->keyBy('id');
            \Cache::put($key, $currencies, env('CACHE_TIME', 24 * 60 * 60));
            return $currencies;
        }
    }
}

function userLanguage() {
    $otherLang = (request()->header('language')) ?: 'en';
    $lang = (@auth()->user()) ? auth()->user()->language : $otherLang;
    return $lang;
}

function userCurrency() {
    $currency_id = (@auth()->user()) ? auth()->user()->currency_id : env('DEFAULT_CURRENCY', 1);
    $currency = @currencies()[$currency_id];
    return $currency;
}

function defaultCurrency() {
    $currency = @currencies()[env('DEFAULT_CURRENCY', 1)];
    return $currency;
}

function changeRate($amount, $to_currency_id, $from_currency_id) {
    if ($to_currency_id == $from_currency_id)
        return $amount;
    $rates = currencies();
    $amount = round(($amount * @$rates[$from_currency_id]->rate) / @$rates[defaultCurrency()->id]->rate, 2);
    $amount = round(($amount * @$rates[defaultCurrency()->id]->rate) / @$rates[$to_currency_id]->rate, 2);
    return $amount;
    // return round(($amount * $rates[$from_currency_id]->rate) / $rates[$to_currency_id]->rate, 3);
}

function resizeImage($image, $sizes = ['large' => 'resize,400x240', 'small' => 'crop,200x120']) {
    $fileName = pathinfo($image)['basename'];
    $random = strtolower(str_random(10)) . time();
    foreach ($sizes as $key => $size) {
        $image = \Image::make($image);
        $newFileName = $random . '.' . $image->extension;
        $uploadsPath = public_path() . '/uploads/' . $key . '/' . $newFileName;
        $size = explode(',', $size);
        $type = $size[0];
        $dimensions = (isset($size[1])) ? $size[1] : '200x200';
        $dimensions = explode('x', $dimensions);
        if ($type == 'crop') {
            $image->fit($dimensions[0], $dimensions[1]);
        } else {
            $image->resize($dimensions[0], $dimensions[1], function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        $image->save($uploadsPath, 90);
    }
    return $newFileName;
}

function generateImage($txt, $sizes = ['large' => 'resize,400x240', 'small' => 'crop,200x120'], $name = NULL) {
    if (app()->environment() != 'testing') {
        if (!$name)
            $name = RandomString(10) . time() . '.png';
        foreach ($sizes as $key => $size) {
            $size = explode(',', $size);
            $size = explode('x', $size[1]);
            if ($key == 'small') {
                $text = explode(' ', $txt);
                $text = strtoupper($text[0][0]) . strtoupper((@$text[1][0]) ?: @$text[0][1]);
            } else {
                $text = substr($txt, 0, 7);
            }
            $img = imagecreate($size[0], $size[1]);
            $backGroundColor = imagecolorallocate($img, 255, 255, 255);
            $fontColor = imagecolorallocate($img, 0, 0, 0);
            // DRAW BACKGROUND AND TEXT
            $font = public_path() . '/fonts/Arial.ttf';
            imagefilledrectangle($img, 0, 0, 0, 0, $backGroundColor);
            if ($key == 'small') {
                $fontSize = ceil($size[0] / 2);
                $y = $size[1] * 3 / 4;
            } else {
                $fontSize = ceil($size[0] / 6);
                $y = $size[1] * 1 / 2;
            }
            @imagettftext($img, $fontSize, 0, 0, $y, $fontColor, $font, $text);
            $filename = public_path() . '/' . uploads() . '/' . $key . '/' . $name;
            @imagepng($img, $filename);
        }
        return $name;
    }
}

function sendPushNotifications($tokens, $title, $body, $data) {
    $data = array_merge(['title' => $title, 'body' => $body], $data);
    $FCM_SERVER_KEY = env('FCM_SERVER_KEY');
    $url = 'https://fcm.googleapis.com/fcm/send';
    $tokens = (!is_array($tokens)) ? [$tokens] : $tokens;
    $fields = [
        'notification' => [
            "content_available" => true,
            "sound" => "default",
            'title' => $title,
            "body" => $body,
        ],
        'data' => $data,
        "registration_ids" => $tokens,
    ];
    $headers = [
        'Authorization: key=' . $FCM_SERVER_KEY, 'Content-Type: application/json',
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    curl_close($ch);
}

function appVersion() {
    $json = json_decode(@file_get_contents(public_path() . '/version.json'));
    return @$json->version;
}

function myCrypt($data, $action = 'e') {
    if (is_array($data))
        $data = json_encode($data);
    $secret_key = 'a4d';
    $secret_iv = 'a4d';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ($action == 'e') {
        $output = base64_encode(openssl_encrypt($data, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'd') {
        $output = openssl_decrypt(base64_decode($data), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}

function urlLang($url, $fromlang, $toLang) {
    $currentUrl = str_replace('/' . $fromlang, '/' . $toLang, strtolower($url));
    return $currentUrl;
}

function conf($field) {
    $row = getConfigs()[$field];
    if (is_array($row))
        return $row[lang()];
    return $row;
}

function RandomString($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $randstring = '';
    for ($i = 0; $i < $n; $i++) {
        $randstring .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randstring;
}

function authorize($action) {
    if (!can($action)) {
        $message = trans('app.Unauthorized action');
        return abort(403, $message);
    }
}

function can($action) {
    $user = auth()->user();
    if (!$user) {
        $token = token();
        $user = \App\Models\User::where('token', $token)->first();
    }
    if (!$user)
        return false;
    if ($user->role_id == 1){
        return true;
    }
    if (!$user->role_id)
        return false;
    if (!in_array($action, $user->role->permissions)) {
        return false;
    }
    return true;
}

function permissions() {
    $all = [];
    foreach (config('modules') as $key => $value) {
        foreach ($value as $permission)
            $all[] = $permission;
    }
    return $all;
}

function lang() {
    return \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
}

function langs() {
    $languages = (array_keys(config('laravellocalization.supportedLocales'))) ?: [];
    return $languages;
}

function languages() {
    $languages = config('laravellocalization.supportedLocales');
    $langs = [];
    foreach ($languages as $key => $value) {
        $langs[$key] = $value['name'];
        if ($key == 'ar') {
            $langs[$key] = 'عربي';
        }
    }
    return $langs;
}

function transformValidation($errors) {
    $temp = [];
    if ($errors) {
        foreach ($errors as $key => $value) {
            $temp[$key] = @$value[0];
        }
    }
    return $temp;
}

function getConfigs() {
    if (\Cache::has('configs')) {
        return \Cache::get('configs');
    } else {
        if (\Schema::hasTable('configs')) {
            $configs = \App\Models\Config::get();
            $arr = [];
            if ($configs) {
                foreach ($configs as $c) {
                    $key = $c->field;
                    if ($c->lang) {
                        $arr[$key][$c->lang] = $c->value;
                    } else {
                        $arr[$key] = $c->value;
                    }
                }
            }
            Cache::put('configs', $arr, env('CACHE_TIME', 24 * 60 * 60));
        }
    }
}

function appName() {
    $configs = getConfigs();
    $appName = (@$configs['application_name'][lang()]) ?: env('APP_NAME');
    return $appName;
}

function image($img, $size = '', $attributes = Null) {
    $path = uploads() . '/' . $size;
    $src = app()->make("url")->to('/') . '/' . $path . '/' . $img;
    if (!file_exists(public_path() . '/' . $path . '/' . $img) || !$img) {
        $src = '/img/placeholder.png';
    }
    $others = '';
    if ($attributes) {
        foreach ($attributes as $key => $value) {
            $others .= $key . '="' . $value . '"';
        }
    }
    return '<img src="' . $src . '" ' . $others . '>';
}

function video($video, $attributes = Null) {
    $src = uploads() . '/' . $video;
    return '<div class="videoPlayer">
                    <div class="embed-responsive embed-responsive-16by9">
                        <video width="320" height="240" controls>
                            <source src="' . $src . '" type="video/mp4">
                        </video>
                    </div>
                </div>';
}

function attach($file) {
    $path = uploads() . '/' . $file;
    if (!$file || !file_exists($path)) {
        return '';
    }
    return '<i class="fa fa-paperclip"></i> <a href="download/file/' . $file . '" >' . $file . '</a>';
}

function slug($str, $options = array()) {
    // Make sure string is in UTF-8 and strip invalid UTF-8 characters
    $str = mb_convert_encoding((string)$str, 'UTF-8');
    $defaults = array(
        'delimiter' => '-',
        'limit' => null,
        'lowercase' => true,
        'replacements' => array(),
        'transliterate' => false,
    );
    // Merge options
    $options = array_merge($defaults, $options);
    $char_map = array(
        // Latin
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
        'Æ' => 'AE', 'Ç' => 'C',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I',
        'Î' => 'I', 'Ï' => 'I',
        'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
        'Ö' => 'O', 'Ő' => 'O',
        'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U',
        'Ý' => 'Y', 'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
        'æ' => 'ae', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i',
        'î' => 'i', 'ï' => 'i',
        'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
        'ö' => 'o', 'ő' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u',
        'ý' => 'y', 'þ' => 'th',
        'ÿ' => 'y',
        // Latin symbols
        '©' => '(c)',
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z',
        'Η' => 'H', 'Θ' => '8',
        'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3',
        'Ο' => 'O', 'Π' => 'P',
        'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X',
        'Ψ' => 'PS', 'Ω' => 'W',
        'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H',
        'Ώ' => 'W', 'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z',
        'η' => 'h', 'θ' => '8',
        'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3',
        'ο' => 'o', 'π' => 'p',
        'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x',
        'ψ' => 'ps', 'ω' => 'w',
        'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h',
        'ώ' => 'w', 'ς' => 's',
        'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
        // Turkish
        'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
        'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
        // Russian
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
        'Ё' => 'Yo', 'Ж' => 'Zh',
        'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M',
        'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
        'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
        'Э' => 'E', 'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e',
        'ё' => 'yo', 'ж' => 'zh',
        'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm',
        'н' => 'n', 'о' => 'o',
        'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f',
        'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '',
        'э' => 'e', 'ю' => 'yu',
        'я' => 'ya',
        // Ukrainian
        'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
        'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
        // Czech
        'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S',
        'Ť' => 'T', 'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's',
        'ť' => 't', 'ů' => 'u',
        'ž' => 'z',
        // Polish
        'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o',
        'Ś' => 'S', 'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o',
        'ś' => 's', 'ź' => 'z',
        'ż' => 'z',
        // Latvian
        'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k',
        'Ļ' => 'L', 'Ņ' => 'N',
        'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
        'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k',
        'ļ' => 'l', 'ņ' => 'n',
        'š' => 's', 'ū' => 'u', 'ž' => 'z'
    );
    // Make custom replacements
    $str = preg_replace(
        array_keys($options['replacements']), $options['replacements'], $str
    );
    // Transliterate characters to ASCII
    if ($options['transliterate']) {
        $str = str_replace(array_keys($char_map), $char_map, $str);
    }
    // Replace non-alphanumeric characters with our delimiter
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
    // Remove duplicate delimiters
    $str = preg_replace(
        '/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str
    );
    // Truncate slug to max. characters
    $str = mb_substr(
        $str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8'
    );
    // Remove delimiter from ends
    $str = trim($str, $options['delimiter']);

    return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
}
