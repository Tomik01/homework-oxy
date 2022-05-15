<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;
use App\Model\UserModel;
use Exception;

class RESTController extends AbstractController
{
    private $userRepository;
    private $entityManager;


    public function __construct(EntityManagerInterface $em)
    {
       $this->userRepository = $em->getRepository(User::class);
       $this->entityManager = $em;
    }


    /**
     * @Route("/rest/saveuser", name="restSaveUser")
     */
    public function saveUser($data): Response
    {
        $userModel = new UserModel();

        $user = $userModel->fromJSONToUser($data);

        $status = "";

        $goBack = '<p><a href="'.$this->generateUrl('newUser').'"><button name="back" type="button">Zpět na registraci</button></a></p>';

        try
        {
            $this->userRepository->newUser($user);
        } catch (Exception $e)
        {
            $status = "<p>Nastala chyba při ukládání uživatele. Chyba $e.</p>";
        } finally
        {
            if (empty($status))
            {
                $status = "<p>ÚSPĚCH! Uživatel byl úspěšně zaregistrován.</p>";
            }
        }
        
        return new Response(
            '<html><body>
                '.$status.$goBack.'
            </body></html>'
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/rest/allusers", name="restReadAllUsers")
     */
    public function readAllUsers(): Response
    {
        $users = $this->userRepository->readAllUsers();

        return $this->render('user/all.html.twig', [
            'users' => $users,
        ]);
    }
}