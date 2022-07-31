<?php

namespace App\Services\Implements;

use App\Services\Interface\SampleServiceInterface;
use App\Repositories\Interface\SampleRepositoryInterface;

class SampleService implements SampleServiceInterface
{
    private $sampleRepository;

    /**
     * コンストラクタDI
     *
     * @param SampleRepositoryInterface $sampleRepository サンプルリポジトリ
     */
    public function __construct(
        SampleRepositoryInterface $sampleRepository
    ) {
        $this->sampleRepository = $sampleRepository;
    }

    /**
     * ユーザーリスト取得
     *
     * @return array ユーザー一覧
     */
    public function getUserList(): array
    {
        $userList = $this->sampleRepository->getUserList();

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
        $user = $this->sampleRepository->getUser($id);

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
        $result = $this->sampleRepository->createUser($user);

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
        $result = $this->sampleRepository->updateUser($user);

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
        $result = $this->sampleRepository->deleteUser($id);

        return $result;
    }
}
