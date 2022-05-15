<?php
namespace App\Model;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use App\Entity\User;

class UserModel
{
    public function toJSON(User $userEntity): ?string
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        try
        {
            // $outData = $serializer->serialize($userEntity, 'json');
            $outData = $serializer->serialize($serializer->normalize($userEntity, 'null', [AbstractNormalizer::ATTRIBUTES => ['name', 'email', 'role', 'password']]), 'json');
        } catch (Exception $e)
        {
            return null;
        }
        
        return $outData;
    }

    public function fromJSONToUser($data): ?User
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        try
        {
            $outUser = $serializer->deserialize($data, User::class, 'json');
        } catch (Exception $e)
        {
            return null;
        }
        
        return $outUser;
    }
}