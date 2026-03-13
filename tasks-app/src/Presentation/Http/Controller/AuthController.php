<?php
namespace App\Presentation\Http\Controller;

use App\Application\DTO\RegistrationRequest;
use App\Domain\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Shared\Traits\ApiResponseTrait;
use App\Domain\Enum\RoleLevel;
use Doctrine\ORM\EntityManagerInterface;
use App\Application\UseCase\UserExistsUseCase;

class AuthController extends AbstractController
{
    use ApiResponseTrait;

    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em,
        private UserExistsUseCase $userExistsUseCase
    )
    {
        $this->em = $em;
    }

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(): void
    {
        throw new \LogicException('security');
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param UserPasswordHasherInterface $hasher
     * @return JsonResponse
     */
    #[Route('/api/registration', name: 'api_registration', methods: ['POST'])]
    public function registration(
        Request $request,
        ValidatorInterface $validator,
        UserPasswordHasherInterface $hasher
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $userDto = new RegistrationRequest();
        $userDto->name = isset($data['name']) ? $data['name'] : '';
        $userDto->email = isset($data['email']) ? $data['email'] : '';
        $userDto->phone = isset($data['phone']) ? preg_replace("/[^0-9]/", "", $data['phone']) : '';
        $userDto->password = isset($data['password']) ? $data['password'] : '';

        $validation = $validator->validate($userDto);
        if(count($validation) > 0){
            $errors = array();
            foreach ($validation as $error){
                $errors[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->apiResponse(false, null, $errors, 400);
        }

        if($this->userExistsUseCase->execute($userDto->email)){
            return $this->apiResponse(false, null, ['email' => 'The user with this email already exists'], 400);
        }

        $user = new User();
        $user->setEmail($userDto->email);
        $user->setPhone($userDto->phone);
        $user->setName($userDto->name);
        $user->setRole(RoleLevel::ROLE_USER);
        $user->setPassword($hasher->hashPassword($user, $userDto->password));

        $this->em->persist($user);
        $this->em->flush();

        return $this->apiResponse(true, null);
    }
}