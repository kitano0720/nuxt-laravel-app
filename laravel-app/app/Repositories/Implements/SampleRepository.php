<?php

namespace App\Repositories\Implements;

use App\Repositories\Interface\SampleRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * サンプルリポジトリインターフェース
 */
class SampleRepository implements SampleRepositoryInterface
{
    /**
     * ユーザーリスト取得
     *
     * @return array ユーザリスト
     */
    public function getUserList(): array
    {
        $userList = User::select(['id', 'name', 'email', 'age'])
            ->selectRaw('
                CASE 
                    WHEN gender = 1 THEN "男"
                    ELSE "女"
                END AS gender
            ')
            ->orderBy('id')
            ->get()
            ->all();

        return $userList;
    }

    /**
     * ユーザー取得
     *
     * @param integer $id ユーザーID
     * @return object|null ユーザーオブジェクト
     */
    public function getUser(int $id): ?object
    {
        $user = User::select(['id', 'name', 'email', 'age'])
            ->selectRaw('
                CASE 
                    WHEN gender = 1 THEN "男"
                    ELSE "女"
                END AS gender
            ')
            ->find($id);

        return $user;
    }

    /**
     * ユーザー登録
     *
     * @param object $user ユーザーオブジェクト
     * @return boolean 登録結果
     */
    public function createUser(object $user): bool
    {
        // パスワードを暗号化
        $user->password = Hash::make($user->password);

        $userModel = new User;

        $result = $userModel
            ->fill((array) $user)
            ->save();

        return $result;
    }

    /**
     * ユーザー更新
     *
     * @param object $user ユーザーオブジェクト
     * @return boolean 更新結果
     */
    public function updateUser(object $user): bool
    {
        $userModel = User::find($user->id);

        $result = $userModel
            ->fill((array) $user)
            ->save();

        return $result;
    }

    /**
     * ユーザー削除
     *
     * @param integer $id ユーザーID
     * @return boolean 削除結果
     */
    public function deleteUser(int $id): bool
    {
        $userModel = User::find($id);

        $result = $userModel->delete();

        return $result;
    }
}
