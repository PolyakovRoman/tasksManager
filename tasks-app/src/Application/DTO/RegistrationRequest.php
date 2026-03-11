<?

namespace App\Application\DTO;

use Symfony\Component\Validator\Constraints as Validator;

class RegistrationRequest
{
    #[Validator\NotBlank]
    #[Validator\Email]
    public string $email;

    #[Validator\NotBlank]
    #[Validator\Length(min: 6)]
    public string $password;

    #[Validator\NotBlank]
    #[Validator\Length(min: 2, max: 50)]
    public string $name;

    #[Validator\Regex(
        pattern: '/^\d{11}$/',
        message: 'Enter the correct Russian phone number'
    )]
    public ?string $phone = null;
}