<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    // Set Env function
    private function setEnv($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name), $name . '=' . $value, file_get_contents($path)));
        }
    }

    // Get settings data
    private function settings()
    {
        // get settings data
        $settings = DB::table('settings')->find(1);
        return $settings;
    }

    // View settings nformation page
    public function information()
    {
        return view('backend.settings.information', ['settings' => $this->settings()]);
    }

    // Storage settings infrmation
    public function information_store(Request $request)
    {
        // Validae form
        $validator = Validator::make($request->all(), [
            'website_name' => ['required', 'string'],
            'website_storage' => ['required', 'numeric'],
            'website_currency' => ['required'],
            'max_files' => ['required', 'numeric'],
            'max_upload_size' => ['required', 'numeric'],
            'free_storage' => ['required', 'numeric'],
            'home_heading' => ['required', 'string', 'max:255'],
            'home_description' => ['required', 'string'],
            'website_main_color' => ['required'],
            'website_sec_color' => ['required'],
            'email_verification' => ['required', 'numeric'],
        ]);

        // Send errors to view page
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // check request storage
        if ($request->website_storage != 1 && $request->website_storage != 2) {
            return redirect()->back()->withErrors(['Storage error, please refresh page and try again']);
        }

        // check if amazon information is null
        if ($request->website_storage == 2) {
            if (env('AWS_ACCESS_KEY_ID') == null or
                env('AWS_SECRET_ACCESS_KEY') == null or
                env('AWS_DEFAULT_REGION') == null or
                env('AWS_BUCKET') == null or
                env('AWS_URL') == null) {
                // Error response
                return redirect()->back()->withErrors(['Amazon S3 information is missing']);
            }
        }

        // check request currency
        $currency = array('USD', 'EUR', 'CAD', 'GBP', 'CZK', 'AUD');
        if (!in_array($request->website_currency, $currency)) {
            return redirect()->back()->withErrors(['Currency error, please refresh page and try again']);
        }

        // check email verification
        if ($request->email_verification != 1 && $request->email_verification != 2) {
            return redirect()->back()->withErrors(['Email verification error']);
        }

        // check request max files
        if ($request->max_files < 1) {
            return redirect()->back()->withErrors(['Max files cannot be less than 1']);
        }

        // check request max upload size
        if ($request->max_upload_size < 1) {
            return redirect()->back()->withErrors(['Max file size cannot be less than 1']);
        }

        // update data
        $update = DB::table('settings')->where('id', 1)->update([
            'website_name' => $request->website_name,
            'google_analytics' => $request->google_analytics,
            'website_storage' => $request->website_storage,
            'website_currency' => $request->website_currency,
            'max_files' => $request->max_files,
            'max_upload_size' => $request->max_upload_size,
            'free_storage' => $request->free_storage,
            'home_heading' => $request->home_heading,
            'home_description' => $request->home_description,
            'home_message' => $request->home_message,
            'website_main_color' => $request->website_main_color,
            'website_sec_color' => $request->website_sec_color,
            'email_verification' => $request->email_verification,
        ]);

        // if update
        if ($update) {
            // Set on env file
            $this->setEnv('WEBSITE_CURRENCY', $request->website_currency);
            // Back with success message
            $request->session()->flash('success', 'Updated successfully');
            return back();
        } else {
            return redirect()->back()->withErrors(['You need to make a change to update']);
        }
    }

    // identity store logo & favicon
    public function identity_store(Request $request)
    {
        // Validate form
        $validator = Validator::make($request->all(), [
            'logo' => ['max:2048', 'mimes:png,jpg,jpeg,svg'],
            'favicon' => ['max:2048', 'mimes:ico,png,jpg,jpeg'],
        ]);

        // Send errors to view page
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // Files path
        $path = 'images/main/';
        // Get current logo and favicon
        $logo = $this->settings()->logo;
        $favicon = $this->settings()->favicon;

        // if request logo is not null
        if ($request['logo'] != null) {
            // if favicon is not null
            if ($request['favicon'] != null) {
                // Check if file exist
                if (file_exists($path . $logo)) {
                    $deleteOldLogo = File::delete($path . $logo); // delete old logo
                }
                if (file_exists($path . $favicon)) {
                    $deleteOldFavicon = File::delete($path . $favicon); // delete old favicon
                }
                // Lets update New logo and new favicon
                $logo_name = 'logo.' . $request->logo->getclientoriginalextension();
                $fav_name = 'favicon.' . $request->favicon->getclientoriginalextension();
                $request->logo->move($path, $logo_name);
                $request->favicon->move($path, $fav_name);
                // Update logo & favicon
                $update = DB::table('settings')->where('id', 1)->update(['logo' => $logo_name, 'favicon' => $fav_name]);
            } else {
                // Check if file exist
                if (file_exists($path . $logo)) {
                    $deleteOldLogo = File::delete($path . $logo); // delete old logo
                }
                // Lets update New logo
                $logo_name = 'logo.' . $request->logo->getclientoriginalextension();
                $request->logo->move($path, $logo_name);
                // Update logo
                $update = DB::table('settings')->where('id', 1)->update(['logo' => $logo_name]);
            }
        } else {
            // check if favicon is not null
            if ($request['favicon'] != null) {
                // Check if file exist
                if (file_exists($path . $favicon)) {
                    $deleteOldFavicon = File::delete($path . $favicon); // delete old favicon
                }
                // Lets update New favicon
                $fav_name = 'favicon.' . $request->favicon->getclientoriginalextension();
                $request->favicon->move($path, $fav_name);
                // Update favicon
                $update = DB::table('settings')->where('id', 1)->update(['favicon' => $fav_name]);
            } else {
                // Back with error
                return redirect()->back()->withErrors(['You must upload new logo or favicon']);
            }
        }

        // Back with success message
        $request->session()->flash('success', 'Updated successfully');
        return back();

    }

    // view payments page
    public function payments()
    {
        // Get paypal data
        $paypal = DB::table('paypal')->find(1);
        // Get stripe data
        $stripe = DB::table('stripe')->find(1);
        return view('backend.settings.payments', ['paypal' => $paypal, 'stripe' => $stripe]);
    }

    // Update paypal information
    public function paypal_payments_store(Request $request)
    {
        // check request status
        $status_arr = array('1', '2');
        if (!in_array($request->status, $status_arr)) {
            return redirect()->back()->withErrors(['Wrong status, please refresh page and try again']);
        }

        // Check if status is Active
        if ($request->status == 1) {
            // Validae form
            $validator = Validator::make($request->all(), [
                'paypal_test_mode' => ['required', 'numeric'],
                'paypal_client_id' => ['required', 'string'],
                'paypal_client_secret' => ['required', 'string'],
            ]);

            // Send errors to view page
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
        }

        // check request test mode
        $test_mode_arr = array('1', '2');
        if (!in_array($request->paypal_test_mode, $test_mode_arr)) {
            return redirect()->back()->withErrors(['Test mode error, please refresh page and try again']);
        }

        // update data
        $update = DB::table('paypal')->where('id', 1)->update([
            'status' => $request->status,
            'paypal_test_mode' => $request->paypal_test_mode,
            'paypal_client_id' => $request->paypal_client_id,
            'paypal_client_secret' => $request->paypal_client_secret,
        ]);

        // if update
        if ($update) {
            // Set on env file
            $this->setEnv('PAYPAL_TEST_MODE', $request->paypal_test_mode);
            $this->setEnv('PAYPAL_CLIENT_ID', $request->paypal_client_id);
            $this->setEnv('PAYPAL_CLIENT_SECRET', $request->paypal_client_secret);
            // Back with success message
            $request->session()->flash('success', 'Updated successfully');
            return back();
        } else {
            return redirect()->back()->withErrors(['You need to make a change to update']);
        }
    }

    // Update stripe information
    public function stripe_payments_store(Request $request)
    {
        // check request status
        $status_arr = array('1', '2');
        if (!in_array($request->status, $status_arr)) {
            return redirect()->back()->withErrors(['Wrong status, please refresh page and try again']);
        }

        // Check if status is Active
        if ($request->status == 1) {
            // Validae form
            $validator = Validator::make($request->all(), [
                'stripe_publishable_key' => ['required'],
                'stripe_secret_key' => ['required'],
            ]);

            // Send errors to view page
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
        }

        // update data
        $update = DB::table('stripe')->where('id', 1)->update([
            'status' => $request->status,
            'stripe_publishable_key' => $request->stripe_publishable_key,
            'stripe_secret_key' => $request->stripe_secret_key,
        ]);

        // if update
        if ($update) {
            // Set on env file
            $this->setEnv('STRIPE_PUBLISHABLE_KEY', $request->stripe_publishable_key);
            $this->setEnv('STRIPE_SECRET_KEY', $request->stripe_secret_key);
            // Back with success message
            $request->session()->flash('success', 'Updated successfully');
            return back();
        } else {
            return redirect()->back()->withErrors(['You need to make a change to update']);
        }
    }

    // View google captcha page
    public function captcha()
    {
        // Get api data
        $api = DB::table('api')->find(1);
        return view('backend.settings.captcha', ['api' => $api]);
    }

    // Update captcha information
    public function captcha_store(Request $request)
    {
        // update data
        $update = DB::table('api')->where('id', 1)->update([
            'google_captcha_sitekey' => $request->google_captcha_sitekey,
            'google_captcha_secret' => $request->google_captcha_secret,
        ]);

        // if update
        if ($update) {
            // Set on env file
            $this->setEnv('NOCAPTCHA_SITEKEY', $request->google_captcha_sitekey);
            $this->setEnv('NOCAPTCHA_SECRET', $request->google_captcha_secret);
            // Back with success message
            $request->session()->flash('success', 'Updated successfully');
            return back();
        } else {
            return redirect()->back()->withErrors(['You need to make a change to update']);
        }
    }

    // View seo page
    public function seo()
    {
        // get seo data
        $seo = DB::table('seo')->find(1);
        return view('backend.settings.seo', ['seo' => $seo]);
    }

    // Store seo date
    public function seo_store(Request $request)
    {
        // Validate form
        $validator = Validator::make($request->all(), [
            'seo_title' => ['required', 'string', 'max:100'],
            'seo_description' => ['max:300'],
            'seo_keywords' => ['max:250'],
        ]);

        // Send errors to view page
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // Update seo
        $updateSeo = DB::table('seo')->where('id', 1)->update([
            'seo_title' => $request['seo_title'],
            'seo_description' => $request['seo_description'],
            'seo_keywords' => $request['seo_keywords'],
        ]);

        if ($updateSeo) {
            // Back with success message
            $request->session()->flash('success', 'Updated successfully');
            return back();
        } else {
            // Error response
            return redirect()->back()->withErrors(['You need to make a change to update']);
        }
    }

    // View smtp page
    public function smtp()
    {
        // get smtp data
        $smtp = DB::table('smtp')->find(1);
        return view('backend.settings.smtp', ['smtp' => $smtp]);
    }

    // smtp data store
    public function smtp_store(Request $request)
    {
        // Validae form
        $validator = Validator::make($request->all(), [
            'mail_mailer' => ['required', 'string'],
            'mail_host' => ['required'],
            'mail_port' => ['required', 'numeric'],
            'mail_username' => ['required', 'string'],
            'mail_password' => ['required', 'string'],
            'mail_encryption' => ['required', 'string'],
            'mail_form_email' => ['required', 'string'],
            'mail_from_name' => ['required', 'string'],
        ]);

        // Send errors to view page
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // check mailer
        $mailer = array('smtp', 'sendmail');
        if (!in_array($request->mail_mailer, $mailer)) {
            return redirect()->back()->withErrors(['Mailer error, please refresh page and try again']);
        }

        // check encryption
        $encryption = array('tls', 'ssl');
        if (!in_array($request->mail_encryption, $encryption)) {
            return redirect()->back()->withErrors(['Encryption error, please refresh page and try again']);
        }

        // update data
        $update = DB::table('smtp')->where('id', 1)->update([
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_form_email' => $request->mail_form_email,
            'mail_from_name' => $request->mail_from_name,
        ]);

        // if update
        if ($update) {
            // Set on env file
            $this->setEnv('MAIL_MAILER', $request->mail_mailer);
            $this->setEnv('MAIL_HOST', $request->mail_host);
            $this->setEnv('MAIL_PORT', $request->mail_port);
            $this->setEnv('MAIL_USERNAME', $request->mail_username);
            $this->setEnv('MAIL_PASSWORD', $request->mail_password);
            $this->setEnv('MAIL_ENCRYPTION', $request->mail_encryption);
            $this->setEnv('MAIL_FROM_ADDRESS', $request->mail_form_email);
            $this->setEnv('MAIL_FROM_NAME', $request->mail_from_name);
            // Back with success message
            $request->session()->flash('success', 'Updated successfully');
            return back();
        } else {
            // Error response
            return redirect()->back()->withErrors(['You need to make a change to update']);
        }
    }

    // View amazon s3 page
    public function amazon()
    {
        // Get amazon s3 data
        $amazon = DB::table('amazon')->find(1);
        return view('backend.settings.amazon', ['amazon' => $amazon]);
    }

    // Amazon s3 store
    public function amazon_store(Request $request)
    {
        // get settings info
        if ($this->settings()->website_storage == 2) {
            // Error response
            return redirect()->back()->withErrors(['You are using amazon s3 as storage please change it on the information section then you can update it']);
        }

        // Update amazon s3
        $update = DB::table('amazon')->where('id', 1)->update([
            'aws_access_key_id' => $request->aws_access_key_id,
            'aws_secret_access_key' => $request->aws_secret_access_key,
            'aws_default_region' => $request->aws_default_region,
            'aws_bucket' => $request->aws_bucket,
            'aws_url' => $request->aws_url,
        ]);

        // if update
        if ($update) {
            // Set on env file
            $this->setEnv('AWS_ACCESS_KEY_ID', $request->aws_access_key_id);
            $this->setEnv('AWS_SECRET_ACCESS_KEY', $request->aws_secret_access_key);
            $this->setEnv('AWS_DEFAULT_REGION', $request->aws_default_region);
            $this->setEnv('AWS_BUCKET', $request->aws_bucket);
            $this->setEnv('AWS_URL', $request->aws_url);
            // Back with success message
            $request->session()->flash('success', 'Updated successfully');
            return back();
        } else {
            // Error response
            return redirect()->back()->withErrors(['You need to make a change to update']);
        }
    }
}
