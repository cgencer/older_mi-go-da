<?php

namespace App;

use App\Models\CouponCode;
use App\Models\Pages;
use Illuminate\Support\Facades\URL;

class Helpers
{
    public static function localizedCurrency($amount)
    {
        $fmt = numfmt_create('de_DE', \NumberFormatter::CURRENCY);
        $fmt->setTextAttribute(\NumberFormatter::CURRENCY_CODE, 'EUR');
        $fmt->setAttribute(\NumberFormatter::FRACTION_DIGITS, 2);

        return $fmt->formatCurrency($amount, 'EUR');
    }

    public static function getCurrentCurrencySymbol()
    {
        $fmt = numfmt_create('de_DE', \NumberFormatter::CURRENCY);

        return $fmt->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
    }

    public static function kilobytesToHuman($bytes)
    {
        $units = ['KB', 'MB', 'GB', 'TB', 'PB'];
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public static function array_flatten($array = null)
    {
        $result = array();

        if (!is_array($array)) {
            $array = func_get_args();
        }

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, self::array_flatten($value));
            } else {
                $result = array_merge($result, array($key => $value));
            }
        }
        return $result;
    }

    public static function reformatMeta($in)
    {
        $result = array();

// for testing:
//      $in['fees'] = '{"t":40320,"v":0,"s":504.25,"m":5040,"h":34775.75,"p":0,"xv":0,"xm":12.5,"x":100,"c":"eur"}';
        $crypt = ['t' => 'total', 'v' => 'vat', 's' => 'stripe', 'm' => 'migoda', 'h' => 'hotel', 'p' => 'penalty', 'xv' => 'vat_perc', 'xm' => 'migoda_perc', 'x' => 'multiplier', 'c' => 'currency'];

        foreach ($in as $key => $value) {
            if ($key === 'fees' && is_array($value) && array_key_exists('total', $value)) {
                // replaces keys into their shortcuts
                array_walk($value, function ($vv, $kk) use ($crypt, &$value) {
                    $newkey = array_key_exists($kk, array_flip($crypt)) ? array_flip($crypt)[$kk] : false;
                    if ($newkey !== false) {
                        $value[$newkey] = $vv;
                        unset($value[$kk]);
                    }
                });
                $result[$key] = json_encode($value);
            } else if ($key === 'fees' && $this->is_valid_json($value)) {
                // replaces shortcut-keys into their longer versions
                $res = (array)json_decode($value);
                array_walk($res, function ($vv, $kk) use ($crypt, &$res) {
                    $newkey = array_key_exists($kk, $crypt) ? $crypt[$kk] : false;
                    if ($newkey !== false) {
                        $res[$newkey] = $vv;
                        unset($res[$kk]);
                    }
                });
                $result[$key] = $res;
            } else {
                //other options: force all values into string and recursiveness
                if (is_array($value)) {
                    $result = array_merge($result, self::reformatMeta($value));
                } else {
                    $result = array_merge($result, array($key => $value));
                }
                $result[$key] = (string)$value;
            }
        }
        return ($result);
    }

    public function is_valid_json($raw_json)
    {
        return (json_decode($raw_json, true) == NULL) ? false : true;
    }

    public static function getAvailableCouponCode($prefix, $suffix, $length)
    {

        $strlen = $length - (strlen($prefix) + strlen($suffix));
        while (1) {
            $code = $prefix . self::generateNumber($strlen) . $suffix;
            $item = CouponCode::where('code', $code)->get()->count();
            if ($item > 0) continue;
            return $code;
        }
    }

    public static function getPageData($page_id)
    {
        $page = Pages::where("id", $page_id)->get();
        if ($page->count() > 0) {
            return $page->first();
        }
        return false;

    }

    public static function getCurrentPage($route = true)
    {
        if ($route) {
            if (\Illuminate\Support\Facades\Route::current()) {
                return \Illuminate\Support\Facades\Route::current()->getName();
            } else {
                return '';
            }
        } else {
            if (isset(parse_url(URL::current())['path'])) {
                return str_replace('/', '', parse_url(URL::current())['path']);
            } else {
                return '';
            }
        }
    }

    public static function generateNumber($length)
    {
        $output = random_int(1, 9);
        for ($i = 0; $i < ($length - 1); $i++) {
            $output .= random_int(0, 9);
        }
        return $output;
    }

    public static function get_rgb($color)
    {
        if (((int)$color) !== $color) {
            $color = trim($color, " \t\n\r#");

            if (ctype_xdigit($color) && strlen($color) === 6) {
                $color = (int)hexdec($color);
            } else {
                return false;
            }
        }
        return ['r' => (($color >> 16) & 0xFF) / 255,
            'g' => (($color >> 8) & 0xFF) / 255,
            'b' => ($color & 0xFF) / 255];
    }

    public static function varDumpToString($var)
    {
        ob_start();
        var_dump($var);
        $result = ob_get_clean();
        return $result;
    }

    public static function hex_dump($data, $newline = "\n")
    {
        static $from = '';
        static $to = '';

        static $width = 16; # number of bytes per line
        static $pad = '.'; # padding for non-visible characters

        if ($from === '') {
            for ($i = 0; $i <= 0xFF; $i++) {
                $from .= chr($i);
                $to .= ($i >= 0x20 && $i <= 0x7E) ? chr($i) : $pad;
            }
        }

        $hex = str_split(bin2hex($data), $width * 2);
        $chars = str_split(strtr($data, $from, $to), $width);

        $offset = 0;
        $rep = [];
        foreach ($hex as $i => $line) {
            $rep[] = sprintf('%6X', $offset) . ' : ' . implode(' ', str_split($line, 2)) . ' [' . $chars[$i] . ']' . $newline;
            $offset += $width;
        }
        return $rep;
    }

    public static function unicode2html($str)
    {
        // Set the locale to something that's UTF-8 capable
        setlocale(LC_ALL, 'en_US.UTF-8');
        // Convert the codepoints to entities
        $str = preg_replace("/u([0-9a-fA-F]{4})/", "&#x\\1;", $str);
        // Convert the entities to a UTF-8 string
        return iconv("UTF-8", "ISO-8859-1//TRANSLIT", $str);
    }

    public static function codepoint_encode($str)
    {
        return substr(json_encode($str), 1, -1);
    }

    public static function codepoint_decode($str)
    {
        return json_decode(sprintf('"%s"', $str));
    }

    public static function mb_internal_encoding($encoding = NULL)
    {
        return ($from_encoding === NULL) ? iconv_get_encoding() : iconv_set_encoding($encoding);
    }

    public static function mb_convert_encoding($str, $to_encoding, $from_encoding = NULL)
    {
        return iconv(($from_encoding === NULL) ? mb_internal_encoding() : $from_encoding, $to_encoding, $str);
    }

    public static function hoursRemaining($myDate)
    {
        $now = new \DateTime('now');
        $dateToCompare = new \DateTime($myDate);
        $twoDaysLater = $dateToCompare->modify('+2 day');

        $dateToCompare = new \DateTime($myDate);

        $interval = date_diff($dateToCompare, $now);

        if ($now > $twoDaysLater) {
            return -1;
        }

        return $interval->format('%h:%i:%s');
    }

    public static function repairSerializeString($value)
    {
        $regex = '/s:([0-9]+):"(.*?)"/';
        return preg_replace_callback(
            $regex, function ($match) {
            return "s:" . mb_strlen($match[2]) . ":\"" . $match[2] . "\"";
        },
            $value
        );
    }

    public static function mb_chr($ord, $encoding = 'UTF-8')
    {
        if ($encoding === 'UCS-4BE') {
            return pack("N", $ord);
        } else {
            return mb_convert_encoding(mb_chr($ord, 'UCS-4BE'), $encoding, 'UCS-4BE');
        }
    }

    public static function mb_ord($char, $encoding = 'UTF-8')
    {
        if ($encoding === 'UCS-4BE') {
            list(, $ord) = (strlen($char) === 4) ? @unpack('N', $char) : @unpack('n', $char);
            return $ord;
        } else {
            return mb_ord(mb_convert_encoding($char, 'UCS-4BE', $encoding), 'UCS-4BE');
        }
    }

    public static function mb_htmlentities($string, $hex = true, $encoding = 'UTF-8')
    {
        return preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($match) use ($hex) {
            return sprintf($hex ? '&#x%X;' : '&#%d;', mb_ord($match[0]));
        }, $string);
    }

    public static function mb_html_entity_decode($string, $flags = null, $encoding = 'UTF-8')
    {
        return html_entity_decode($string, ($flags === NULL) ? ENT_COMPAT | ENT_HTML401 : $flags, $encoding);
    }

}
