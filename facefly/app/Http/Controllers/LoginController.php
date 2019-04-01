<?php
namespace App\Http\Controllers;

use App\Model\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;


class LoginController extends Controller {

    use AuthenticatesUsers;

    public function index() {
        return view('/login');
    }

    protected function hasTooManyLoginAttempts(Request $request) {
        return $this->limiter()->tooManyAttempts(
                        $this->throttleKey($request), 3, 30 // <--- Change this
        );
    }

    public function postLogin(Request $request) {
        $user = new Login();
        $validator = Validator::make($request->all(), [
                    'user_email' => 'required|email',
                    'user_password' => 'required|min:6'
                        ], [
                    'user_email.required' => 'Email không đúng !',
                    'user_email.email' => 'Email không hợp lệ !',
                    'user_password.required' => 'Password không đúng !',
                    'user_password.min' => 'Password phải chứa 6 kí tự trở lên !',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $email = $request->input('user_email');
            $password = $request->input('user_password');

            $data = $user->firstUser($email);

            if ($data->user_status == 0) {
                $minutes = round((time() - strtotime($data->user_last_access)) / 60);
                if ($minutes <= 30) {
                    $errors = new MessageBag(['errorlogin' => 'Tài khoản đã bị khóa !']);
                    return redirect('/login')->withInput()->withErrors($errors);
                } else {
                    $user->updateTime($email);

                    if (Auth::attempt(['user_email' => $email, 'password' => $password])) {
                        Session::put('user_first_name', $data->user_first_name);
                        Session::put('user_last_name', $data->user_last_name);
                        Session::put('user_email', $data->user_email);
                        Session::get('user_id', $data->user_id);
                        Session::put('login', TRUE);

                        $user->updateTime($email);

                        return redirect()->route('index')->with('success', 'Đăng nhâp thành công !');
                    } else {
                        DB::table('users')
                                ->where('user_email', $email)
                                ->update(['user_attempt' => ($data->user_attempt) + 1,
                                    'user_last_access' => date('Y-m-d H:i:s'),]);

                        if (($data->user_attempt) + 1 > 3) {
                            DB::table('users')
                                    ->where('user_email', $email)
                                    ->update(['user_status' => 0,
                                        'user_last_access' => date('Y-m-d H:i:s'),]);
                            $errors = new MessageBag(['errorlogin' => 'Tài khoản đã bị khóa !']);
                            return redirect('/login')->withInput()->withErrors($errors);
                        }

                        $errors = new MessageBag(['errorlogin' => 'Email hoặc Password không đúng ! ']);
                        return redirect('/login')->withInput($request->except('user_password'))->withErrors($errors);
                    }
                }
            } else {
                if (Auth::attempt(['user_email' => $email, 'password' => $password])) {
                    Session::put('user_first_name', $data->user_first_name);
                    Session::put('user_last_name', $data->user_last_name);
                    Session::put('user_email', $data->user_email);
                    Session::put('login', TRUE);

                    $user->updateTime($email);

                    return redirect()->route('index')->with('success', 'Đăng nhập thành công !');
                } else {
                    DB::table('users')
                            ->where('user_email', $email)
                            ->update(['user_attempt' => ($data->user_attempt) + 1,
                                'user_last_access' => date('Y-m-d H:i:s'),]);

                    if (($data->user_attempt) + 1 > 3) {
                        DB::table('users')
                                ->where('user_email', $email)
                                ->update(['user_status' => 0,
                                    'user_last_access' => date('Y-m-d H:i:s'),]);
                        $errors = new MessageBag(['errorlogin' => 'Tài khoản đã bị khóa !']);
                        return redirect('/login')->withInput()->withErrors($errors);
                    }

                    $errors = new MessageBag(['errorlogin' => 'Email hoặc Password không đúng !']);
                    return redirect('/login')->withInput($request->except('user_password'))->withErrors($errors);
                }
            }
        }
    }

    public function logout() {
        Auth::logout();
        Session::put('login', FALSE);
        return redirect()->route('login');
    }

}
