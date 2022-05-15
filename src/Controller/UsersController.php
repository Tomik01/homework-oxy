<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Form\UserType;
use App\Model\UserModel;


class UsersController extends AbstractController
{
    /**
     * @Route("/main", name="usersForm")
     */
    public function usersForm(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/newuser", name="newUser")
     */
    public function newUser(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $userModel = new UserModel();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            $user->setPassword($passwordEncoder->encodePassword($user, $form->getData()->getPassword()));

            $sendData = $userModel->toJSON($user); 

            $response = $this->forward('App\Controller\RESTController::saveUser', [
                'data'  => $sendData,
            ]);
            return $response;

            // $response = $this->client->request('POST', 'http://localhost:8000/rest/saveuser', ['user_data' => $sendData]);
            // // return $this->redirectToRoute('restSaveUser', [$sendData])->methods(['POST']);

            // return $response;
            return new Response(
                '<html><body>Proběhlo uložení</body></html>'
            );
        }
        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}