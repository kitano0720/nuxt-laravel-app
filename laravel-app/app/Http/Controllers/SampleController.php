<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\Interface\SampleServiceInterface;

/**
 * サンプルコントローラ
 */
class SampleController extends Controller
{
    private $sampleService;

    /**
     * コンストラクタDI
     *
     * @param SampleServiceInterface $sampleService サンプルサービス
     */
    public function __construct(
        SampleServiceInterface $sampleService
    ) {
        $this->sampleService = $sampleService;
    }

    /**
     * ユーザーリスト取得
     *
     * @param Request $request リクエストオブジェクト
     * @return JsonResponse Jsonレスポンス
     */
    public function getUserList(): JsonResponse
    {
        $userList = $this->sampleService->getUserList();

        return $this->jsonResponse(
            ['userList' => $userList],
            Response::HTTP_OK
        );
    }

    /**
     * 特定ユーザー取得
     *
     * @param Request $request リクエストオブジェクト
     * @return JsonResponse Jsonレスポンス
     */
    public function getUserById(Request $request): JsonResponse
    {
        $id = $request->id;

        $user = $this->sampleService->getUser($id);

        return $this->jsonResponse(
            ['user' => $user],
            Response::HTTP_OK
        );
    }

    /**
     * ユーザー登録
     *
     * @param Request $request リクエストオブジェクト
     * @return JsonResponse Jsonレスポンス
     */
    public function createUser(Request $request): JsonResponse
    {
        $user = (object) $request->user;

        $result = $this->sampleService->createUser($user);

        return $this->jsonResponse(
            ['result' => $result],
            Response::HTTP_OK
        );
    }

    /**
     * ユーザー更新
     *
     * @param Request $request リクエストオブジェクト
     * @return JsonResponse Jsonレスポンス
     */
    public function updateUser(Request $request): JsonResponse
    {
        $user = (object) $request->user;

        $result = $this->sampleService->updateUser($user);

        return $this->jsonResponse(
            ['result' => $result],
            Response::HTTP_OK
        );
    }

    /**
     * ユーザー削除
     *
     * @param Request $request リクエストオブジェクト
     * @return JsonResponse Jsonレスポンス
     */
    public function deleteUser(Request $request): JsonResponse
    {
        $id = $request->id;

        $result = $this->sampleService->deleteUser($id);

        return $this->jsonResponse(
            ['result' => $result],
            Response::HTTP_OK
        );
    }
}
