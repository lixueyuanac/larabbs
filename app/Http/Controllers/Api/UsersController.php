<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use App\Models\Image;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            return $this->response->error('验证码已失效', 422);
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            // 返回401
            return $this->response->errorUnauthorized('验证码错误');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);

        // 清除验证码缓存
        \Cache::forget($request->verification_key);

        return $this->response->item($user, new UserTransformer())
            ->setStatusCode(201);
    }

    public function weappStore(UserRequest $request)
    {
        //接受参数 code,phone,password,wexin_openid
        $verifyData = Cache::get($request->verification_key);
        if (!$verifyData) {
            $this->response->error('验证码错误', 422);
        }
        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            $this->response->errorUnauthorized('验证码错误');
        }
        //获取微信的session_key 和open_id
        $miniProgram = \EasyWeChat::miniProgram();
        $data = $miniProgram->auth->session($request->code);
        if (isset($data['errorCode'])) {
            return $this->response->errorUnauthorized('code 错误');
        }
        //如果openid 对应的用户已经存在则报错403
        $user = User::where('weixin_openid', $data['openid'])->first();
        if ($user) {
            return $this->response->error('微信号已经绑定用户，请直接登录', 403);
        }
        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
            'weapp_openid' => $data['openid'],
            'weapp_session_key' => $data['session_key'],
        ]);
        Cache::forget($request->verification_key);
        return $this->response->item($user, new UserTransformer())
            ->setMeta([
                'access_token' => \Auth::guard('api')->fromUser($user),
                'token_type' => 'Bearer',
                'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
            ])
            ->setStatusCode(201);
    }
    public function show(User $user){
        return $this->response->item($user,new UserTransformer());
    }
    public function me()
    {
        return $this->response->item($this->user(), new UserTransformer());
    }

    public function update(UserRequest $request)
    {
        $user = $this->user();

        $attributes = $request->only(['name', 'email', 'introduction']);

        if ($request->avatar_image_id) {
            $image = Image::find($request->avatar_image_id);

            $attributes['avatar'] = $image->path;
        }
        $user->update($attributes);

        return $this->response->item($user, new UserTransformer());
    }

    public function activedIndex(User $user)
    {
        return $this->response->collection($user->getActiveUsers(), new UserTransformer());
    }
}