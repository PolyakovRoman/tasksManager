<?php

namespace App\User\Presentation\Controller;

use App\User\Domain\Repository\UserRepositoryInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Shared\Domain\Traits\ApiResponseTrait;
use App\User\Application\Service\CreateUserService;
use App\User\Application\Service\UpdateUserService;
use App\Shared\Domain\Exception\DefaultException;
use App\User\Presentation\Response\UserResponse;
use App\User\Presentation\Request\UserRequest;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    use ApiResponseTrait;

    public function __construct(
        private CreateUserService $createUserService,
        private UpdateUserService $updateUserService,
        private UserRequest $userRequest,
        private UserResponse $userResponse,
        private UserRepositoryInterface $userRepository
    ) {}

    #[Route('/api/login', name: 'api_user_login', methods: ['POST'])]
    public function login(): JsonResponse
    {
        return $this->apiResponse(false, [], [], JsonResponse::HTTP_NOT_FOUND);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/api/registration', name: 'api_user_registration', methods: ['POST'])]
    public function registration(
        Request $request
    ): JsonResponse
    {
        try {
            $dto = $this->userRequest->registration($request);
            $this->createUserService->execute($dto);
        } catch (DefaultException $e) {
            return $this->apiResponse(false, null, $e->getData(), JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->apiResponse(true, []);
    }

/**
 * @param Request $request
 * @return JsonResponse
 */
    #[Route('/api/user', name: 'api_user_create', methods: ['POST'])]
    public function create(
        Request $request
    ): JsonResponse
    {
        try {
            $dto = $this->userRequest->create($request);
            $this->createUserService->execute($dto);
        } catch (DefaultException $e) {
            return $this->apiResponse(false, null, $e->getData(), JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->apiResponse(true, []);
    }

    #[Route('/api/user/{id}', name: 'api_user_update', methods: ['PATCH', 'PUT'])]
    public function update(
        Request $request,
        int $id
    ): JsonResponse
    {
        try {
            $dto = $this->userRequest->update($request);
            $this->updateUserService->execute($dto, $id);
        } catch (DefaultException $e) {
            return $this->apiResponse(false, null, $e->getData(), JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->apiResponse(true, []);
    }

    #[Route('/api/user/{id}', name: 'api_user_get', methods: ['GET'])]
    public function get(
        int $id
    ): JsonResponse
    {
        $user = $this->userRepository->findById($id);

        if(!$user){
            return $this->apiResponse(false, [], ['The user was not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->apiResponse(
            true,
            $this->userResponse->toListItem($user)->toArray()
        );
    }

    #[Route('/api/user', name: 'api_user_all', methods: ['GET'])]
    public function all(
        Request $request,
        PaginatorInterface $paginator
    ): JsonResponse
    {
        $query = $this->userRepository->getUsersListQuery();
        $paginate = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 20)
        );

        $items = array_map(
            function ($user) {
                return $this->userResponse->toListItem($user)->toArray();
            },
            $paginate->getItems()
        );

        return $this->apiResponse(
            true,
            [
                'items' => $items,
                'meta' => [
                    'page' => $paginate->getCurrentPageNumber(),
                    'limit' => $paginate->getItemNumberPerPage(),
                    'totalItems' => $paginate->getTotalItemCount(),
                    'totalPages' => ceil($paginate->getTotalItemCount() / $paginate->getItemNumberPerPage())
                ]
            ]
        );
    }
}