<?php

if (!function_exists('markdown')) {
    /**
     * Compile Markdown to HTML.
     *
     * @param string|null $text
     * @return string
     */
    function markdown($text = null)
    {
        return app(ParsedownExtra::class)->text($text);
    }
}

if (!function_exists('gravatar_profile_url')) {
    /**
     * Generate gravatar profile page url.
     *
     * @param  string $email
     * @return string
     */
    function gravatar_profile_url($email)
    {
        return sprintf("//www.gravatar.com/%s", md5($email));
    }
}

if (!function_exists('gravatar_url')) {
    /**
     * Generate gravatar image url
     *
     * @param  string $email
     * @param  integer $size
     * @return string
     */
    function gravatar_url($email, $size = 48)
    {
        return sprintf("//www.gravatar.com/avatar/%s?s=%s", md5($email), $size);
    }
}

if (!function_exists('attachments_path')) {
    /**
     * Generate attachments path.
     *
     * @param string $path
     * @return string
     */
    function attachments_path($path = null)
    {
        return public_path('files' . ($path ? DIRECTORY_SEPARATOR . $path : $path));
    }
}

if (!function_exists('format_filesize')) {
    /**
     * Calculate human-readable file size string.
     *
     * @param $bytes
     * @return string
     */
    function format_filesize($bytes)
    {
        if (!is_numeric($bytes)) return 'NaN';

        $decr = 1024;
        $step = 0;
        $suffix = ['bytes', 'KB', 'MB'];

        while (($bytes / $decr) > 0.9) {
            $bytes = $bytes / $decr;
            $step++;
        }

        return round($bytes, 2) . $suffix[$step];
    }
}

if (!function_exists('link_for_sort')) {
    /**
     * Build HTML anchor tag for sorting
     *
     * @param string $column
     * @param string $text
     * @param array $params
     * @return string
     */
    function link_for_sort($column, $text, $params = [])
    {
        $direction = request()->input('order');
        $reverse = ($direction == 'asc') ? 'desc' : 'asc';

        if (request()->input('sort') == $column) {
            // Update passed $text var, only if it is active sort
            $text = sprintf(
                "%s %s",
                $direction == 'asc'
                    ? '<i class="fa fa-sort-alpha-asc"></i>'
                    : '<i class="fa fa-sort-alpha-desc"></i>',
                $text
            );
        }

        $queryString = http_build_query(array_merge(
            request()->except(['sort', 'order']),
            ['sort' => $column, 'order' => $reverse],
            $params
        ));

        return sprintf(
            '<a href="%s?%s">%s</a>',
            urldecode(request()->url()),
            $queryString,
            $text
        );
    }
}

if (!function_exists('cache_key')) {
    /**
     * Generate key for caching.
     *
     * Note that, even though the request endpoints are the same
     *     the response body may be different because of the query string.
     *
     * @param $base
     * @return string
     */
    function cache_key($base)
    {
        $key = ($query = request()->getQueryString())
            ? $base . '.' . urlencode($query)
            : $base;

        return md5($key);
    }
}

if (!function_exists('taggable')) {
    /**
     * Determine if the current cache driver has cacheTags() method
     *
     * @return bool
     */
    function taggable()
    {
        return in_array(config('cache.default'), ['memcached', 'redis'], true);
    }
}

if (!function_exists('current_url')) {
    /**
     * Build current url string, without return param.
     *
     * @return string
     */
    function current_url()
    {
        if (!request()->has('return')) {
            return request()->fullUrl();
        }

        return sprintf(
            '%s?%s',
            request()->url(),
            http_build_query(request()->except('return'))
        );
    }
}

if (!function_exists('array_transpose')) {
    /**
     * Transpose the given array.
     *
     * @param array $data
     * @return array
     */
    function array_transpose(array $data)
    {
        $res = [];

        foreach ($data as $row => $columns) {
            foreach ($columns as $row2 => $column2) {
                $res[$row2][$row] = $column2;
            }
        }

        return $res;
    }
}

// TODO 만들다 맘
if (!function_exists('cleanNoLinkAttachment')) {
    function cleanNoLinkAttachment()
    {
        $results = array();
        $handler = opendir(attachments_path());

        while ($file = readdir($handler)) {
            if ($file != '.' && $file != '..' && is_dir($file) != '1') {
                $results[] = $file;
            }
        }

        closedir($handler);
        return $results;
    }
}

