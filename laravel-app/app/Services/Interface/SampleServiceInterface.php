<?php

namespace App\Services\Interface;

interface SampleServiceInterface
{
    /**
     * ユーザーリスト取得
     *
     * @return array ユーザー一覧
     */
    public function getUserList(): array;

    /**
     * ユーザー取得
     *
     * @param integer $id ユーザーID
     * @return object|null ユーザーオブジェクト
     */
    public function getUser(int $id): ?object;

    /**
     * ユーザー登録
     *
     * @param object $user ユーザーオブジェクト
     * @return boolean 登録結果
     */
    public function createUser(object $user): bool;

    /**
     * Undocumented function
     *
     * @param object $user ユーザーオブジェクト
     * @return boolean 更新結果
     */
    public function updateUser(object $user): bool;

    /**
     * Undocumented function
     *
     * @param integer $id ユーザーID
     * @return boolean 削除結果
     */
    public function deleteUser(int $id): bool;
}
