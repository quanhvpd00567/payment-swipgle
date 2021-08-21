<?php

// USER AVATAR FUNCTION
function avatar($avatar)
{
    return asset('cdn/avatars/' . $avatar);
}

// WEBSITE LOGO AND FAVICON
function logofav($logofav)
{
    return asset('images/main/' . $logofav);
}

// USER PERMISSION FUNCTION
function permission($permission)
{
    if ($permission == 1) {
        return __('frontend.admin');
    } elseif ($permission == 2) {
        return __('frontend.user');
    } else {
        return '';
    }
}

// PRICE FORMAT
function price($price)
{
    $currency = env('WEBSITE_CURRENCY');
    return number_format($price, 2) . ' ' . $currency;
}

// PRICE FORMAT FOR TRANSACTIONS
function transaction_price($price)
{
    return number_format($price, 2);
}

// FORMAT BYTES
function formatBytes($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}

// TRANSACTION STATUS
function transactionStatus($status)
{
    if ($status == 1) {
        return '<span class="badge bg-secondary"></span> ' . __('frontend.unpaid');
    } elseif ($status == 2) {
        return '<span class="badge bg-success"></span> ' . __('frontend.paid');
    } elseif ($status == 3) {
        return '<span class="badge bg-danger"></span> ' . __('frontend.canceled');
    } else {
        return "";
    }
}

// FORMAT NUMBERS
function number_format_short($number)
{
    $abbrevs = [12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => ''];

    foreach ($abbrevs as $exponent => $abbrev) {
        if (abs($number) >= pow(10, $exponent)) {
            $display = $number / pow(10, $exponent);
            $decimals = ($exponent >= 3 && round($display) < 100) ? 1 : 0;
            $number = number_format($display, $decimals) . $abbrev;
            break;
        }
    }

    return $number;
}

// TRANSFER CREATE METHOD
function create_method($create_method)
{
    if ($create_method == 1) {
        return __('frontend.transfer_by_email');
    } elseif ($create_method == 2) {
        return __('frontend.generate_link');
    } else {
        return '';
    }
}

// TRANSFER STATUS
function transfer_status($tranfer_status, $create_method)
{
    if ($tranfer_status == 1) {
        if ($create_method == 1) {
            return "<span class='badge bg-success me-1'></span> " . __('frontend.transfered');
        } elseif ($create_method == 2) {
            return "<span class='badge bg-success me-1'></span> " . __('frontend.generated');
        }
    } else {
        return "<span class='badge bg-danger me-1'></span> " . __('frontend.canceled');
    }
}

// GET ICON FILES
function fileIcon($filename)
{
    $types = array('css', 'csv', 'doc', 'exe', 'html', 'iso', 'jpeg', 'jpg', 'mp3', 'mp4', 'pdf', 'png', 'psd', 'svg', 'txt', 'xls', 'xlsx', 'xml', 'zip', 'rar');
    $arr = explode('.', $filename);
    $icon = $arr[1] . '.svg';
    $iconPath = "images/icons/" . $icon;
    $unknownIconPath = "images/icons/file.svg";
    if (in_array($arr[1], $types)) {
        return asset($iconPath);
    } else {
        return asset($unknownIconPath);
    }

}

// Past date
function expiry($date)
{
    $format = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date);
    if ($format->isPast() == true) {
        return "text-danger";
    } else {
        return "text-success";
    }

}
