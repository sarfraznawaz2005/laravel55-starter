<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 1/15/2017
 * Time: 3:36 PM
 */

use Modules\Core\Recipients\DynamicRecipient;

function appName()
{
    return config('app.name');
}

function modulePath($moduleName)
{
    return module_path($moduleName);
}

/**
 * Enable or disable query log.
 *
 * @param bool $enable
 */
function queryLog($enable = true)
{
    if ($enable) {
        \DB::connection()->enableQueryLog();
    } else {
        \DB::connection()->disableQueryLog();
    }
}

/**
 * @return mixed
 * This function return last executed query in plain sql
 */
function getLastQuery()
{
    $query = \DB::getQueryLog();
    $lastQuery = end($query);

    return $lastQuery;
}

/**
 * displays message on console and also appends in log
 *
 * @param $message
 * @param bool $log
 */
function out($message, $log = true)
{
    echo $message . PHP_EOL;

    if ($log) {
        Log::info($message);
    }
}

/**
 * Shows general info message via SweetAlert
 *
 * @param $message
 */
function showAlert($message)
{
    alert($message)->persistent('Close');
}

/**
 * Returns instance of logged in user.
 *
 * @return \Illuminate\Contracts\Auth\Authenticatable|\Modules\User\Models\User
 */
function user()
{
    return auth()->user();
}

/**
 * Removes given field value from request
 *
 * @param $field
 */
function removeRequestVar($field)
{
    if (is_array($field)) {
        foreach ($field as $item) {
            request()->request->remove($item);
        }
    } else {
        request()->request->remove($field);
    }
}

/**
 * Adds a new value to request
 *
 * @param $name
 * @param $value
 */
function addRequestVar($name, $value)
{
    request()->request->add([$name => $value]);
}

/**
 * Removes given field value from request if it's empty
 *
 * @param $field
 */
function removeRequestVarIfEmpty($field)
{
    if (is_array($field)) {
        foreach ($field as $item) {
            if (trim(request()->$item) === '') {
                removeRequestVar($item);
            }
        }
    } else {
        if (trim(request()->$field) === '') {
            removeRequestVar($field);
        }
    }
}

/**
 * Removes given fields from update process if they are empty.
 *
 * @param $field
 * @param $model
 */
function avoidUpdateIfEmpty($field, $model)
{
    if (is_array($field)) {
        foreach ($field as $item) {
            avoidUpdateIfEmpty($item, $model);
        }
    } else {
        if (trim(request()->$field) === '' || is_null(request()->$field)) {
            removeRequestVar($field);

            if ($field === 'password') {
                removeRequestVar('password_confirmation');
                // don't re-hash password else it will be differnt value
                $model->autoHashPasswordAttributes = false;
                // pass the validation
                $model->password_confirmation = $model->$field;
            }
        }
    }
}

/**
 * if DataTable ajax frontend gets empty serverside response, this will avoid the error
 *
 * @return string
 */
function noDataTableResponse()
{
    return json_encode([
        "sEcho" => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    ]);
}

function title($title = '')
{
    \Meta::set('title', $title ?: appName());
}

function sendNotification($email, $object)
{
    $recipient = new DynamicRecipient($email);
    $recipient->notify($object);
}

/**
 * Uploads file
 *
 * @param $name
 * @param $destination
 * @param bool $overwrite
 * @return array|string
 * @internal param $rules
 */
function uploadFile($name, $destination, $overwrite = false)
{
    $errors = [];

    if (request()->has($name)) {

        // call following line from controller
        //$this->validate(request(), $rules);

        if (!File::isDirectory($destination)) {
            File::makeDirectory($destination, 493, true, true);
        }

        // clean prev files
        File::cleanDirectory($destination);

        if ($overwrite) {
            $fileName = str_slug($name) . '.' . request()->$name->getClientOriginalExtension();
        } else {
            $fileName = time() . '.' . request()->$name->getClientOriginalExtension();
        }

        $uploaded = request()->$name->move($destination, $fileName);

        if ($uploaded) {
            return $fileName;
        } else {
            $errors = ['Could not upload'];
        }
    }

    return $errors;
}

function toggleText($text, $encodeUrl = true, $key = 'abc12345')
{
    // return text unaltered if the key is blank
    if ($key == '') {
        return $text;
    }

    // remove the spaces in the key
    $key = str_replace(' ', '', $key);

    if (strlen($key) < 8) {
        exit('key error');
    }

    // set key length to be no more than 32 characters
    $key_len = strlen($key);

    if ($key_len > 32) {
        $key_len = 32;
    }

    $k = array(); // key array

    // fill key array with the bitwise AND of the ith key character and 0x1F
    for ($i = 0; $i < $key_len; ++$i) {
        $k[$i] = ord($key{$i}) & 0x1F;
    }

    // perform encryption/decryption
    for ($i = 0; $i < strlen($text); ++$i) {
        $e = ord($text{$i});
        // if the bitwise AND of this character and 0xE0 is non-zero
        // set this character to the bitwise XOR of itself
        // and the ith key element, wrapping around key length
        // else leave this character alone
        if ($e & 0xE0) {
            $text{$i} = chr($e ^ $k[$i % $key_len]);
        }
    }

    if ($encodeUrl) {
        return urlencode($text);
    }

    return $text;
}

function gravatar($email, $size = 100)
{
    $hash = md5(strtolower(trim($email)));

    $url = "https://www.gravatar.com/avatar/$hash?s=$size&r=g&d=404";

    $headers = get_headers($url, 1);

    if (substr($headers[0], 9, 3) == '200') {
        return "https://www.gravatar.com/avatar/$hash?s=$size&r=g&d=mm";
    }

    return '';
}

function saveGravatar($imgUrl, $destinationDir, $fileName = '')
{
    if (!file_exists($destinationDir)) {
        mkdir($destinationDir, 0755);
    }

    $fileName = $fileName ?: time() . '.jpg';
    $destinationDir = $destinationDir . DIRECTORY_SEPARATOR . $fileName;

    $result = copy($imgUrl, $destinationDir);

    return $result ? $fileName : false;
}

function getImageTakenDate($imagePath)
{
    if (file_exists($imagePath)) {
        @$exif = exif_read_data($imagePath);

        if (isset($exif['DateTimeOriginal'])) {
            return $exif['DateTimeOriginal'];
        }
    }

    return null;
}