if (!function_exists('naverEpExport')) {
    function naverEpExport()
    {
        /*
** Example usage:
*/

        $array = array(
            [
                "id",
                "title",
                "price_pc",
                "price_mobile",
                "normal_price",
                "link",
                "mobile_link",
                "image_link",
                "add_image_link",
                "category_name1",
                "category_name2",
                "category_name3",
                "category_name4",
                "naver_category",
                "naver_product_id",
                "condition",
                "import_flag",
                "parallel_import",
                "order_made",
                "product_flag",
                "adult",
                "goods_type",
                "barcode",
                "manufacture_define_number",
                "model_number",
                "brand",
                "maker",
                "origin",
                "card_event",
                "event_words",
                "coupon",
                "partner_coupon_download",
                "interest_free_event",
                "point",
                "installation_costs",
                "search_tag",
                "group_id",
                "vendor_id",
                "coordi_id",
                "minimum_purchase_quantity",
                "review_count",
                "shipping",
                "delivery_grade",
                "delivery_detail",
                "attribute",
                "option_detail",
                "seller_id",
                "age_group",
                "gender",
                "class",
                "update_time",
            ],
        );

        $products = App\Product::where('ad_status', '판매')->get();
        $categories = config('project.categories');

        foreach ($products as $product) {
            $product_arr = [
                $product->id,
                $product->ad_title,
                $product->price,
                "",
                "",
                route('products.show', $product->id),
                "",
                $product->attachments->count() > 0 ? $product->attachments->first()->url : "",
                "",
                $categories[$product->category]['ko'],
                "",
                "",
                "",
                "",
                "",
                $product->is_old ? "중고" : "신상품",
                "",
                "",
                "",
                "",
                "N",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "자전거|로드|MTB|하이브리드|로드 자전거|한강|라이딩|ROAD|BIKE|바이크",
                "",
                "",
                "",
                "",
                $product->reviews->count(),
                $product->price >= 50000 ? 0 : 2500,
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                $product->created_at == $product->updated_at ? "I" : ($product->updated_at->isToday() ? "U" : "I"),
                $product->updated_at->toDateTimeString()
            ];

            array_push($array, $product_arr);
        }

// save the array to the data.txt file:
        write_tabbed_file('public/files/data.txt', $array, false);

        /* the data.txt content looks like this:
        line1	data-1-1	data-1-2	data-1-3
        line2	data-2-1	data-2-2	data-2-3
        line3	data-3-1	data-3-2	data-3-3
        line4	foobar
        line5	hello world
        */

// load the saved array:
        $reloaded_array = load_tabbed_file('public/files/data.txt',false);

        print_r($reloaded_array);
// returns the array from above
    }
}

if (!function_exists('write_tabbed_file')) {
    function write_tabbed_file($filepath, $array, $save_keys=false){
        $content = '';

        reset($array);
        while(list($key, $val) = each($array)){

            // replace tabs in keys and values to [space]
            $key = str_replace("\t", " ", $key);
            $val = str_replace("\t", " ", $val);

            if ($save_keys){ $content .=  $key."\t"; }

            // create line:
            $content .= (is_array($val)) ? implode("\t", $val) : $val;
            $content .= "\n";
        }

        if (file_exists($filepath) && !is_writeable($filepath)){
            return false;
        }
        if ($fp = fopen($filepath, 'w+')){
            fwrite($fp, $content);
            fclose($fp);
        }
        else { return false; }
        return true;
    }
}

if (!function_exists('load_tabbed_file')) {
    function load_tabbed_file($filepath, $load_keys=false){
        $array = array();

        if (!file_exists($filepath)){ return $array; }
        $content = file($filepath);

        for ($x=0; $x < count($content); $x++){
            if (trim($content[$x]) != ''){
                $line = explode("\t", trim($content[$x]));
                if ($load_keys){
                    $key = array_shift($line);
                    $array[$key] = $line;
                }
                else { $array[] = $line; }
            }
        }
        return $array;
    }
}

// TODO 만들다 맘
if (!function_exists('checkMobile')) {
    function checkMobile()
    {
        $mAgent = array("iPhone","iPod","Android","Blackberry",
            "Opera Mini", "Windows ce", "Nokia", "sony" );
        $chkMobile = false;
        for($i=0; $i<sizeof($mAgent); $i++){
            if(stripos( $_SERVER['HTTP_USER_AGENT'], $mAgent[$i] )){
                $chkMobile = true;
                break;
            }
        }
        return $chkMobile;
    }
}
