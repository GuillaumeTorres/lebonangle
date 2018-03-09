<?php
/**
 * JsonWebTokenService file
 *
 * PHP Version 7.1
 *
 * @category Service
 *
 * @package  AppBundle\Service
 */
namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\AuthorizationHeaderTokenExtractor;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class JsonWebTokenService
 * @package AppBundle\Service
 */
class JsonWebTokenService
{
    private $jwtEncoder;
    private $entityManager;

    /**
     * JsonWebTokenService constructor.
     *
     * @param JWTEncoderInterface    $jwtEncoder
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(JWTEncoderInterface $jwtEncoder, EntityManagerInterface $entityManager)
    {
        $this->jwtEncoder = $jwtEncoder;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     *
     * @return null|User
     */
    public function getUser(Request $request)
    {
        $token = $this->getToken($request);
        if (!$token) {
            return null;
        }
        try {
            $data = $this->jwtEncoder->decode($token);
        } catch (\Exception $e) {
            return null;
        }
        $user = $this->entityManager->getRepository('AppBundle:User')->findOneBy([
            'username' => $data['username'],
        ]);

        return $user;
    }

    /**
     * @param Request $request
     *
     * @return array|bool|false|null|string
     */
    private function getToken(Request $request)
    {
        $extractor = new AuthorizationHeaderTokenExtractor(
            'Bearer',
            'Authorization'
        );
        $token = $extractor->extract($request);
        if (!$token) {
            return null;
        }

        return $token;
    }
}